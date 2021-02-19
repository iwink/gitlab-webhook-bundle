<?php

namespace Iwink\GitLabWebhookBundle\Event;

use Iwink\GitLabWebhookBundle\Event\Behavior\CommitBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\ObjectAttributesBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\RepositoryBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\UserBehaviorTrait;

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
