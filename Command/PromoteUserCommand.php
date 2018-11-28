<?php
namespace Kodmit\UserBundle\Command;

use Kodmit\UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PromoteUserCommand extends Command
{

    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct();
        $this->objectManager = $objectManager;
    }

    protected function configure()
    {
        $this
            ->setName('kod:user:promote')
            ->setDescription('Promote the specified user.')
            ->setHelp('This command allow you to promote an user.')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputArgument('role', InputArgument::REQUIRED, 'The role'),
            ))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '==============================',
            '       Promote an User        ',
            '==============================',
            '',
        ]);

        $username = $input->getArgument('username');
        $role = $input->getArgument('role');

        if(!$user = $this->objectManager->getRepository(User::class)->findOneBy(["username" => $username]))
            throw new \Exception('User not found.');

        $roles = $user->getRoles();

        array_push($roles, $role);

        $user->setRoles($roles);

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        $output->writeln("<comment>User " . $username . " granted role " . $role . ".</comment> \n");

    }

}