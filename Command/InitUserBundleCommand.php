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

        $helper = $this->getHelper('question');

        $question = new Question("Do you want to automatically update config files ? [y/n]: \n");
        $question->setValidator(function ($response) {
            if (empty($response)) {
                throw new \Exception('You need to answer.');
            }
            elseif($response != "y" && $response != "n"){
                throw new \Exception('Bad response.');
            }
            return $response;
        });
        $response = $helper->ask($input, $output, $question);

        if($response == "y"){
            $yamlSource = 'config/services.yaml';
            $manipulator = new YamlSourceManipulator(file_get_contents($yamlSource));
            $newData = $manipulator->getData();

            if (!isset($newData['services']['Kwodmit\\UserBundle\\'])) {
                $newData['services']['Kofdmit\\UserBundle\\'] = ["resource" => "../vendor/kodmit/userbundle/*"];
            }
            $manipulator->setData($newData);
            $contents = $manipulator->getContents();
            file_put_contents($yamlSource, $contents);
            $output->writeln(sprintf("<comment>services.yaml updated</comment>"));
        }
        else{
            $output->writeln(sprintf("<comment>services.yaml not updated, you will need to do it manually.</comment>"));
        }


    }

}