<?php

namespace Iwink\GitLabWebhookBundle\DependencyInjection\Compiler;

use Doctrine\Common\Annotations\AnnotationReader;
use Iwink\GitLabWebhookBundle\Annotation\ParameterAwareReader;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Registers a parameter aware annotation reader.
 * @since 1.1.0
 */
class RegisterParameterAwareReaderPass implements CompilerPassInterface {
	/**
	 * @inheritDoc
	 * @since 1.1.0
	 */
	public function process(ContainerBuilder $container): void {
		try {
			$originalDefinition = $container->findDefinition('annotations.reader');
			if (AnnotationReader::class === $originalDefinition->getClass()) {
				$definition = $container->getDefinition(ParameterAwareReader::class);
				$definition->setMethodCalls($originalDefinition->getMethodCalls());

				$container->setDefinition('annotations.reader', $definition);
			}
		} catch (ServiceNotFoundException $e) {
			// no-op
		}
	}
}
