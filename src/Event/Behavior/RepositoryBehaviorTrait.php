<?php

namespace Iwink\GitLabWebhookBundle\Event\Behavior;

/**
 * Trait that can be used for events that have a `repository` section.
 * @since 1.0.0
 */
trait RepositoryBehaviorTrait {
	/**
	 * Returns the repository data.
	 * @since 1.0.0
	 * @return mixed[] The data.
	 */
	public function getRepository(): array {
		return $this->data['repository'];
	}
}
