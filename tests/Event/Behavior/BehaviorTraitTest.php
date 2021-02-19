<?php

namespace Kirra\Bundle\GitLabWebhookBundle\Tests\Event\Behavior;

use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\CommitBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\ObjectAttributesBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\ProjectBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\RepositoryBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Event\Behavior\UserBehaviorTrait;
use Kirra\Bundle\GitLabWebhookBundle\Tests\TestCase;

/**
 * Unit tests for behavior traits.
 * @since $ver$
 */
class BehaviorTraitTest extends TestCase {
	/**
	 * Test case for behavior traits.
	 * @since $ver$
	 */
	public function testObjectAttributesTrait(): void {
		$data = ['commit', 'object_attributes', 'project', 'repository', 'user'];
		$behavior = new ImplementsBehavior(array_combine($data, array_fill(0, count($data), [])));

		self::assertSame([], $behavior->getCommit());
		self::assertSame([], $behavior->getObjectAttributes());
		self::assertSame([], $behavior->getProject());
		self::assertSame([], $behavior->getRepository());
		self::assertSame([], $behavior->getUser());
	}
}

/**
 * Implements behaviors for testing purposes.
 * @since $ver$
 */
class ImplementsBehavior {
	use CommitBehaviorTrait;
	use ObjectAttributesBehaviorTrait;
	use ProjectBehaviorTrait;
	use RepositoryBehaviorTrait;
	use UserBehaviorTrait;

	private array $data;

	public function __construct(array $data) {
		$this->data = $data;
	}
}
