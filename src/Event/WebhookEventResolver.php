<?php

namespace Kirra\Bundle\GitLabWebhookBundle\Event;

/**
 * Resolves webhook events.
 * @since $ver$
 */
final class WebhookEventResolver {
	/**
	 * Webhook event classes.
	 * @since $ver$
	 * @var string[]
	 */
	private const EVENTS = [
		DeploymentEvent::class,
		FeatureFlagEvent::class,
		IssueEvent::class,
		JobEvent::class,
		MergeRequestEvent::class,
		CommentEvent::class,
		PipelineEvent::class,
		PushEvent::class,
		ReleaseEvent::class,
		TagEvent::class,
		WikiPageEvent::class,
	];

	/**
	 * Resolves a webhook event class by a header.
	 * @since $ver$
	 * @param string $header The header.
	 * @return string|null The event class.
	 */
	public static function resolveClassByHeader(string $header): ?string {
		$events = array_combine(
			array_map(static fn(string $event): string => $event::getEventHeader(), self::EVENTS),
			self::EVENTS
		);

		return $events[$header] ?? null;
	}

	/**
	 * Resolves a webhook event class by a type.
	 * @since $ver$
	 * @param string $type The type.
	 * @return string|null The event class.
	 */
	public static function resolveClassByType(string $type): ?string {
		$class = str_replace(' ', '', ucwords(strtolower($type))) . 'Event';
		$namespace = (new \ReflectionClass(__CLASS__))->getNamespaceName();

		return class_exists($fqcn = $namespace . '\\' . $class) ? $fqcn : null;
	}

	/**
	 * Resolves a webhook's type by an event class.
	 * @since $ver$
	 * @param string $event_class The event class.
	 * @return string The type.
	 */
	public static function resolveTypeByClass(string $event_class): string {
		if (!is_a($event_class, WebhookEvent::class, true)) {
			throw new \InvalidArgumentException('Types can only be resolved from webhook event classes.');
		}

		$class = array_reverse(explode('\\', $event_class))[0];
		$separated = strtolower(preg_replace('/(?<![A-Z])[A-Z]/', ' ' . '\0', $class));

		return trim(str_replace('event', '', $separated));
	}
}
