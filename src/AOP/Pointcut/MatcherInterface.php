<?php
/**
 * this file is part of Nora
 *
 * @package DI
 */
declare(strict_types=1);

namespace Nora\Architecture\AOP\Pointcut;

interface MatcherInterface
{
    /**
     */
    public function any();
    /**
     */
    public function annotatedWith($annotationName) : AbstractMatcher;
}
