<?php

namespace Iwink\GitLabWebhookBundle\Annotation\Reflection;

/**
 * Parameters can be resolved from doc blocks.
 * @since 1.1.0
 */
class ReflectionProperty extends \ReflectionProperty {
	use ParameterAwareTrait;
}
