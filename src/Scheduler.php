<?php

namespace Kirra\Bundle\GitLabWebhookBundle;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * A scheduler to execute tasks on {@see TerminateEvent}.
 *
 * Because GitLab expects a quick response from a webhook and some tasks take a while to execute, you can use this
 * scheduler to execute a task after a response has been sent.
 *
 * @since $ver$
 */
class Scheduler {
	/**
	 * Symfony's event dispatcher
	 * @since $ver$
	 * @var EventDispatcherInterface
	 */
	private EventDispatcherInterface $event_dispatcher;

	/**
	 * Creates a new scheduler.
	 * @since $ver$
	 * @param EventDispatcherInterface $event_dispatcher Symfony's event dispatcher.
	 */
	public function __construct(EventDispatcherInterface $event_dispatcher) {
		$this->event_dispatcher = $event_dispatcher;
	}

	/**
	 * Schedules a callable to be executed on {@see TerminateEvent}.
	 * @since $ver$
	 * @param callable $callable The callable.
	 * @param mixed[] $arguments Arguments to pass to the callable.
	 */
	public function schedule(callable $callable, array $arguments = []): void {
		$this->event_dispatcher->addListener(
			KernelEvents::TERMINATE,
			static fn() => \call_user_func_array($callable, $arguments)
		);
	}
}
