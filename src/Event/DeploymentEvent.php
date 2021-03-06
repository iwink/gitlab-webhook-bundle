<?php

namespace Iwink\GitLabWebhookBundle\Event;

use Iwink\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\UserBehaviorTrait;

/**
 * A GitLab deployment event
 * {@link https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#deployment-events}.
 * @since 1.0.0
 */
class DeploymentEvent extends WebhookEvent {
	use ProjectBehaviorTrait;
	use UserBehaviorTrait;

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	protected const EVENT_HEADER = 'Deployment Hook';

	/**
	 * @inheritDoc
	 * @since 1.0.0
	 */
	protected const OBJECT_KIND = 'deployment';
}
