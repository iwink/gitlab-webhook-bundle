<?php

namespace Iwink\GitLabWebhookBundle\Annotation;

/**
 * Annotation that can be used to inject a GitLab event into a controller.
 * @since $ver$
 * @Annotation
 * @Target({"METHOD"})
 */
final class Webhook {
	/**
	 * The event.
	 * @since $ver$
	 * @var string
	 */
	private string $event;

	/**
	 * Creates a new annotation.
	 * @since $ver$
	 * @param mixed[] $data The data.
	 */
	public function __construct(array $data) {
		$event = $data['value'] ?? $data['event'] ?? null;
		if (null === $event) {
			throw new \InvalidArgumentException('The "event" attribute is required.');
		}

		$this->event = $event;
	}

	/**
	 * Returns the event.
	 * @since $ver$
	 * @return string The event.
	 */
	public function getEvent(): string {
		return $this->event;
	}
}
