<?php

namespace Kirra\Bundle\GitLabWebhookBundle\Event;

use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\CommitBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\ObjectAttributesBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\RepositoryBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\UserBehaviorTrait;

/**
 * A GitLab comment event {@link https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#comment-events}.
 * @since $ver$
 */
class CommentEvent extends WebhookEvent {
	use CommitBehaviorTrait;
	use ObjectAttributesBehaviorTrait;
	use ProjectBehaviorTrait;
	use RepositoryBehaviorTrait;
	use UserBehaviorTrait;

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const EVENT_HEADER = 'Note Hook';

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const OBJECT_KIND = 'note';
}
