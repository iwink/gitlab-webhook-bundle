<?php

namespace Kirra\Bundle\GitLabWebhookBundle\Tests\Annotation;

use Kirra\Bundle\GitLabWebhookBundle\Annotation\Webhook;
use Kirra\Bundle\GitLabWebhookBundle\Tests\TestCase;

/**
 * Unit tests for {@see Webhook}.
 * @since $ver$
 */
class WebhookTest extends TestCase {
	/**
	 * Test case for {@see Webhook::getEvent()}.
	 * @since $ver$
	 */
	public function testGetEvent(): void {
		self::assertEquals('type', (new Webhook(['value' => 'type']))->getEvent());
		self::assertEquals('type', (new Webhook(['event' => 'type']))->getEvent());
	}

	/**
	 * Test case for {@see Webhook::__construct()} with missing property.
	 * @since $ver$
	 */
	public function testMissingEvent(): void {
		$this->expectExceptionObject(new \InvalidArgumentException('The "event" attribute is required.'));

		new Webhook([]);
	}
}
