<?php
declare(strict_types=1);
namespace Nora\Architecture\AOP\Compiler\CodeGen;

use Nora\Architecture\AOP\Bind\BindInterface;
use ReflectionClass;

interface CodeGenInterface
{
    public function generate(ReflectionClass $sourceClass, BindInterface $bind) : Code;
}
