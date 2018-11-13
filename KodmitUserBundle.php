<?php
namespace Kodmit\UserBundle;

use Kodmit\UserBundle\DependencyInjection\KodmitUserExtension;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KodmitUserBundle extends Bundle
{

    private $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function getContainerExtension()
    {
        return new KodmitUserExtension($this->generator);
    }
}