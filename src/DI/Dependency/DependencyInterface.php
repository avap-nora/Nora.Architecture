<?php
/**
 * this file is part of Nora
 */
declare(strict_types=1);

namespace Nora\Architecture\DI\Dependency;

use Nora\Architecture\DI\Bind;
use Nora\Architecture\DI\Container\ContainerInterface;

interface DependencyInterface
{
    public function register(ContainerInterface $container, Bind $bind);
}
