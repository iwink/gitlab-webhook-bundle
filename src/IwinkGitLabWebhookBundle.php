<?php

namespace Iwink\GitLabWebhookBundle;

use Iwink\GitLabWebhookBundle\DependencyInjection\Compiler\RegisterParameterAwareReaderPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * GitLab webhook bundle.
 * @since 1.0.0
 */
final class IwinkGitLabWebhookBundle extends Bundle {
	/**
	 * @inheritDoc
	 * @since 1.1.0
	 * @codeCoverageIgnore
	 */
	public function build(ContainerBuilder $container): void {
		parent::build($container);

		$container->addCompilerPass(new RegisterParameterAwareReaderPass(), PassConfig::TYPE_OPTIMIZE);
	}
}
