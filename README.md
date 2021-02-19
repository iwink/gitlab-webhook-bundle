# GitLab Webhook Bundle

Symfony bundle to process [GitLab webhooks](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html).

## Installation

To use this bundle, install it using [Composer](getcomposer.org): `composer require iwink/gitlab-webhook-bundle`. If 
your project uses [Symfony Flex](https://github.com/symfony/flex), you are done. If not, make sure to enable the bundle
in your project's `config/bundles.php`.

## Usage

To mark a controller as a GitLab webhook, you can use the `@Webhook(event="event")` annotation above your controller and
define a `Iwink\GitLabWebhookBundle\Event\WebhookEvent` argument in your method:

```php
<?php

namespace App\Controller;

use Iwink\GitLabWebhookBundle\Annotation\Webhook;
use Iwink\GitLabWebhookBundle\Event\PipelineEvent;
use Iwink\GitLabWebhookBundle\Scheduler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/webhook", name="webhook_")
 */
class WebhookController {
    /**
     * @Route("/pipeline", name="pipeline")
     * @Webhook("pipeline")
     */
    public function pipeline(PipelineEvent $event, Scheduler $scheduler): JsonResponse {
        $status = $event->getObjectAttributes()['status'];
        if ('success' === $status) {
            $scheduler->schedule([$this, 'expensiveOperation'], ['one', true]);
        }

        return new JsonResponse();
    }

    public function expensiveOperation(string $name, bool $valid): void {
        // Does something expensive
    }
}

```

The example above annotates the `pipeline` method as a webhook which receives a 
[`Pipeline Hook`](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#pipeline-events) event by using 
the `@Webhook("pipeline")` annotation. The event is injected into the method's `$event` argument. The injection is based
on the typehint (`PipelineEvent`) of the argument, the argument's name doesn't matter. Because GitLab expects a response 
[as soon as possible](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#webhook-endpoint-tips), the 
expensive part of the webhook is scheduled and executed after a response has been sent by the 
`Iwink\GitLabWebhookBundle\Scheduler::schedule()` method.

### Multiple webhooks

It's possible to register multiple webhooks to a single controller by using multiple `@Webhook` annotations:

```php
<?php

namespace App\Controller;

use Iwink\GitLabWebhookBundle\Annotation\Webhook;
use Iwink\GitLabWebhookBundle\Event\MergeRequestEvent;
use Iwink\GitLabWebhookBundle\Event\PushEvent;
use Iwink\GitLabWebhookBundle\Event\WebhookEvent;
use Iwink\GitLabWebhookBundle\Scheduler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/webhook", name="webhook_")
 */
class WebhookController {
    /**
     * @Route("/pipeline", name="pipeline")
     * @Webhook("push")
     * @Webhook(event="merge request")
     */
    public function pipeline(WebhookEvent $event, Scheduler $scheduler): JsonResponse {
        if (
            ($event instanceof PushEvent && 'some/project' === $event->getProject()['name'])
            || ($event instanceof MergeRequestEvent && 'success' === $event['object_attributes']['status'])
        ) {
            $scheduler->schedule([$this, 'expensiveOperation']);
        }

        return new JsonResponse();
    }

    public function expensiveOperation(): void {
        // Does something expensive
    }
}

```

The injected `$event` is now either a `Iwink\GitLabWebhookBundle\Event\PushEvent` or a 
`Iwink\GitLabWebhookBundle\Event\MergeRequestEvent`. Notice the difference between the 2 `@Webhook` annotations, both 
the short (`@Webhook("push")`) and the long (`@Webhook(event="merge request")`) syntax give the same result so it 
doesn't matter which syntax you use.

### Supported webhooks

The following webhooks are supported:

- [**comment**](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#comment-events) ([`Iwink\GitLabWebhookBundle\Event\CommentEvent`](src/Event/CommentEvent.php))
- [**deployment**](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#deployment-events) ([`Iwink\GitLabWebhookBundle\Event\DeploymentEvent`](src/Event/DeploymentEvent.php))
- [**feature flag**](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#feature-flag-events) ([`Iwink\GitLabWebhookBundle\Event\FeatureFlagEvent`](src/Event/FeatureFlagEvent.php))
- [**issue**](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#issue-events) ([`Iwink\GitLabWebhookBundle\Event\IssueEvent`](src/Event/IssueEvent.php))
- [**job**](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#job-events) ([`Iwink\GitLabWebhookBundle\Event\JobEvent`](src/Event/JobEvent.php))
- [**merge request**](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#merge-request-events) ([`Iwink\GitLabWebhookBundle\Event\MergeRequestEvent`](src/Event/MergeRequestEvent.php))
- [**pipeline**](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#pipeline-events) ([`Iwink\GitLabWebhookBundle\Event\PipelineEvent`](src/Event/PipelineEvent.php))
- [**push**](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#push-events) ([`Iwink\GitLabWebhookBundle\Event\PushEvent`](src/Event/PushEvent.php))
- [**release**](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#release-events) ([`Iwink\GitLabWebhookBundle\Event\ReleaseEvent`](src/Event/ReleaseEvent.php))
- [**tag**](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#tag-events) ([`Iwink\GitLabWebhookBundle\Event\TagEvent`](src/Event/TagEvent.php))
- [**wiki page**](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#wiki-page-events) ([`Iwink\GitLabWebhookBundle\Event\WikiPageEvent`](src/Event/WikiPageEvent.php))
