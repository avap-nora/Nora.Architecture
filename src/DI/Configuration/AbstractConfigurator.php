<?php
/**
 * this file is part of Nora
 */
declare(strict_types=1);

namespace Nora\Architecture\DI\Configuration;

use Nora\Architecture\AOP\Pointcut\AbstractMatcher;
use Nora\Architecture\AOP\Pointcut\Matcher;
use Nora\Architecture\AOP\Pointcut\Pointcut;
use Nora\Architecture\DI\Bind;
use Nora\Architecture\DI\Container;
use Nora\Architecture\DI\Container\ContainerInterface;
use Nora\Architecture\DI\ValueObject\Scope;

abstract class AbstractConfigurator
{
    protected $matcher;
    protected $lastConfigurator;
    private $container;

    public function __construct(
        self $configurator = null
    ) {
        $this->lastConfigurator = $configurator;
        $this->activate();
        if ($configurator instanceof self) {
            $this->container->merge($configurator->getContainer());
        }
    }

    public function __toString()
    {
        return (new ConfiguratorString)($this->getContainer(), $this->getContainer()->getPointcuts());
    }

    public function getContainer() : ContainerInterface
    {
        return $this->container;
    }

    public function install(self $configurator)
    {
        $this->getContainer()->merge($configurator->getContainer());
    }

    public function override(self $configurator)
    {
        $configurator->getContainer()->merge($this->container);
        $this->container = $configurator->getContainer();
    }

    /**
     * Do Container Configuration
     */
    abstract public function configure();

    protected function bind(string $interface = '') : Bind
    {
        return new Bind($this->getContainer(), $interface);
    }

    protected function bindInterceptor(
        AbstractMatcher $classMatcher,
        AbstractMatcher $methodMatcher,
        array $interceptors
    ) {
        $pointcut = new Pointcut($classMatcher, $methodMatcher, $interceptors);
        $this->getContainer()->addPointcut($pointcut);
        foreach ($interceptors as $interceptor) {
            $this->bind($interceptor)->to($interceptor)->in(Scope::SINGLETON);
        }
    }

    public function activate()
    {
        $this->container = new Container();
        $this->matcher = new Matcher();
        $this->configure();
    }
}
