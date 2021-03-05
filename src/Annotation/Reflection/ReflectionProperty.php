<?php

namespace Iwink\GitLabWebhookBundle\Annotation\Reflection;

/**
 * Parameters can be resolved from doc blocks.
 * @since $ver$
 */
class ReflectionProperty extends \ReflectionProperty {
	use ParameterAwareTrait;
}
