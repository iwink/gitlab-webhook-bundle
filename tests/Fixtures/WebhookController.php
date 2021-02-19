<?php

namespace Iwink\GitLabWebhookBundle\Tests\Fixtures;

use Iwink\GitLabWebhookBundle\Annotation\Webhook;

/**
 * Testable controller.
 * @since 1.0.0
 */
class WebhookController {
	/**
	 * Action without annotation.
	 * @since 1.0.0
	 */
	public function noAnnotation(): void {
	}

	/**
	 * Annotated action.
	 * @since 1.0.0
	 * @Webhook(event="pipeline")
	 */
	public function annotation(): void {
	}
}
