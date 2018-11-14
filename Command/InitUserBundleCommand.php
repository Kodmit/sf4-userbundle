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
        $output->writeln([
            "",
            "===============================",
            "--- UserBundle Configurator ---",
            "===============================",
            ""
        ]);

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
            $this->initServices($output);
            $this->initRoutes($output);
            $this->initTwig($output);
            $this->initSecurity($output);

            $output->writeln([
                "",
                " <comment>All done ! Update your schema ! ;)</comment> ",
                ""
            ]);

        }
        else{
            $output->writeln(sprintf("<comment>files not updated, you will need to do it manually.</comment>"));
        }


    }

    private function initServices($output){

        $yamlSource = 'config/services.yaml';
        $manipulator = new YamlSourceManipulator(file_get_contents($yamlSource));
        $newData = $manipulator->getData();

        if (!isset($newData['services']['Kodmit\\UserBundle\\'])) {
            $output->writeln("Updating services.yaml file...");
            $newData['services']['Kodmit\\UserBundle\\'] = ["resource" => "../vendor/kodmit/userbundle/*"];
            $manipulator->setData($newData);
            $contents = $manipulator->getContents();
            file_put_contents($yamlSource, $contents);
            $output->writeln(sprintf("<comment>services.yaml updated !</comment>"));
        }

    }

    private function initRoutes($output){
        $yamlSource = 'config/routes.yaml';

        if($this->emptyYaml($yamlSource)){
            $output->writeln("Updating routes.yaml file...");
            $data['kodmit_userbundle'] = ["resource" => "@KodmitUserBundle/Resources/config/routes.yaml"];
            $yaml = Yaml::dump($data, 2);
            file_put_contents($yamlSource, $yaml);
            $output->writeln(sprintf("<comment>routes.yaml updated !</comment>"));
        }
        else{
            $output->writeln("Updating routes.yaml file...");
            $manipulator = new YamlSourceManipulator(file_get_contents($yamlSource));
            $newData = $manipulator->getData();

            if (!isset($newData['kodmit_userbundle'])) {
                $newData['kodmit_userbundle'] = ["resource" => "@KodmitUserBundle/Resources/config/routes.yaml"];
            }
            $manipulator->setData($newData);
            $contents = $manipulator->getContents();
            file_put_contents($yamlSource, $contents);
            $output->writeln(sprintf("<comment>routes.yaml updated !</comment>"));
        }
    }

    private function initTwig($output){

        $yamlSource = 'config/packages/twig.yaml';
        $manipulator = new YamlSourceManipulator(file_get_contents($yamlSource));
        $newData = $manipulator->getData();

        if (!isset($newData['twig']['paths']['%kernel.project_dir%/vendor/kodmit/userbundle/Resources/views'])) {
            $output->writeln("Updating twig.yaml file...");
            $newData['twig']['paths']['%kernel.project_dir%/vendor/kodmit/userbundle/Resources/views'] = "KodmitUserBundle";
            $manipulator->setData($newData);
            $contents = $manipulator->getContents();
            file_put_contents($yamlSource, $contents);
            $output->writeln(sprintf("<comment>twig.yaml updated !</comment>"));
        }

    }

    private function initSecurity($output){

        $output->writeln("Updating security.yaml file...");

        $yamlSource = 'config/packages/security.yaml';
        $manipulator = new YamlSourceManipulator(file_get_contents($yamlSource));
        $newData = $manipulator->getData();

        // Define all data

        // encoders
        if (!isset($newData['security']['encoders']['Kodmit\UserBundle\Entity\User']['algorithm'])) {
            $newData['security']['encoders']['Kodmit\UserBundle\Entity\User']['algorithm'] = "argon2i";
            $output->writeln(" -> encoders updated");
        }

        // providers
        if (!isset($newData['security']['providers']['kodmit_userbundle_provider']['entity'])) {
            $newData['security']['providers']['kodmit_userbundle_provider']['entity']['class'] = "Kodmit\UserBundle\Entity\User";
            $newData['security']['providers']['kodmit_userbundle_provider']['entity']['property'] = "username";
            $output->writeln(" -> providers updated");
        }

        // firewalls
        if (!isset($newData['security']['firewalls']['main']['remember_me'])) {
            $newData['security']['firewalls']['main']['remember_me']["secret"] = "%kernel.secret%";
            $newData['security']['firewalls']['main']['remember_me']["lifetime"] = 604800;
            $newData['security']['firewalls']['main']['remember_me']["path"] = "/";

            $newData['security']['firewalls']['main']['logout']["path"] = "kodmit_userbundle_logout";

            $newData['security']['firewalls']['main']['guard']["authenticators"] = ["Kodmit\UserBundle\Security\KodmitUserBundleAuthenticator"];

            $newData['security']['firewalls']['main']['form_login'] = true;

            $output->writeln(" -> firewalls rules updated");
        }



        $manipulator->setData($newData);
        $contents = $manipulator->getContents();
        file_put_contents($yamlSource, $contents);
        $output->writeln(sprintf("<comment>security.yaml updated !</comment>"));

    }

    private function emptyYaml($file){
        $data = Yaml::parseFile($file);
        if(empty($data))
            return true;
        return false;
    }

}