<?php
/**
 * this file is part of Nora
 *
 * @package DI
 */
declare(strict_types=1);

namespace Nora\Architecture\DI;

use Nora\Architecture\AOP\Compiler\Compiler;
use Nora\Architecture\DI\Configuration\AbstractConfigurator;
use Nora\Architecture\DI\Configuration\NullConfigurator;
use Nora\Architecture\DI\Dependency\Dependency;
use Nora\Architecture\DI\Exception\Untargeted;
use Nora\Architecture\DI\ValueObject\Name;

class Injector implements InjectorInterface
{
    private $classDir;
    private $container;

    public function __construct(AbstractConfigurator $configurator = null, string $tmpDir = '')
    {
        $configurator = $configurator ?? new NullConfigurator();
        $this->container = $configurator->getContainer();
        $this->classDir = is_dir($tmpDir) ? $tmpDir: sys_get_temp_dir();
        $this->container->weaveAspects(new Compiler($this->classDir));
        (new Bind($this->container, InjectorInterface::class))->toInstance($this);
    }

    public function __wakeup()
    {
        spl_autoload_register(
            function (string $class) {
                $file = sprintf('%s/%s.php', $this->classDir, str_replace('\\', '_', $class));
                if (file_exists($file)) {
                    include $file;
                }
            }
        );
    }

    public function getInstance($interface, $name = Name::ANY)
    {
        try {
            $instance = $this->container->getInstance($interface, $name);
        } catch (Untargeted $e) {
            $this->bind($interface);
            $instance = $this->getInstance($interface, $name);
        }
        return $instance;
    }

    private function bind(string $class)
    {
        new Bind($this->container, $class);
        $bound = $this->container[$class . '-' . Name::ANY];
        if ($bound instanceof Dependency) {
            $this->container->weaveAspect(new Compiler($this->classDir), $bound)->getInstance($class, Name::ANY);
        }
    }
}
