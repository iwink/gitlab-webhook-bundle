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
	 * List of supported event names.
	 * @since $ver$
	 * @var string[]
	 */
	private const SUPPORTED_EVENT_NAMES = [
		'group_create',
		'group_destroy',
		'group_rename',
		'key_create',
		'key_destroy',
		'project_create',
		'project_destroy',
		'project_rename',
		'project_transfer',
		'project_update',
		'repository_update',
		'user_add_to_group',
		'user_add_to_team',
		'user_create',
		'user_destroy',
		'user_failed_login',
		'user_remove_from_group',
		'user_remove_from_team',
		'user_rename',
		'user_update_for_group',
		'user_update_for_team',
	];

	/**
	 * @inheritDoc
	 * @since $ver$
	 */
	public static function validateData(array $data): bool {
		$eventName = $data['event_name'] ?? null;

		return in_array($eventName, self::SUPPORTED_EVENT_NAMES, true);
	}
}
