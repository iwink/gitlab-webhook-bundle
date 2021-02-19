<?php

namespace Kirra\Bundle\GitLabWebhookBundle\Event;

use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\ObjectAttributesBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\UserBehaviorTrait;

/**
 * A GitLab wiki page event {@link https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#wiki-page-events}.
 * @since $ver$
 */
class WikiPageEvent extends WebhookEvent {
	use ObjectAttributesBehaviorTrait;
	use ProjectBehaviorTrait;
	use UserBehaviorTrait;

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const EVENT_HEADER = 'Wiki Page Hook';

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const OBJECT_KIND = 'wiki_page';
}
