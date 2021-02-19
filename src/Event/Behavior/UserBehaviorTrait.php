<?php

namespace Iwink\GitLabWebhookBundle\Event\Behavior;

/**
 * Trait that can be used for events that have a `user` section.
 * @since $ver$
 */
trait UserBehaviorTrait {
	/**
	 * Returns the user data.
	 * @since $ver$
	 * @return mixed[] The data.
	 */
	public function getUser(): array {
		return $this->data['user'];
	}
}
