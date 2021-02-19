<?php

namespace Kirra\Bundle\GitLabWebhookBundle\Event;

use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\ObjectAttributesBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\RepositoryBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\UserBehaviorTrait;

/**
 * A GitLab merge request event
 * {@link https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#merge-request-events}.
 * @since $ver$
 */
class MergeRequestEvent extends WebhookEvent {
	use ObjectAttributesBehaviorTrait;
	use ProjectBehaviorTrait;
	use RepositoryBehaviorTrait;
	use UserBehaviorTrait;

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const EVENT_HEADER = 'Merge Request Hook';

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const OBJECT_KIND = 'merge_request';
}
