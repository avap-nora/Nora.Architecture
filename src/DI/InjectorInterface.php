<?php
declare(strict_types=1);
namespace Nora\Architecture\DI;

use Nora\Architecture\DI\ValueObject\Name;

interface InjectorInterface
{
    /**
     * Return instance by interface + name (interface namespace)
     *
     * @param string $interface
     * @param string $name
     */
    public function getInstance($interface, $name = Name::ANY);
}
