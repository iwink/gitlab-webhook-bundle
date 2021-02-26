<?php

namespace Iwink\GitLabWebhookBundle\Annotation;

/**
 * Annotation that can be used to inject a GitLab event into a controller.
 * @since 1.0.0
 * @Annotation
 * @Target({"METHOD"})
 */
final class Webhook {
	/**
	 * The event.
	 * @since 1.0.0
	 * @var string
	 */
	private string $event;

	/**
	 * Optional secret token.
	 * @since $ver$
	 * @var string|null
	 */
	private ?string $token;

	/**
	 * Creates a new annotation.
	 * @since 1.0.0
	 * @param mixed[] $data The data.
	 */
	public function __construct(array $data) {
		$event = $data['value'] ?? $data['event'] ?? null;
		if (null === $event) {
			throw new \InvalidArgumentException('The "event" attribute is required.');
		}

		$this->event = $event;
		$this->token = $data['token'] ?? null;
	}

	/**
	 * Returns the event.
	 * @since 1.0.0
	 * @return string The event.
	 */
	public function getEvent(): string {
		return $this->event;
	}

	/**
	 * Returns the token.
	 * @since $ver$
	 * @return string|null The token.
	 */
	public function getToken(): ?string {
		return $this->token;
	}
}
