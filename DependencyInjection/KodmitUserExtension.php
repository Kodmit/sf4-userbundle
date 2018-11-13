<?php

namespace Kodmit\UserBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Bundle\MakerBundle\Util\YamlSourceManipulator;
use Symfony\Bundle\MakerBundle\Generator;

class KodmitUserExtension extends Extension
{

    /** @var YamlSourceManipulator */
    private $manipulator;

    /** @var Generator */
    private $generator;

    public function load(array $configs, ContainerBuilder $container)
    {


        $yamlSource = './config/services.yaml';
        $this->manipulator = new YamlSourceManipulator($yamlSource);

        $newData = $this->manipulator->getData();

        if (!isset($newData['services']['Kodmit\\UserBundle\\'])) {
            $newData['services'] = ['Kodmit\\UserBundle\\' => ["resource" => "testttt"]];
        }

        $this->manipulator->setData($newData);
        $contents = $this->manipulator->getContents();

        $this->generator->dumpFile($yamlSource, $contents);


    }


}