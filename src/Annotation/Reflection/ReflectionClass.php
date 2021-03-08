<?php

namespace Iwink\GitLabWebhookBundle\Annotation\Reflection;

/**
 * Parameters can be resolved from doc blocks.
 * @since $ver$
 */
class ReflectionClass extends \ReflectionClass {
	use ParameterAwareTrait;
}
