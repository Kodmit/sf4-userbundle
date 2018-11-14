<?php

namespace Kodmit\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Process\Process;

class KodmitUserExtension extends Extension implements ExtensionInterface
{


    public function load(array $configs, ContainerBuilder $container)
    {
        $process = new Process(
            'bin/console kodmit:userbundle:init'
        );
        //$process->setWorkingDirectory("../");

        $process->start();

    }


}