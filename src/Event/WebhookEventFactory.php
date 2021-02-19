<?php

namespace Iwink\GitLabWebhookBundle\Event;

use Iwink\GitLabWebhookBundle\Event\Exception\InvalidWebhookRequestException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Factory to create webhook events.
 * @since 1.0.0
 */
class WebhookEventFactory {
	/**
	 * Creates a webhook event from a HTTP POST request.
	 * @since $ver$
	 * @param Request $request The request.
	 * @return WebhookEvent The event.
	 * @throws InvalidWebhookRequestException If an event couldn't be created.
	 */
	public static function createFromRequest(Request $request): WebhookEvent {
		// Resolve header
		$header = $request->headers->get('X-Gitlab-Event');
		if (null === $header) {
			throw new InvalidWebhookRequestException('Missing webhook header.');
		}

		// Resolve event
		$eventClass = WebhookEventResolver::resolveClassByHeader($header);
		if (null === $eventClass) {
			throw new InvalidWebhookRequestException(sprintf('Unsupported webhook event "%s".', $header));
		}

		// Resolve data
		try {
			$data = \json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
		} catch (\JsonException $e) {
			throw new InvalidWebhookRequestException('Could not parse webhook payload.', $e->getCode(), $e);
		}

		// Validate data against event
		$objectKind = $data['object_kind'] ?? null;
		if ($objectKind !== $eventClass::getObjectKind()) {
			throw new InvalidWebhookRequestException(sprintf(
				'Webhook payload object_kind "%s" is invalid for the "%s" event.',
				$objectKind,
				WebhookEventResolver::resolveTypeByClass($eventClass),
			));
		}

		return new $eventClass($data);
	}
}
