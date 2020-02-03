<?php
namespace NoraArchitectureTest;

/**
 * @Annotation
 * @Target("METHOD")
 */
class FakeTrace
{
    public $rel;
    public $src;
}
