<?php

namespace Kodmit\UserBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Bundle\MakerBundle\Util\YamlSourceManipulator;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\ConsoleStyle;

class KodmitUserExtension extends Extension
{

    private $consoleStyle;

    public function load(array $configs, Generator $generator)
    {

        $yamlSource = 'config/services.yaml';

        $manipulator = new YamlSourceManipulator(file_get_contents($yamlSource));

        $newData = $manipulator->getData();

        if (!isset($newData['services']['Kodmit\\UserBundle\\'])) {
            $newData['services']['Kodmit\\UserBundle\\'] = [];
        }

        $manipulator->setData($newData);
        $contents = $manipulator->getContents();

        $generator->dumpFile($yamlSource, $contents);
        $generator->writeChanges();

        //$this->consoleStyle->writeln("services.yaml file updated.");


    }


}