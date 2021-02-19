<?php

namespace Iwink\GitLabWebhookBundle\Event\Behavior;

/**
 * Trait that can be used for events that have a `user` section.
 * @since 1.0.0
 */
trait UserBehaviorTrait {
	/**
	 * Returns the user data.
	 * @since 1.0.0
	 * @return mixed[] The data.
	 */
	public function getUser(): array {
		return $this->data['user'];
	}
}
