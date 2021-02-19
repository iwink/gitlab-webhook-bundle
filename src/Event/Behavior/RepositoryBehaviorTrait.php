<?php

namespace Kirra\Bundle\GitLabWebhookBundle\Event\Behavior;

/**
 * Trait that can be used for events that have a `repository` section.
 * @since $ver$
 */
trait RepositoryBehaviorTrait {
	/**
	 * Returns the repository data.
	 * @since $ver$
	 * @return mixed[] The data.
	 */
	public function getRepository(): array {
		return $this->data['repository'];
	}
}
