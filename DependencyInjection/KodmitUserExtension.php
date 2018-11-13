<?php

namespace Kodmit\UserBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;

class KodmitUserExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {

        // Update services
        $service_path = "./config/services.yaml";
        $services = Yaml::parseFile($service_path);
        array_push($services, ["test" => ["value" => "ok"]]);
        $yaml = Yaml::dump($services);
        file_put_contents($service_path, $yaml);
    }
}