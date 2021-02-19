<?php

namespace Iwink\GitLabWebhookBundle;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * A scheduler to execute tasks on {@see TerminateEvent}.
 *
 * Because GitLab expects a quick response from a webhook and some tasks take a while to execute, you can use this
 * scheduler to execute a task after a response has been sent.
 *
 * @since 1.0.0
 */
class Scheduler {
	/**
	 * Symfony's event dispatcher
	 * @since 1.0.0
	 * @var EventDispatcherInterface
	 */
	private EventDispatcherInterface $eventDispatcher;

	/**
	 * Creates a new scheduler.
	 * @since 1.0.0
	 * @param EventDispatcherInterface $event_dispatcher Symfony's event dispatcher.
	 */
	public function __construct(EventDispatcherInterface $event_dispatcher) {
		$this->eventDispatcher = $event_dispatcher;
	}

	/**
	 * Schedules a callable to be executed on {@see TerminateEvent}.
	 * @since 1.0.0
	 * @param callable $callable The callable.
	 * @param mixed[] $arguments Arguments to pass to the callable.
	 */
	public function schedule(callable $callable, array $arguments = []): void {
		$this->eventDispatcher->addListener(
			KernelEvents::TERMINATE,
			static fn() => \call_user_func_array($callable, $arguments)
		);
	}
}
