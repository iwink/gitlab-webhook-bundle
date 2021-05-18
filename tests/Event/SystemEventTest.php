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
	 * Test case for {@see SystemEvent::validateData()}.
	 * @since $ver$
	 */
	public function testValidateData(): void {
		self::assertTrue(SystemEvent::validateData(['event_name' => 'group_create']));
		self::assertFalse(SystemEvent::validateData([]));
	}
}
