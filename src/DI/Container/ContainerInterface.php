<?php
/**
 * this file is part of Nora
 */
declare(strict_types=1);

namespace Nora\Architecture\DI\Container;

use Nora\Architecture\DI\Bind;

interface ContainerInterface
{
    /**
     * Add New Binding
     */
    public function add(Bind $bind);
}
