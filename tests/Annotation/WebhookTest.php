<?php

namespace Iwink\GitLabWebhookBundle\Tests\Annotation;

use Iwink\GitLabWebhookBundle\Annotation\Webhook;
use Iwink\GitLabWebhookBundle\Tests\TestCase;

/**
 * Unit tests for {@see Webhook}.
 * @since 1.0.0
 */
class WebhookTest extends TestCase {
	/**
	 * Test case for {@see Webhook::getEvent()}.
	 * @since 1.0.0
	 */
	public function testGetEvent(): void {
		self::assertEquals('type', (new Webhook(['value' => 'type']))->getEvent());
		self::assertEquals('type', (new Webhook(['event' => 'type']))->getEvent());
	}

	/**
	 * Test case for {@see Webhook::getTokens()}.
	 * @since $ver$
	 */
	public function testGetTokens(): void {
		self::assertSame(['token'], (new Webhook(['event' => 'type', 'tokens' => ['token']]))->getTokens());
		self::assertEmpty((new Webhook(['value' => 'type']))->getTokens());
	}

	/**
	 * Test case for {@see Webhook::__construct()} with missing property.
	 * @since 1.0.0
	 */
	public function testMissingEvent(): void {
		$this->expectExceptionObject(new \InvalidArgumentException('The "event" attribute is required.'));

		new Webhook([]);
	}
}
