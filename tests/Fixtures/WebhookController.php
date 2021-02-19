<?php

namespace Iwink\GitLabWebhookBundle\Tests\Fixtures;

use Iwink\GitLabWebhookBundle\Annotation\Webhook;

/**
 * Testable controller.
 * @since $ver$
 */
class WebhookController {
	/**
	 * Action without annotation.
	 * @since $ver$
	 */
	public function noAnnotation(): void {
	}

	/**
	 * Annotated action.
	 * @since $ver$
	 * @Webhook(event="pipeline")
	 */
	public function annotation(): void {
	}
}
