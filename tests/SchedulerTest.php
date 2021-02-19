<?php

namespace Iwink\GitLabWebhookBundle\Tests;

use Iwink\GitLabWebhookBundle\Scheduler;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Unit tests for {@see Scheduler}.
 * @since 1.0.0
 */
class SchedulerTest extends TestCase {
	/**
	 * Mock of {@see EventDispatcherInterface}.
	 * @since 1.0.0
	 * @var MockObject|EventDispatcherInterface
	 */
	private EventDispatcherInterface $eventDispatcher;

	/**
	 * The scheduler.
	 * @since 1.0.0
	 * @var Scheduler
	 */
	private Scheduler $scheduler;

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	protected function setUp(): void {
		parent::setUp();

		$this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
		$this->scheduler = new Scheduler($this->eventDispatcher);
	}

	/**
	 * Test case for {@see Scheduler::schedule()}.
	 * @since 1.0.0
	 */
	public function testSchedule(): void {
		$callable = static fn(bool $value): bool => $value;
		$expected = static fn() => $callable(true);

		$this->eventDispatcher
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
