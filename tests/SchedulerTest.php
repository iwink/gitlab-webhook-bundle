<?php

namespace Iwink\GitLabWebhookBundle\Tests;

use Iwink\GitLabWebhookBundle\Scheduler;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Unit tests for {@see Scheduler}.
 * @since $ver$
 */
class SchedulerTest extends TestCase {
	/**
	 * Mock of {@see EventDispatcherInterface}.
	 * @since $ver$
	 * @var MockObject|EventDispatcherInterface
	 */
	private EventDispatcherInterface $event_dispatcher;

	/**
	 * The scheduler.
	 * @since $ver$
	 * @var Scheduler
	 */
	private Scheduler $scheduler;

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected function setUp(): void {
		parent::setUp();

		$this->event_dispatcher = $this->createMock(EventDispatcherInterface::class);
		$this->scheduler = new Scheduler($this->event_dispatcher);
	}

	/**
	 * Test case for {@see Scheduler::schedule()}.
	 * @since $ver$
	 */
	public function testSchedule(): void {
		$callable = static fn(bool $value): bool => $value;
		$expected = static fn() => \call_user_func_array($callable, [true]);

		$this->event_dispatcher
			->expects(self::once())
			->method('addListener')
			->with(
				'kernel.terminate',
				// When matching the argument directly to $expected, the arguments aren't matched
				self::callback(static function (\Closure $actual) use ($expected): bool {
					// We assert both referenced callback & arguments
					self::assertEquals($expected, $actual);
					self::assertSame($expected(), $actual());

					return true;
				}),
			);

		$this->scheduler->schedule($callable, [true]);
	}
}
