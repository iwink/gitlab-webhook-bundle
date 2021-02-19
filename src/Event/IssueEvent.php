<?php

namespace Iwink\GitLabWebhookBundle\Event;

use Iwink\GitLabWebhookBundle\Event\Behavior\ObjectAttributesBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\RepositoryBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\UserBehaviorTrait;

/**
 * A GitLab issue event {@link https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#issue-events}.
 * @since $ver$
 */
class IssueEvent extends WebhookEvent {
	use ObjectAttributesBehaviorTrait;
	use ProjectBehaviorTrait;
	use RepositoryBehaviorTrait;
	use UserBehaviorTrait;

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const EVENT_HEADER = 'Issue Hook';

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const OBJECT_KIND = 'issue';
}
