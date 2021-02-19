<?php

namespace Kirra\Bundle\GitLabWebhookBundle\Tests\Event;

use Kirra\Bundle\GitLabWebhookBundle\Event\Exception\InvalidWebhookRequestException;
use Kirra\Bundle\GitLabWebhookBundle\Event\JobEvent;
use Kirra\Bundle\GitLabWebhookBundle\Event\WebhookEventFactory;
use Kirra\Bundle\GitLabWebhookBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Unit tests for {@see WebhookEventFactory}.
 * @since $ver$
 */
class WebhookEventFactoryTest extends TestCase {
	/**
	 * Test case for {@see WebhookEventFactory::createFromRequest()} without a webhook header.
	 * @since $ver$
	 */
	public function testCreateFromRequestMissingHeader(): void {
		$this->expectExceptionObject(new InvalidWebhookRequestException('Missing webhook header.'));

		$request = Request::create('/', 'POST');

		WebhookEventFactory::createFromRequest($request);
	}

	/**
	 * Test case for {@see WebhookEventFactory::createFromRequest()} with an unsupported webhook header.
	 * @since $ver$
	 */
	public function testCreateFromRequestUnsupportedHeader(): void {
		$this->expectExceptionObject(new InvalidWebhookRequestException(
			'Unsupported webhook event "Member Hook".'
		));

		$request = Request::create('/', 'POST');
		$request->headers->set('X-Gitlab-Event', ['Member Hook']);

		WebhookEventFactory::createFromRequest($request);
	}

	/**
	 * Test case for {@see WebhookEventFactory::createFromRequest()} with an invalid payload
	 * @since $ver$
	 */
	public function testCreateFromRequestInvalidPayload(): void {
		$exception = new \JsonException('Syntax', JSON_ERROR_SYNTAX);
		$this->expectExceptionObject(new InvalidWebhookRequestException(
			'Could not parse webhook payload.',
			$exception->getCode(),
			$exception
		));

		$request = Request::create('/', 'POST', [], [], [], [], '\a');
		$request->headers->set('X-Gitlab-Event', ['Job Hook']);

		WebhookEventFactory::createFromRequest($request);
	}

	/**
	 * Test case for {@see WebhookEventFactory::createFromRequest()} with a payload mismatch.
	 * @since $ver$
	 */
	public function testCreateFromRequestPayloadMismatch(): void {
		$this->expectExceptionObject(new InvalidWebhookRequestException(
			'Webhook payload object_kind "pipeline" is invalid for the "job" event.'
		));

		$payload = ['object_kind' => 'pipeline'];
		$request = Request::create('/', 'POST', [], [], [], [], \json_encode($payload));
		$request->headers->set('X-Gitlab-Event', ['Job Hook']);

		WebhookEventFactory::createFromRequest($request);
	}

	/**
	 * Test case for {@see WebhookEventFactory::createFromRequest()}.
	 * @since $ver$
	 */
	public function testCreateFromRequest(): void {
		$payload = ['object_kind' => 'build'];
		$request = Request::create('/', 'POST', [], [], [], [], \json_encode($payload));
		$request->headers->set('X-Gitlab-Event', ['Job Hook']);

		$event = WebhookEventFactory::createFromRequest($request);
		self::assertEquals(new JobEvent(['object_kind' => 'build']), $event);
	}
}
