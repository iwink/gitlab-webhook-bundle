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
	 * @since 1.0.0
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
		if (false === $eventClass::validateData($data)) {
			throw new InvalidWebhookRequestException(sprintf(
				'Webhook payload is invalid for the "%s" event.',
				WebhookEventResolver::resolveTypeByClass($eventClass),
			));
		}

		return new $eventClass($data);
	}
}
