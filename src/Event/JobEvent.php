<?php

namespace Iwink\GitLabWebhookBundle\Event;

use Iwink\GitLabWebhookBundle\Event\Behavior\RepositoryBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\UserBehaviorTrait;

/**
 * A GitLab job event {@link https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#job-events}.
 * @since 1.0.0
 */
class JobEvent extends WebhookEvent {
	use RepositoryBehaviorTrait;
	use UserBehaviorTrait;

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	protected const EVENT_HEADER = 'Job Hook';

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	protected const OBJECT_KIND = 'build';
}
