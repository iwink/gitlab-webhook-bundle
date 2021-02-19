<?php

namespace Kirra\Bundle\GitLabWebhookBundle\Event;

use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\CommitBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\ObjectAttributesBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\UserBehaviorTrait;

/**
 * A GitLab pipeline event {@link https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#pipeline-events}.
 * @since $ver$
 */
class PipelineEvent extends WebhookEvent {
	use CommitBehaviorTrait;
	use ObjectAttributesBehaviorTrait;
	use ProjectBehaviorTrait;
	use UserBehaviorTrait;

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const EVENT_HEADER = 'Pipeline Hook';

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const OBJECT_KIND = 'pipeline';
}
