<?php

namespace Iwink\GitLabWebhookBundle\Event;

/**
 * Base GitLab Webhook event.
 * @since 1.0.0
 */
abstract class WebhookEvent implements \ArrayAccess, \Countable, \IteratorAggregate {
	/**
	 * Event header value.
	 * @since 1.0.0
	 * @var string
	 */
	protected const EVENT_HEADER = 'event_header';

	/**
	 * Event's object kind.
	 * @since 1.0.0
	 * @var string
	 */
	protected const OBJECT_KIND = 'object_kind';

	/**
	 * The event data.
	 * @since 1.0.0
	 * @var mixed[]
	 */
	protected array $data;

	/**
	 * Creates a new webhook event.
	 * @since 1.0.0
	 * @param mixed[] $data The event data.
	 */
	public function __construct(array $data) {
		$this->data = $data;
	}

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	public function count(): int {
		return \count($this->data);
	}

	/**
	 * Returns the event data.
	 * @since 1.0.0
	 * @return mixed[] The data.
	 */
	public function getData(): array {
		return $this->data;
	}

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	public function getIterator(): \Traversable {
		return new \ArrayIterator($this->data);
	}

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	public function offsetExists($offset): bool {
		return isset($this->data[$offset]);
	}

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	public function offsetGet($offset) {
		return $this->data[$offset] ?? null;
	}

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	public function offsetSet($offset, $value): void {
		if (is_null($offset)) {
			$this->data[] = $value;
		} else {
			$this->data[$offset] = $value;
		}
	}

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	public function offsetUnset($offset): void {
		unset($this->data[$offset]);
	}

	/**
	 * Returns the event's header value.
	 * @since 1.0.0
	 * @return string The header value.
	 */
	public static function getEventHeader(): string {
		return static::EVENT_HEADER;
	}

	/**
	 * Returns the event's object kind.
	 * @since 1.0.0
	 * @return string The object kind.
	 */
	public static function getObjectKind(): string {
		return static::OBJECT_KIND;
	}
}
