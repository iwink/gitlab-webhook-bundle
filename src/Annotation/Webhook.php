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
	 * Optional secret tokens.
	 * @since $ver$
	 * @var string[]
	 */
	private array $tokens;

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
		$this->tokens = $data['tokens'] ?? [];
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
	 * Returns the tokens.
	 * @since $ver$
	 * @return string[] The tokens.
	 */
	public function getTokens(): array {
		return $this->tokens;
	}
}
