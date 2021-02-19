<?php

namespace Kirra\Bundle\GitLabWebhookBundle\Event;

use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\UserBehaviorTrait;

/**
 * A GitLab deployment event
 * {@link https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#deployment-events}.
 * @since $ver$
 */
class DeploymentEvent extends WebhookEvent {
	use ProjectBehaviorTrait;
	use UserBehaviorTrait;

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const EVENT_HEADER = 'Deployment Hook';

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const OBJECT_KIND = 'deployment';
}
