<?php

namespace Iwink\GitLabWebhookBundle\Event;

use Iwink\GitLabWebhookBundle\Event\Behavior\CommitBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\ObjectAttributesBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\UserBehaviorTrait;

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
