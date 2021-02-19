<?php

namespace Iwink\GitLabWebhookBundle\Event\Behavior;

/**
 * Trait that can be used for events that have a `project` section.
 * @since 1.0.0
 */
trait ProjectBehaviorTrait {
	/**
	 * Returns the project data.
	 * @since 1.0.0
	 * @return mixed[] The data.
	 */
	public function getProject(): array {
		return $this->data['project'];
	}
}
