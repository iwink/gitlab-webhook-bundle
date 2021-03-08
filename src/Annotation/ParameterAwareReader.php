<?php

namespace Iwink\GitLabWebhookBundle\Annotation;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\DocParser;
use Iwink\GitLabWebhookBundle\Annotation\Reflection\ReflectionClass;
use Iwink\GitLabWebhookBundle\Annotation\Reflection\ReflectionMethod;
use Iwink\GitLabWebhookBundle\Annotation\Reflection\ReflectionProperty;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Annotation reader that is aware of container parameters.
 * @since 1.1.0
 * @codeCoverageIgnore
 */
class ParameterAwareReader extends AnnotationReader {
	/**
	 * Parameter bag.
	 * @since 1.1.0
	 * @var ParameterBagInterface
	 */
	private ParameterBagInterface $parameterBag;

	/**
	 * Creates a new reader.
	 * @param ParameterBagInterface $parameterBag Parameter bag.
	 * @param DocParser|null $parser Optional parser
	 * @throws AnnotationException If the reader couldn't be initialized.
	 */
	public function __construct(ParameterBagInterface $parameterBag, ?DocParser $parser = null) {
		parent::__construct($parser);

		$this->parameterBag = $parameterBag;
	}

	/**
	 * @inheritDoc
	 * @since 1.1.0
	 */
	public function getClassAnnotations(\ReflectionClass $class): array {
		$reflection = (new ReflectionClass($class->name))->setParameterBag($this->parameterBag);

		return parent::getClassAnnotations($reflection);
	}

	/**
	 * @inheritDoc
	 * @since 1.1.0
	 */
	public function getMethodAnnotations(\ReflectionMethod $method): array {
		$reflection = (new ReflectionMethod($method->class, $method->getName()))->setParameterBag($this->parameterBag);

		return parent::getMethodAnnotations($reflection);
	}

	/**
	 * @inheritDoc
	 * @since 1.1.0
	 */
	public function getPropertyAnnotations(\ReflectionProperty $property): array {
		$reflection = (new ReflectionProperty($property->class, $property->getName()))->setParameterBag($this->parameterBag);

		return parent::getPropertyAnnotations($reflection);
	}
}
