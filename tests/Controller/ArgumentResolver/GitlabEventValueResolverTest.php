<?php

namespace Iwink\GitLabWebhookBundle\Tests\Controller\ArgumentResolver;

use Iwink\GitLabWebhookBundle\Controller\ArgumentResolver\GitLabEventValueResolver;
use Iwink\GitLabWebhookBundle\Event\JobEvent;
use Iwink\GitLabWebhookBundle\Event\WebhookEvent;
use Iwink\GitLabWebhookBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Unit tests for {@see GitLabEventValueResolver}.
 * @since 1.0.0
 */
class GitlabEventValueResolverTest extends TestCase {
	/**
	 * Creates an HTTP request, stores an optional even and returns the request.
	 * @since 1.0.0
	 * @param WebhookEvent|null $event Optional event to store on the attributes.
	 * @return Request The request.
	 */
	private function createRequest(?WebhookEvent $event = null): Request {
		$request = Request::create('/');
		if ($event instanceof WebhookEvent) {
			$request->attributes->set('_gitlab_event', $event);
			$request->attributes->set('_has_gitlab_event', true);
		}

		return $request;
	}

	/**
	 * Creates argument metadata with a type and returns it.
	 * @since 1.0.0
	 * @param string $type The type.
	 * @return ArgumentMetadata The metadata.
	 */
	private function createArgument(string $type): ArgumentMetadata {
		return new ArgumentMetadata('event', $type, false, false, null);
	}

	/**
	 * Data provider for {@see GitLabEventValueResolver::supports()}.
	 * @since 1.0.0
	 * @return mixed[] The data set.
	 */
	public function supportsDataProvider(): array {
		return [
			'No event' => [
				$this->createRequest(),
				$this->createArgument(WebhookEvent::class),
				false,
			],
			'Different argument type' => [
				$this->createRequest(new JobEvent([])),
				$this->createArgument('string'),
				false,
			],
			'Supported' => [
				$this->createRequest(new JobEvent([])),
				$this->createArgument(WebhookEvent::class),
				true,
			],
		];
	}

	/**
	 * Test case for {@see GitLabEventValueResolver::supports()}.
	 * @since 1.0.0
	 * @param Request $request The request.
	 * @param ArgumentMetadata $argument The argument.
	 * @param bool $expected The expected result.
	 * @dataProvider supportsDataProvider The data provider.
	 */
	public function testSupports(Request $request, ArgumentMetadata $argument, bool $expected): void {
		$resolver = new GitLabEventValueResolver();

		self::assertSame($expected, $resolver->supports($request, $argument));
	}

	/**
	 * Test case for {@see GitLabEventValueResolver::resolve()}.
	 * @since 1.0.0
	 */
	public function testResolve(): void {
		$resolver = new GitLabEventValueResolver();
		$value = $resolver->resolve(
			$this->createRequest($event = new JobEvent([])),
			$this->createArgument(JobEvent::class)
		);

		self::assertContains($event, $value);
	}
}
