<?php

namespace Iwink\GitLabWebhookBundle\Tests\EventSubscriber;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader as ReaderInterface;
use Iwink\GitLabWebhookBundle\Event\Exception\InvalidWebhookRequestException;
use Iwink\GitLabWebhookBundle\Event\PipelineEvent;
use Iwink\GitLabWebhookBundle\EventSubscriber\GitLabWebhookSubscriber;
use Iwink\GitLabWebhookBundle\Tests\Fixtures\WebhookController;
use Iwink\GitLabWebhookBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Unit tests for {@see GitLabWebhookSubscriber}.
 * @since $ver$
 */
class GitLabWebhookSubscriberTest extends TestCase {
	/**
	 * The event subscriber.
	 * @since $ver$
	 * @var GitLabWebhookSubscriber
	 */
	private GitLabWebhookSubscriber $subscriber;

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected function setUp(): void {
		parent::setUp();

		$this->subscriber = new GitLabWebhookSubscriber('test', new AnnotationReader());
	}

	/**
	 * Creates a {@see ControllerEvent} to pass to the event subscriber.
	 * @since $ver$
	 * @param string $controller The request _controller attribute.
	 * @param Request $request The request.
	 * @return ControllerEvent The event.
	 */
	private function createControllerEvent(string $controller, Request $request): ControllerEvent {
		$request->attributes->set('_controller', $controller);

		return new ControllerEvent(
			$this->createMock(HttpKernelInterface::class),
			static fn(): bool => true,
			$request,
			HttpKernelInterface::MASTER_REQUEST,
		);
	}

	/**
	 * Creates a {@see ControllerArgumentsEvent} to pass to the event subscriber.
	 * @since $ver$
	 * @return ControllerArgumentsEvent The event.
	 */
	private function createControllerArgumentsEvent(): ControllerArgumentsEvent {
		$request = Request::create('/');
		$request->attributes->set('_gitlab_event', new PipelineEvent([]));
		$request->attributes->set('_has_gitlab_event', true);

		return new ControllerArgumentsEvent(
			$this->createMock(HttpKernelInterface::class),
			static fn(): bool => true,
			[],
			$request,
			HttpKernelInterface::MASTER_REQUEST,
		);
	}

	/**
	 * Creates a {@see ExceptionEvent} to pass to the event subscriber.
	 * @since $ver$
	 * @param \Throwable $e The exception.
	 * @return ExceptionEvent The event.
	 */
	private function createExceptionEvent(\Throwable $e): ExceptionEvent {
		$request = Request::create('/');
		$request->attributes->set('_gitlab_event', new PipelineEvent([]));
		$request->attributes->set('_has_gitlab_event', true);

		return new ExceptionEvent(
			$this->createMock(HttpKernelInterface::class),
			$request,
			HttpKernelInterface::MASTER_REQUEST,
			$e,
		);
	}

	/**
	 * Test case for {@see GitLabWebhookSubscriber::onController()} with an unsupported controller.
	 * @since $ver$
	 */
	public function testOnControllerNotSupported(): void {
		$reader = $this->createMock(ReaderInterface::class);
		$reader
			->expects(self::never())
			->method('getMethodAnnotations');

		$request = Request::create('/');
		$event = $this->createControllerEvent('Closure', $request);

		$subscriber = new GitLabWebhookSubscriber('test', $reader);
		$subscriber->onController($event);
	}

	/**
	 * Test case for {@see GitLabWebhookSubscriber::onController()} without annotations.
	 * @since $ver$
	 */
	public function testOnControllerNoAnnotation(): void {
		$request = $this->createMock(Request::class);
		$request->attributes = new ParameterBag();
		$request
			->expects(self::never())
			->method('getMethod');

		$event = $this->createControllerEvent(WebhookController::class . '::noAnnotation', $request);

		$this->subscriber->onController($event);
	}

	/**
	 * Test case for {@see GitLabWebhookSubscriber::onController()} with an invalid HTTP method.
	 * @since $ver$
	 */
	public function testOnControllerInvalidMethod(): void {
		$this->expectExceptionObject(new MethodNotAllowedHttpException(['POST']));

		$request = Request::create('/');
		$event = $this->createControllerEvent(WebhookController::class . '::annotation', $request);

		$this->subscriber->onController($event);
	}

	/**
	 * Test case for {@see GitLabWebhookSubscriber::onController()} with an invalid payload.
	 * @since $ver$
	 */
	public function testOnControllerInvalidPayload(): void {
		$exception = new InvalidWebhookRequestException('Missing webhook header.');
		$this->expectExceptionObject(new BadRequestHttpException(
			$exception->getMessage(),
			$exception,
		));

		$request = Request::create('/', 'POST');
		$event = $this->createControllerEvent(WebhookController::class . '::annotation', $request);

		$this->subscriber->onController($event);
	}

	/**
	 * Test case for {@see GitLabWebhookSubscriber::onController()} with an annotation mismatch.
	 * @since $ver$
	 */
	public function testOnControllerAnnotationMismatch(): void {
		$this->expectExceptionObject(new BadRequestHttpException('This webhook doesn\'t support the "job" event.'));

		$payload = ['object_kind' => 'build'];
		$request = Request::create('/', 'POST', [], [], [], [], \json_encode($payload));
		$request->headers->set('X-Gitlab-Event', ['Job Hook']);
		$event = $this->createControllerEvent(WebhookController::class . '::annotation', $request);

		$this->subscriber->onController($event);
	}

	/**
	 * Test case for {@see GitLabWebhookSubscriber::onController()}.
	 * @since $ver$
	 */
	public function testOnController(): void {
		$payload = ['object_kind' => 'pipeline'];
		$request = Request::create('/', 'POST', [], [], [], [], \json_encode($payload));
		$request->headers->set('X-Gitlab-Event', ['Pipeline Hook']);
		$event = $this->createControllerEvent(WebhookController::class . '::annotation', $request);

		$this->subscriber->onController($event);
		self::assertEquals(new PipelineEvent($payload), $request->attributes->get('_gitlab_event'));
	}

	/**
	 * Test case for {@see GitLabWebhookSubscriber::onControllerArguments()}.
	 * @since $ver$
	 */
	public function testOnControllerArguments(): void {
		$event = $this->createControllerArgumentsEvent();
		$request = $event->getRequest();

		$this->subscriber->onControllerArguments($event);
		self::assertFalse($request->attributes->has('_gitlab_event'));
	}

	/**
	 * Test case for {@see GitLabWebhookSubscriber::onException()} without a webhook event.
	 * @since $ver$
	 */
	public function testOnExceptionNoWebhookEvent(): void {
		$event = $this->createExceptionEvent(new \Exception());
		$event->getRequest()->attributes->remove('_has_gitlab_event');

		$response = $event->getResponse();
		$this->subscriber->onException($event);
		self::assertSame($response, $event->getResponse());
	}

	/**
	 * Data provider for {@see GitLabWebhookSubscriber::onException()}.
	 * @since $ver$
	 * @return mixed[] The data set.
	 */
	public function onExceptionDataProvider(): array {
		return [
			'Common exception' => [
				new \Exception('Exception'),
				new JsonResponse(['status' => 500, 'message' => 'Exception'], 500),
			],
			'HTTP exception' => [
				new NotFoundHttpException('Not found'),
				new JsonResponse(['status' => 404, 'message' => 'Not found'], 404),
			],
			'HTTP exception in dev' => [
				$e = new BadRequestHttpException('Bad request'),
				new JsonResponse(['status' => 400, 'message' => 'Bad request', 'trace' => $e->getTrace()], 400),
				'dev',
			],
		];
	}

	/**
	 * Test case for {@see GitLabWebhookSubscriber::onException()} without a webhook event.
	 * @since $ver$
	 * @param \Throwable $exception The exception.
	 * @param Response $expected The response.
	 * @param string $environment The environment.
	 * @dataProvider onExceptionDataProvider The data provider.
	 */
	public function testOnException(\Throwable $exception, Response $expected, string $environment = 'test'): void {
		$event = $this->createExceptionEvent($exception);

		$subscriber = new GitLabWebhookSubscriber($environment, new AnnotationReader());
		$subscriber->onException($event);

		$actual = $event->getResponse();

		// Fix 'date' headers, these might differ
		foreach ([$expected, $actual] as $response) {
			$response->headers->set(
				'date',
				sprintf('%s GMT', (new \DateTime('2020-01-01 00:00:00'))->format('D, d M Y H:i:s')),
			);
		}

		self::assertEquals($expected, $actual);
	}
}
