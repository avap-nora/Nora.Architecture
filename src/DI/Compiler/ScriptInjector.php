<?php
/**
 * this file is part of Nora
 *
 * @package DI
 */
declare(strict_types=1);

namespace Nora\Architecture\DI\Compiler;

use Nora\DI\Module\NullModule;
use Nora\Architecture\DI\Injector;
use Nora\Architecture\DI\InjectorInterface;
use Nora\Architecture\DI\ValueObject\Name;

class ScriptInjector implements InjectorInterface
{
    public function __construct($scriptDir, callable $lazyConfigurator = null)
    {
        $this->lazyConfigurator = $lazyConfigurator ?? function () {
            return new NullModule();
        };

        // あとで続きを書く
        
        // 取り急ぎ
        $this->injector = new Injector(($this->lazyConfigurator)());
    }

    public function getInstance($interface, $name = Name::ANY)
    {
        return $this->injector->getInstance($interface, $name);
    }
}
