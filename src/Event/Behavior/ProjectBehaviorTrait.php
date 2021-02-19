<?php

namespace Iwink\GitLabWebhookBundle\Event\Behavior;

/**
 * Trait that can be used for events that have a `project` section.
 * @since $ver$
 */
trait ProjectBehaviorTrait {
	/**
	 * Returns the project data.
	 * @since $ver$
	 * @return mixed[] The data.
	 */
	public function getProject(): array {
		return $this->data['project'];
	}
}
