<?php
/**
 * this file is part of Nora
 *
 * @package DI
 */
declare(strict_types=1);

namespace Nora\Architecture\AOP\Compiler;

use Nora\Architecture\AOP\Bind\BindInterface;

interface CompilerInterface
{
    public function compile(string $class, BindInterface $bind) : string;
    public function newInstance(string $class, array $args, BindInterface $bind);
}
