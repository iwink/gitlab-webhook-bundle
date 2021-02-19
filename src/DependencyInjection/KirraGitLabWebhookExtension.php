<?php

namespace Iwink\GitLabWebhookBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Dependency injection for this bundle.
 * @since 1.0.0
 */
final class KirraGitLabWebhookExtension extends Extension {
	/**
	 * @inheritDoc
	 * @since 1.0.0
	 * @codeCoverageIgnore
	 */
	public function load(array $configs, ContainerBuilder $container): void {
		// Load service definitions
		$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.yaml');
	}
}
