<?php
declare(strict_types=1);
namespace Nora\Architecture\AOP\Compiler;

class ClassName
{
    public function __invoke(string $class, string $bindName) : string
    {
        return sprintf('%s_%s', $class, $bindName);
    }
}
