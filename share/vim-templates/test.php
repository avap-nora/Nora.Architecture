<?php
declare(strict_types=1);

namespace Nora\Architecture;

use PHPUnit\Framework\TestCase;

class ArchitectureTest extends TestCase
{
    public function testIsTrue()
    {
        $this->assertInstanceOf(Architecture::class, new Architecture());
    }
}
