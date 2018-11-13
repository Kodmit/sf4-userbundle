<?php

namespace Kodmit\UserBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;

class KodmitUserExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {


        $service["services"] = ["test" => ["value" => "ok"]];

        $yaml = Yaml::dump($service, 2);

        file_put_contents('./config/services.yaml', $yaml, FILE_APPEND);
    }

}