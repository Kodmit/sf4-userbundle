<?php
namespace Kodmit\UserBundle\Command;

use Kodmit\UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\MakerBundle\Util\YamlSourceManipulator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Yaml\Yaml;

class InitOverrideCommand extends Command
{

    private $objectManager;
    private $passwordEncoder;

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('kodmit:userbundle:override')
            ->setDescription('Create files in src folder to override the bundle.')
            ->setHelp('This command generate template and entities files in you src folder in order to override the bundle.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '',
            'Overriding files...',
            ''
        ]);

        $this->initTwig($output);

        if(!file_exists("templates/bundles"))
            mkdir("templates/bundles");

        if(!file_exists("templates/bundles/KodmitUserBundle"))
            mkdir("templates/bundles/KodmitUserBundle");

        copy("vendor/kodmit/userbundle/OverridingFiles/views/change_password.html.twig", "templates/bundles/KodmitUserBundle/change_password.html.twig");
        copy("vendor/kodmit/userbundle/OverridingFiles/views/edit_profile.html.twig", "templates/bundles/KodmitUserBundle/edit_profile.html.twig");
        copy("vendor/kodmit/userbundle/OverridingFiles/views/login.html.twig", "templates/bundles/KodmitUserBundle/login.html.twig");
        copy("vendor/kodmit/userbundle/OverridingFiles/views/profile.html.twig", "templates/bundles/KodmitUserBundle/profile.html.twig");
        copy("vendor/kodmit/userbundle/OverridingFiles/views/register.html.twig", "templates/bundles/KodmitUserBundle/register.html.twig");

        $output->writeln(sprintf("<comment>Overriding done.</comment> \n"));

    }

    private function initTwig($output){

        $yamlSource = 'config/packages/twig.yaml';
        $output->writeln("Updating twig.yaml file...");

        $data = Yaml::parseFile($yamlSource);

        if(!isset($data['twig']['paths']["%kernel.project_dir%/vendor/kodmit/userbundle/Resources/views"]))
            throw new \Exception('You need to update the twig.yaml first, see the doc.');

        unset($data['twig']['paths']["%kernel.project_dir%/vendor/kodmit/userbundle/Resources/views"]);
        array_unshift($data['twig']['paths'], $data['twig']['paths']["%kernel.project_dir%/templates/bundles/KodmitUserBundle"] = "KodmitUserBundle");
        array_push($data['twig']['paths'], $data['twig']['paths']["%kernel.project_dir%/vendor/kodmit/userbundle/Resources/views"] = "KodmitUserBundle");
        array_shift($data['twig']['paths']);
        array_pop($data['twig']['paths']);

        $content = Yaml::dump($data, 2);

        file_put_contents($yamlSource, $content);
        $output->writeln(sprintf("<comment>twig.yaml updated !</comment>"));

    }

}