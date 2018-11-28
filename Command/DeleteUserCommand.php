<?php
namespace Kodmit\UserBundle\Command;

use Kodmit\UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteUserCommand extends Command
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
            ->setName('kod:user:delete')
            ->setDescription('Delete the specified user.')
            ->setHelp('This command allow you to delete an user.')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
            ))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '==============================',
            '        Delete an User        ',
            '==============================',
            '',
        ]);

        $username = $input->getArgument('username');

        if(!$user = $this->objectManager->getRepository(User::class)->findOneBy(["username" => $username]))
            throw new \Exception('User not found.');

        $this->objectManager->remove($user);
        $this->objectManager->flush();

        $output->writeln(sprintf("<comment>User %s deleted.</comment> \n", $username));

    }

}