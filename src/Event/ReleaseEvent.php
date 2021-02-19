<?php

namespace Kirra\Bundle\GitLabWebhookBundle\Event;

use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\CommitBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;

/**
 * A GitLab release event {@link https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#release-events}.
 * @since $ver$
 */
class ReleaseEvent extends WebhookEvent {
	use CommitBehaviorTrait;
	use ProjectBehaviorTrait;

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const EVENT_HEADER = 'Release Hook';

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const OBJECT_KIND = 'release';
}
