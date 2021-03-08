<?php

namespace Iwink\GitLabWebhookBundle\Tests\DependencyInjection\Compiler;

use Doctrine\Common\Annotations\AnnotationReader;
use Iwink\GitLabWebhookBundle\Annotation\ParameterAwareReader;
use Iwink\GitLabWebhookBundle\DependencyInjection\Compiler\RegisterParameterAwareReaderPass;
use Iwink\GitLabWebhookBundle\Tests\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Unit tests for {@see RegisterParameterAwareReaderPass}.
 * @since 1.1.0
 */
class RegisterParameterAwareReaderPassTest extends TestCase {
	/**
	 * Test case for {@see RegisterParameterAwareReaderPass::proces()} without the original definition.
	 * @since 1.1.0
	 */
	public function testProcessNoOriginalDefinition(): void {
		$container = $this->createMock(ContainerBuilder::class);
		$container
			->expects(self::once())
			->method('findDefinition')
			->with($id = 'annotations.reader')
			->willThrowException(new ServiceNotFoundException($id));

		(new RegisterParameterAwareReaderPass())->process($container);
	}

	/**
	 * Test case for {@see RegisterParameterAwareReaderPass::proces()}.
	 * @since 1.1.0
	 */
	public function testProcess(): void {
		$container = new ContainerBuilder();
		$container->setDefinition(
			'annotations.reader',
			(new Definition(AnnotationReader::class))->setMethodCalls([['method', ['arg']]])
		);

		$container->setDefinition(
			ParameterAwareReader::class,
			(new Definition(ParameterAwareReader::class))
		);

		(new RegisterParameterAwareReaderPass())->process($container);

		$definition = $container->getDefinition('annotations.reader');
		self::assertSame(ParameterAwareReader::class, $definition->getClass());
		self::assertSame([['method', ['arg']]], $definition->getMethodCalls());
	}
}
