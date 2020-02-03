<?php

namespace Nora\Architecture\AOP\DI;

use Nora\Architecture\AOP\Advice\MethodInterceptor;
use Nora\Architecture\AOP\Bind\Bind;
use Nora\Architecture\AOP\Compiler\CompilerInterface;
use Nora\Architecture\AOP\WeavedInterface;
use ReflectionClass;

trait DependencyWeaveAspects
{
    public function weaveAspects(CompilerInterface $compiler, array $pointcuts)
    {
        $class = (string) $this->instantiator;
        $isInterceptor = (new ReflectionClass($class))->implementsInterface(MethodInterceptor::class);
        $isWeaved = (new ReflectionClass($class))->implementsInterface(WeavedInterface::class);
        if ($isInterceptor || $isWeaved) {
            return;
        }
        $bind = new Bind();
        $bind->bind($class, $pointcuts);
        if (!$bind->getBindings()) {
            return;
        }
        $class = $compiler->compile($class, $bind);
        $this->instantiator->weaveAspects($class, $bind);
    }
}
