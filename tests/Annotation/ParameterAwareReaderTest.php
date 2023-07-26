<?php

namespace Iwink\GitLabWebhookBundle\Tests\Annotation;

use Iwink\GitLabWebhookBundle\Annotation\ParameterAwareReader;
use Iwink\GitLabWebhookBundle\Annotation\Webhook;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Unit tests for {@see ParameterAwareReader}.
 * @since $ver$
 */
final class ParameterAwareReaderTest extends TestCase
{
	/**
	 * Test case for {@see ParameterAwareReader::getMethodAnnotations()} with a PHPDoc that has a random,
	 * non-existent parameter reference.
	 * @since $ver$
	 */
	public function testReader(): void
	{
		$parameter_bag = new ParameterBag([
			'secret_token' => 'SuperSecret123',
		]);
		$reader = new ParameterAwareReader($parameter_bag);

		$annotations = $reader->getMethodAnnotations(
			new \ReflectionMethod(TestClassForReflection::class, 'testMethod')
		);
		self::assertEquals([new Webhook(['event' => 'pipeline', 'tokens' => ['SuperSecret123']])], $annotations);
	}
}

final class TestClassForReflection
{
	/**
	 * some comment with an {"%invalid_token%"}
	 * @Webhook("pipeline", tokens={"%secret_token%"})
	 */
	public function testMethod(): void
	{
	}
}
