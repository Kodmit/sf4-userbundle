<?php
namespace Kodmit\UserBundle\Command;

use Kodmit\UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetUserCommand extends Command
{

    private $objectManager;
    private $passwordEncoder;

    public function __construct(ObjectManager $objectManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();
        $this->objectManager = $objectManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function configure()
    {
        $this
            ->setName('kod:user:reset')
            ->setDescription('Reset the user password.')
            ->setHelp('This command allows you to reset the user password.')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
            ))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '==============================',
            '      Reset user password     ',
            '==============================',
            '',
        ]);

        $helper = $this->getHelper('question');

        $username = $input->getArgument('username');

        if(!$user = $this->objectManager->getRepository(User::class)->findOneBy(["username" => $username]))
            throw new \Exception('User not found.');

        $question = new Question("Please enter the new password : \n");
        $question->setValidator(function ($password) {
            if (empty($password)) {
                throw new \Exception('Password can not be empty');
            }
            return $password;
        });
        $password = $helper->ask($input, $output, $question);

        $user->setPlainPassword($password);

        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        $output->writeln(sprintf("<comment>Password changed for %s</comment> \n", $username));

    }

}