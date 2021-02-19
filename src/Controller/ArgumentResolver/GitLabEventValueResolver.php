<?php

namespace Iwink\GitLabWebhookBundle\Controller\ArgumentResolver;

use Iwink\GitLabWebhookBundle\Event\WebhookEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Resolves configured {@see WebhookEvent} instances from {@see Request::$attributes} for a supported controller.
 * @since 1.0.0
 */
final class GitLabEventValueResolver implements ArgumentValueResolverInterface {
	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	public function supports(Request $request, ArgumentMetadata $argument): bool {
		$has_event = $request->attributes->getBoolean('_has_gitlab_event', false);

		return $has_event && is_a($argument->getType(), WebhookEvent::class, true);
	}

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	public function resolve(Request $request, ArgumentMetadata $argument): iterable {
		yield $request->attributes->get('_gitlab_event');
	}
}
