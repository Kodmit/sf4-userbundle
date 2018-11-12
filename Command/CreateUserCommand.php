<?php
namespace App\Kodmit\UserBundle\Command;

use App\Kodmit\UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
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
            ->setName('kodmit:userbundle:create-user')
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::OPTIONAL, 'The username'),
                new InputArgument('email', InputArgument::OPTIONAL, 'The email'),
                new InputArgument('password', InputArgument::OPTIONAL, 'The password'),
            ))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '==============================',
            'Kodmit UserBundle User Creator',
            '==============================',
            '',
        ]);

        $helper = $this->getHelper('question');

        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $email = $input->getArgument('email');

        if(!$username){
            $question = new Question("Please enter the username : \n");
            $question->setValidator(function ($username) {
                if (empty($username)) {
                    throw new \Exception('Username can not be empty');
                }
                return $username;
            });
            $username = $helper->ask($input, $output, $question);

            $question = new Question("Please enter the email : \n");
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email can not be empty');
                }
                return $email;
            });
            $email = $helper->ask($input, $output, $question);

            $question = new Question("Please enter the password : \n");
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Password can not be empty');
                }
                return $password;
            });
            $password = $helper->ask($input, $output, $question);
        }

        $user = new User();
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setUsername($username);

        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        $output->writeln(sprintf("Created user <comment>%s</comment> \n", $username));

    }

}