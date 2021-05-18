<?php

namespace Iwink\GitLabWebhookBundle\Tests\Event;

use Iwink\GitLabWebhookBundle\Event\SystemEvent;
use Iwink\GitLabWebhookBundle\Tests\TestCase;

/**
 * Unit tests for {@see SystemEvent}.
 * @since $ver$
 */
class SystemEventTest extends TestCase {
	/**
	 * Test case for {@see SystemEvent::create()}.
	 * @since $ver$
	 */
	public function testCreate(): void {
		self::assertInstanceOf(
			SystemEvent::class,
			SystemEvent::create(['event_name' => 'group_create'])
		);

		$this->expectException(\InvalidArgumentException::class);
		SystemEvent::create([]);
	}
}
