<?php

namespace Iwink\GitLabWebhookBundle\Annotation\Reflection;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Resolves parameters in doc comments.
 * @since $ver$
 */
trait ParameterAwareTrait {
	/**
	 * The parameter bag used to resolve parameters.
	 * @since $ver$
	 * @var ParameterBagInterface|null
	 */
	private ?ParameterBagInterface $parameterBag = null;

	/**
	 * @inheritDoc
	 *
	 * Tries to resolves parameters in doc comments.
	 *
	 * @since $ver$
	 */
	public function getDocComment() {
		$comment = parent::getDocComment();
		if (false === $comment || null === $this->parameterBag) {
			return $comment;
		}

		$lines = [];
		foreach (explode(PHP_EOL, $comment) as $line) {
			$lines[] = preg_replace_callback(
				'/%([^%]+)%/',
				function (array $matches): string {
					$parameter = $this->parameterBag->resolveValue($matches[0]);

					return is_array($parameter) ? sprintf('{"%s"}', implode('","', $parameter)) : $parameter;
				},
				$line
			);
		}

		return implode(PHP_EOL, $lines);
	}

	/**
	 * Sets the parameter bag.
	 * @since $ver$
	 * @param ParameterBagInterface|null $parameterBag The parameter bag.
	 * @return $this Instance.
	 */
	public function setParameterBag(?ParameterBagInterface $parameterBag): self {
		$this->parameterBag = $parameterBag;

		return $this;
	}
}
