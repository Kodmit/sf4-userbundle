<?php
namespace Kodmit\UserBundle;

use Kodmit\UserBundle\DependencyInjection\KodmitUserExtension;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KodmitUserBundle extends Bundle
{

    public function getContainerExtension(Generator $generator)
    {
        return new KodmitUserExtension($generator);
    }
}