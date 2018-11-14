<?php

namespace Kodmit\UserBundle\ComposerInstaller;

use Symfony\Bundle\MakerBundle\Util\YamlSourceManipulator;

class PostInstallEvent{

    public function init(){

        $yamlSource = 'config/services.yaml';
        $manipulator = new YamlSourceManipulator(file_get_contents($yamlSource));
        $newData = $manipulator->getData();

        if (!isset($newData['services']['Kwodmit\\UserBundle\\'])) {
            $newData['services']['Kwwodmit\\UserBundle\\'] = ["resource" => "../vendor/kodmit/userbundle/*"];
        }

        $manipulator->setData($newData);
        $contents = $manipulator->getContents();
        file_put_contents($yamlSource, $contents);


    }

}