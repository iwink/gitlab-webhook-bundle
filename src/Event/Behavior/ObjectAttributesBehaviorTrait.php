<?php

namespace Iwink\GitLabWebhookBundle\Event\Behavior;

/**
 * Trait that can be used for events that have a `object_attributes` section.
 * @since 1.0.0
 */
trait ObjectAttributesBehaviorTrait {
	/**
	 * Returns the object attributes data.
	 * @since $ver$
	 * @return mixed[] The data.
	 */
	public function getObjectAttributes(): array {
		return $this->data['object_attributes'];
	}
}
