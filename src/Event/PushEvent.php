<?php

namespace Iwink\GitLabWebhookBundle\Event;

use Iwink\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\RepositoryBehaviorTrait;

/**
 * A GitLab push event {@link https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#push-events}.
 * @since $ver$
 */
class PushEvent extends WebhookEvent {
	use ProjectBehaviorTrait;
	use RepositoryBehaviorTrait;

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const EVENT_HEADER = 'Push Hook';

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const OBJECT_KIND = 'push';
}
