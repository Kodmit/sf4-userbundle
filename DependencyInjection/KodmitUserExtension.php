<?php

namespace Kodmit\UserBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Bundle\MakerBundle\Util\YamlSourceManipulator;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\ConsoleStyle;

class KodmitUserExtension extends Extension
{

    private $manipulator;

    private $generator;

    private $consoleStyle;


    public function load(array $configs, ContainerBuilder $container)
    {

        $yamlSource = 'config/services.yaml';

        $this->manipulator = new YamlSourceManipulator(file_get_contents($yamlSource));

        $newData = $this->manipulator->getData();

        if (!isset($newData['services']['Kodmit\\UserBundle\\'])) {
            $newData['services']['Kodmit\\UserBundle\\'] = [];
        }

        $this->manipulator->setData($newData);
        $contents = $this->manipulator->getContents();

        $generator = new Generator();

        $generator->dumpFile($yamlSource, $contents);
        $generator->writeChanges();

        //$this->consoleStyle->writeln("services.yaml file updated.");


    }


}