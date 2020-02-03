<?php
/**
 * this file is part of Nora
 *
 * @package Dotenv
 */
declare(strict_types=1);

namespace Nora\Architecture\DI\Dependency;

use Doctrine\Common\Annotations\AnnotationReader;
use Nora\Architecture\DI\Injector\InjectionPoints;
use Nora\Architecture\DI\Injector\Instantiator;
use Nora\Architecture\DI\Injector\MethodInjectors;
use Nora\Architecture\DI\Manipulation\ClassManipulator;
use Nora\Architecture\DI\ValueObject\Name;
use ReflectionClass;
use ReflectionMethod;

final class DependencyFactory
{
    public function newDependency(ReflectionClass $class) : DependencyInterface
    {
        $manipulator = (new ClassManipulator(new AnnotationReader))($class);
        return new Dependency(
            $manipulator->buildInstantiator($class),
            $manipulator->getPostConstruct($class),
        );
    }

    public function newToConstructor(
        ReflectionClass $class,
        string $name,
        InjectionPoints $injectionPoints = null,
        ReflectionMethod $postConstruct = null
    ) : Dependency {
        return new Dependency(
            new Instantiator(
                $class,
                $injectionPoints ?  $injectionPoints($class->name): new MethodInjectors([]),
                new Name($name)
            ),
            $postConstruct
        );
    }

    public function newProvider(
        ReflectionClass $provider,
        string $context
    ) : DependencyProvider {
        $dependency = $this->newDependency($provider);
        return new DependencyProvider($dependency, $context);
    }
}
