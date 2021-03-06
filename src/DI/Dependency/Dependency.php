<?php
/**
 * this file is part of Nora
 */
declare(strict_types=1);

namespace Nora\Architecture\DI\Dependency;

use Nora\Architecture\AOP\DI\DependencyWeaveAspects;
use Nora\Architecture\DI\Bind;
use Nora\Architecture\DI\Container\ContainerInterface;
use Nora\Architecture\DI\Injector\Instantiator;
use Nora\Architecture\DI\ValueObject\Scope;
use ReflectionMethod;

class Dependency implements DependencyInterface
{
    private $scope = Scope::PROTOTYPE;
    private $isSingleton = false;
    private $instance;
    private $instantiator;
    private $postConstruct;

    use DependencyWeaveAspects;

    public function __construct(
        Instantiator $instantiator,
        ReflectionMethod $postConstruct = null
    ) {
        $this->instantiator = $instantiator;
        $this->postConstruct = $postConstruct ? $postConstruct->name: null;
    }

    public function __sleep()
    {
        return ['instantiator', 'postConstruct', 'isSingleton'];
    }

    public function __toString()
    {
        return sprintf('(dependency) %s', (string) $this->instantiator);
    }

    public function register(ContainerInterface $container, Bind $bind)
    {
        $this->index = $index = (string) $bind;
        $container[$index] = $bind->getBound();
    }

    public function setScope($scope)
    {
        if ($scope === Scope::SINGLETON) {
            $this->isSingleton = true;
        }
    }

    public function inject(ContainerInterface $container)
    {
        if ($this->isSingleton === true && $this->instance) {
            return $this->instance;
        }

        $this->instance = ($this->instantiator)($container);
        if ($this->postConstruct) {
            $this->instance->{$this->postConstruct}();
        }
        return $this->instance;
    }
}
