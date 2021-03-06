<?php

namespace Iwink\GitLabWebhookBundle\Event;

use Iwink\GitLabWebhookBundle\Event\Behavior\ObjectAttributesBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\RepositoryBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\UserBehaviorTrait;

/**
 * A GitLab merge request event
 * {@link https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#merge-request-events}.
 * @since 1.0.0
 */
class MergeRequestEvent extends WebhookEvent {
	use ObjectAttributesBehaviorTrait;
	use ProjectBehaviorTrait;
	use RepositoryBehaviorTrait;
	use UserBehaviorTrait;

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	protected const EVENT_HEADER = 'Merge Request Hook';

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	protected const OBJECT_KIND = 'merge_request';
}
