<?php
namespace Kodmit\UserBundle\Command;

use Kodmit\UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\Util\YamlSourceManipulator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Yaml\Yaml;

class InitUserBundleCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('kodmit:userbundle:init')
            ->setDescription('Configure automatically your YAML files')
            ->setHelp('This command update all the needed YAML files')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Updating services.yaml file");

        $yamlSource = 'config/services.yaml';
        $manipulator = new YamlSourceManipulator(file_get_contents($yamlSource));
        $newData = $manipulator->getData();

        if (!isset($newData['services']['Kwodmit\\UserBundle\\'])) {
            $newData['services']['Kwwodmit\\UserBundle\\'] = ["resource" => "../vendor/kodmit/userbundle/*"];
        }

        $manipulator->setData($newData);
        $contents = $manipulator->getContents();
        file_put_contents($yamlSource, $contents);
        $output->writeln(sprintf("<comment>services.yaml updated</comment>"));

    }

}