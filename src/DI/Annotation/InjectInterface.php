<?php
/**
 * this file is part of Nora
 *
 * @package DI
 */
declare(strict_types=1);

namespace Nora\Architecture\DI\Annotation;

interface InjectInterface
{
    public function isOptional() : bool;
}
