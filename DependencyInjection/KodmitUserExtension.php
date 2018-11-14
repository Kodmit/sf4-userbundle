<?php

namespace Kodmit\UserBundle\DependencyInjection;

use App\Kernel;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Bundle\MakerBundle\Util\YamlSourceManipulator;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\ConsoleStyle;

class KodmitUserExtension extends Extension implements ExtensionInterface
{


    public function load(array $configs, ContainerBuilder $container)
    {
        $kernel = new Kernel();
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array(
            'command' => 'kodmit:userbundle:init'
        ));

        $output = new BufferedOutput();
        $application->run($input, $output);

    }


}