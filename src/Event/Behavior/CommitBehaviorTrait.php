<?php

namespace Iwink\GitLabWebhookBundle\Event\Behavior;

/**
 * Trait that can be used for events that have a `commit` section.
 * @since $ver$
 */
trait CommitBehaviorTrait {
	/**
	 * Returns the commit data.
	 * @since $ver$
	 * @return mixed[] The data.
	 */
	public function getCommit(): array {
		return $this->data['commit'];
	}
}
