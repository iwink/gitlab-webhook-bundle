<?php

namespace Iwink\GitLabWebhookBundle\Event\Behavior;

/**
 * Trait that can be used for events that have a `commit` section.
 * @since 1.0.0
 */
trait CommitBehaviorTrait {
	/**
	 * Returns the commit data.
	 * @since 1.0.0
	 * @return mixed[] The data.
	 */
	public function getCommit(): array {
		return $this->data['commit'];
	}
}
