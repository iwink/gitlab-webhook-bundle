<?php

namespace Iwink\GitLabWebhookBundle\EventSubscriber;

use Doctrine\Common\Annotations\Reader as ReaderInterface;
use Iwink\GitLabWebhookBundle\Annotation\Webhook;
use Iwink\GitLabWebhookBundle\Event\Exception\InvalidWebhookRequestException;
use Iwink\GitLabWebhookBundle\Event\WebhookEvent;
use Iwink\GitLabWebhookBundle\Event\WebhookEventFactory;
use Iwink\GitLabWebhookBundle\Event\WebhookEventResolver;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

/**
 * Event subscriber to inject {@see WebhookEvent} instances on controller actions.
 * @since 1.0.0
 */
class GitLabWebhookSubscriber implements EventSubscriberInterface {
	/**
	 * Application environment.
	 * @since 1.0.0
	 * @var string
	 */
	private string $environment;

	/**
	 * Annotation reader.
	 * @since 1.0.0
	 * @var ReaderInterface
	 */
	private ReaderInterface $reader;

	/**
	 * Creates a new event subscriber.
	 * @since 1.0.0
	 * @param string $environment Application environment.
	 * @param ReaderInterface $reader Annotation reader.
	 */
	public function __construct(string $environment, ReaderInterface $reader) {
		$this->environment = $environment;
		$this->reader = $reader;
	}

	/**
	 * @inheritDoc
	 * @since $ver$
	 * @codeCoverageIgnore
	 */
	public static function getSubscribedEvents(): array {
		return [
			ControllerEvent::class => ['onController'],
			ControllerArgumentsEvent::class => ['onControllerArguments'],
			ExceptionEvent::class => ['onException'],
		];
	}

	/**
	 * Tries to resolve a {@see WebhookEvent} from a {@see Request} if the {@see Webhook} annotation is present.
	 * @since $ver$
	 * @param ControllerEvent $event The event.
	 */
	public function onController(ControllerEvent $event): void {
		try {
			$request = $event->getRequest();
			$attributes = $request->attributes;

			// Resolve annotations
			$method = new \ReflectionMethod($attributes->get('_controller'));
			$annotations = array_filter(
				$this->reader->getMethodAnnotations($method),
				static fn(object $annotation): bool => $annotation instanceof Webhook
			);

			// Resolve event types
			$webhookEventTypes = array_map(static fn(Webhook $webhook): string => $webhook->getEvent(), $annotations);
			$attributes->set('_has_gitlab_event', !empty($webhookEventTypes));
			if (!$attributes->getBoolean('_has_gitlab_event', false)) {
				return;
			}

			try {
				// A webhook controller only supports POST requests
				if ('POST' !== $request->getMethod()) {
					throw new MethodNotAllowedHttpException(['POST']);
				}

				// Create an event based on the request and check if it's valid
				$webhookEvent = WebhookEventFactory::createFromRequest($request);
				$webhookEvents = array_map([WebhookEventResolver::class, 'resolveClassByType'], $webhookEventTypes);
				if (!\in_array(get_class($webhookEvent), $webhookEvents, true)) {
					throw new BadRequestHttpException(sprintf(
						'This webhook doesn\'t support the "%s" event.',
						WebhookEventResolver::resolveTypeByClass(get_class($webhookEvent))
					));
				}

				// Store the event on the request attributes
				$attributes->set('_gitlab_event', $webhookEvent);
			} catch (InvalidWebhookRequestException $e) {
				throw new BadRequestHttpException($e->getMessage(), $e);
			}
		} catch (\ReflectionException $e) {
			// Pass, non-existing method or other callable
		}
	}

	/**
	 * Removes the {@see WebhookEvent} from {@see Request::$attributes} if it's a webhook request.
	 * @since $ver$
	 * @param ControllerArgumentsEvent $event The event.
	 */
	public function onControllerArguments(ControllerArgumentsEvent $event): void {
		$attributes = $event->getRequest()->attributes;
		if ($attributes->getBoolean('_has_gitlab_event', false)) {
			$attributes->remove('_gitlab_event');
		}
	}

	/**
	 * Returns a JSON response if it's a webhook request.
	 * @since $ver$
	 * @param ExceptionEvent $event The event.
	 */
	public function onException(ExceptionEvent $event): void {
		if (!$event->getRequest()->attributes->getBoolean('_has_gitlab_event', false)) {
			return;
		}

		// Build response data
		$exception = $event->getThrowable();
		$statusCode = $exception instanceof HttpExceptionInterface
			? $exception->getStatusCode()
			: Response::HTTP_INTERNAL_SERVER_ERROR;
		$data = ['status' => $statusCode, 'message' => $exception->getMessage()];

		// If we're running in dev mode, append a trace
		if ('dev' === $this->environment) {
			$data = array_merge($data, ['trace' => $exception->getTrace()]);
		}

		$event->setResponse(new JsonResponse($data, $statusCode));
	}
}
