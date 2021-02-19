<?php

namespace Iwink\GitLabWebhookBundle\Tests\Event;

use Iwink\GitLabWebhookBundle\Event\JobEvent;
use Iwink\GitLabWebhookBundle\Event\MergeRequestEvent;
use Iwink\GitLabWebhookBundle\Event\WebhookEventResolver;
use Iwink\GitLabWebhookBundle\Tests\TestCase;

/**
 * Unit tests for {@see WebhookEventResolver}.
 * @since $ver$
 */
class WebhookEventResolverTest extends TestCase {
	/**
	 * Test case for {@see WebhookEventResolver::resolveClassByHeader()}.
	 * @since $ver$
	 */
	public function testResolveClassByHeader(): void {
		self::assertSame(JobEvent::class, WebhookEventResolver::resolveClassByHeader('Job Hook'));
		self::assertNull(WebhookEventResolver::resolveClassByHeader('Invalid Hook'));
	}

	/**
	 * Test case for {@see WebhookEventResolver::testResolveClassByType()}.
	 * @since $ver$
	 */
	public function testResolveClassByType(): void {
		self::assertSame(MergeRequestEvent::class, WebhookEventResolver::resolveClassByType('merge request'));
		self::assertNull(WebhookEventResolver::resolveClassByType('pull request'));
	}

	/**
	 * Test case for {@see WebhookEventResolver::resolveTypeByClass()}.
	 * @since $ver$
	 */
	public function testResolveTypeByClass(): void {
		self::assertSame('merge request', WebhookEventResolver::resolveTypeByClass(MergeRequestEvent::class));

		$this->expectExceptionObject(
			new \InvalidArgumentException('Types can only be resolved from webhook event classes.')
		);
		WebhookEventResolver::resolveTypeByClass(\stdClass::class);
	}
}
