<?php
namespace NoraArchitectureTest;

use Nora\Architecture\DI\Annotation\Inject;
use Nora\Architecture\DI\Annotation\PostConstruct;

class FakeLang
{
    public $comp;

    /**
     * @Inject
     */
    public function setLangHoge(FakeComponent $comp)
    {
        $this->comp = $comp;
    }
}
