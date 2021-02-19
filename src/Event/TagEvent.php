<?php

namespace Iwink\GitLabWebhookBundle\Event;

use Iwink\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\RepositoryBehaviorTrait;

/**
 * A GitLab tag event {@link https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#tag-events}.
 * @since $ver$
 */
class TagEvent extends WebhookEvent {
	use ProjectBehaviorTrait;
	use RepositoryBehaviorTrait;

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const EVENT_HEADER = 'Tag Push Hook';

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const OBJECT_KIND = 'tag_push';
}
