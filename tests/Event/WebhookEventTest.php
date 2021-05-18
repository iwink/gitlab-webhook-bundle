<?php

namespace Iwink\GitLabWebhookBundle\Tests\Event;

use Iwink\GitLabWebhookBundle\Event\WebhookEvent;
use Iwink\GitLabWebhookBundle\Tests\TestCase;

/**
 * Unit tests for {@see WebhookEvent}.
 * @since 1.0.0
 */
class WebhookEventTest extends TestCase {
	/**
	 * Test case for {@see WebhookEvent::count()}.
	 * @since 1.0.0
	 */
	public function testCount(): void {
		self::assertSame(0, (new ConcreteWebhookEvent([]))->count());
	}

	/**
	 * Test case for {@see WebhookEvent::getData()}.
	 * @since 1.0.0
	 */
	public function testGetData(): void {
		self::assertSame(['key' => 'value'], (new ConcreteWebhookEvent(['key' => 'value']))->getData());
	}

	/**
	 * Test case for {@see WebhookEvent::getIterator()}.
	 * @since 1.0.0
	 */
	public function testGetIterator(): void {
		$data = ['key' => 'value'];
		self::assertEquals(new \ArrayIterator($data), (new ConcreteWebhookEvent($data))->getIterator());
	}

	/**
	 * Test case for {@see WebhookEvent::offsetExists()}, {@see WebhookEvent::offsetGet()},
	 * {@see WebhookEvent::offsetSet()} & {@see WebhookEvent::offsetUnset()}.
	 * @since 1.0.0
	 */
	public function testArrayAccess(): void {
		$event = new ConcreteWebhookEvent([]);

		self::assertFalse(isset($event['key']));
		$event['key'] = 'value';
		self::assertSame('value', $event['key']);
		self::assertTrue(isset($event['key']));

		unset($event['key']);
		self::assertFalse(isset($event['key']));

		$event[] = 'value';
		$event['key'] = 'keyed value';
		self::assertSame(['value', 'key' => 'keyed value'], $event->getData());
	}

	/**
	 * Test case for {@see WebhookEvent::getEventHeader()}.
	 * @since 1.0.0
	 */
	public function testGetEventHeader(): void {
		self::assertSame('Concrete Header', ConcreteWebhookEvent::getEventHeader());
	}

	/**
	 * Test case for {@see WebhookEvent::validateData()}.
	 * @since $ver$
	 */
	public function testValidateData(): void {
		self::assertTrue(ConcreteWebhookEvent::validateData(['object_kind' => 'concrete']));
		self::assertFalse(ConcreteWebhookEvent::validateData([]));
	}
}

/**
 * Concrete implementation of a {@see WebhookEvent}.
 * @since 1.0.0
 */
class ConcreteWebhookEvent extends WebhookEvent {
	protected const EVENT_HEADER = 'Concrete Header';
	protected const OBJECT_KIND = 'concrete';
}
