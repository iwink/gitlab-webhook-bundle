<?php

namespace Kirra\Bundle\GitLabWebhookBundle\Tests\Controller\ArgumentResolver;

use Kirra\Bundle\GitLabWebhookBundle\Controller\ArgumentResolver\GitLabEventValueResolver;
use Kirra\Bundle\GitLabWebhookBundle\Event\JobEvent;
use Kirra\Bundle\GitLabWebhookBundle\Event\WebhookEvent;
use Kirra\Bundle\GitLabWebhookBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Unit tests for {@see GitLabEventValueResolver}.
 * @since $ver$
 */
class GitlabEventValueResolverTest extends TestCase {
	/**
	 * Creates an HTTP request, stores an optional even and returns the request.
	 * @since $ver$
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
	 * @since $ver$
	 * @param string $type The type.
	 * @return ArgumentMetadata The metadata.
	 */
	private function createArgument(string $type): ArgumentMetadata {
		return new ArgumentMetadata('event', $type, false, false, null);
	}

	/**
	 * Data provider for {@see GitLabEventValueResolver::supports()}.
	 * @since $ver$
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
	 * @since $ver$
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
	 * @since $ver$
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
