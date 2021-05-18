<?php

namespace Iwink\GitLabWebhookBundle\Event;

/**
 * A GitLab system event {@link https://docs.gitlab.com/ce/system_hooks/system_hooks.html}.
 * @since $ver$
 */
class SystemEvent extends WebhookEvent {
	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const EVENT_HEADER = 'System Hook';

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	protected const OBJECT_KIND = null;
}
