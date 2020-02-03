<?php
declare(strict_types=1);
namespace Nora\Architecture\DI;

use Nora\Architecture\AOP\Bind\Bind;
use Nora\Architecture\DI\Container\ContainerInterface;
use Nora\Architecture\DI\ValueObject\Name;

final class AspectBind
{
    /**
     * @var Bind
     */
    private $bind;
    public function __construct(Bind $bind)
    {
        $this->bind = $bind;
    }
    /**
     * Instantiate interceptors
     */
    public function inject(ContainerInterface $container) : array
    {
        $bindings = $this->bind->getBindings();
        foreach ($bindings as &$interceptors) {
            /* @var string[] $interceptors */
            foreach ($interceptors as &$interceptor) {
                if (\is_string($interceptor)) {
                    $interceptor = $container->getInstance($interceptor, Name::ANY);
                }
            }
        }
        return $bindings;
    }
}
