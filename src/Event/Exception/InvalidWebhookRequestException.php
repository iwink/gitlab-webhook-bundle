<?php

namespace Iwink\GitLabWebhookBundle\Event\Exception;

use Symfony\Component\HttpFoundation\Request;

/**
 * Event that is thrown if a {@see Request} couldn't be parsed to a webhook event.
 * @since 1.0.0
 */
class InvalidWebhookRequestException extends \InvalidArgumentException {
}
