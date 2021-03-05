<?php

namespace Iwink\GitLabWebhookBundle\Tests\Annotation\Reflection;

use Iwink\GitLabWebhookBundle\Annotation\Reflection\ParameterAwareTrait;
use Iwink\GitLabWebhookBundle\Tests\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Unit tests for {@see ParameterAwareTrait}.
 * @since $ver$
 */
class ParameterAwareTraitTest extends TestCase {
	/**
	 * Data provider for {@see ParameterAwareTrait::getDocComment()} without replacing content.
	 * @since $ver$
	 * @return mixed[] The data set.
	 */
	public function getDocCommentNoReplacementDataProvider(): array {
		return [
			'No comment, no parameters' => [false, null],
			'No comment, parameters' => [false, $parameterBag = $this->createMock(ParameterBagInterface::class)],
			'Comment, no parameters' => ['', $parameterBag],
		];
	}

	/**
	 * Test case for {@see ParameterAwareTrait::getDocComment()} without replacing content.
	 * @since $ver$
	 * @param string|false $docComment Doc comment.
	 * @param ParameterBagInterface|null $parameterBag Parameter bag.
	 * @dataProvider getDocCommentNoReplacementDataProvider Data provider.
	 */
	public function testGetDocCommentNoReplacement($docComment, ?ParameterBagInterface $parameterBag): void {
		$reflection = (new ParameterAwareReflection($docComment))->setParameterBag($parameterBag);

		self::assertSame($docComment, $reflection->getDocComment());
	}

	/**
	 * Data provider for {@see ParameterAwareTrait::getDocComment()}.
	 * @since $ver$
	 * @return mixed[] The data set.
	 */
	public function getDocCommentDataProvider(): array {
		return [
			'No replacement (no markers)' => [
				'no markers',
				'no markers',
				[],
			],
			'No replacement (invalid markers)' => [
				"%marker\n%marker",
				"%marker\n%marker",
				[],
			],
			'Single line replacement' => [
				'has %param%',
				'has resolved',
				['param' => 'resolved'],
			],
			'Multi line replacement' => [
				"has %param_1%\nhas %param_2%",
				"has resolved_1\nhas resolved_2",
				['param_1' => 'resolved_1', 'param_2' => 'resolved_2'],
			],
			'Array replacement' => [
				'has %param%',
				'has {"first","second"}',
				['param' => ['first', 'second']],
			],
			'Complex replacement' => [
				"has %scalar% and invalid %\nwith array %array%\nand no marker",
				"has scalar and invalid %\nwith array {\"first\",\"second\"}\nand no marker",
				['scalar' => 'scalar', 'array' => ['first', 'second']],
			],
		];
	}

	/**
	 * Test case for {@see ParameterAwareTrait::getDocComment()}.
	 * @since $ver$
	 * @param string $docComment Original doc comment.
	 * @param string $expected Replaced doc comment.
	 * @param mixed[] $parameters Parameters for the parameter bag.
	 * @dataProvider getDocCommentDataProvider Data provider.
	 */
	public function testGetDocComment(string $docComment, string $expected, array $parameters): void {
		$reflection = (new ParameterAwareReflection($docComment))->setParameterBag(new ParameterBag($parameters));

		self::assertSame($expected, $reflection->getDocComment());
	}
}

/**
 * Base reflection class.
 * @since $ver$
 */
abstract class Reflection {
	private $docComment;

	public function __construct($docComment) {
		$this->docComment = $docComment;
	}

	public function getDocComment() {
		return $this->docComment;
	}
}

/**
 * Parameter aware reflection to test.
 * @since $ver$
 */
class ParameterAwareReflection extends Reflection {
	use ParameterAwareTrait;
}
