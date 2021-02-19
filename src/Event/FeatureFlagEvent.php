<?php

namespace Iwink\GitLabWebhookBundle\Event;

use Iwink\GitLabWebhookBundle\Event\Behavior\ObjectAttributesBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Iwink\GitLabWebhookBundle\Event\Behavior\UserBehaviorTrait;

/**
 * A GitLab feature flag event
 * {@link https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#feature-flag-events}.
 * @since $ver$
 */
class FeatureFlagEvent extends WebhookEvent {
	use ObjectAttributesBehaviorTrait;
	use ProjectBehaviorTrait;
	use UserBehaviorTrait;

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const EVENT_HEADER = 'Feature Flag Hook';

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const OBJECT_KIND = 'feature_flag';
}
