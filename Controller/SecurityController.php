<?php

namespace Kodmit\UserBundle\Controller;

use Kodmit\UserBundle\Entity\User;
use Kodmit\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends Controller
{

    private $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route("/login", name="kodmit_userbundle_login", methods={"GET","POST"})
     * @return Response
     */
    public function login(): Response
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->render('@KodmitUserBundle/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/register", name="kodmit_userbundle_register", methods={"GET","POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute('kodmit_userbundle_login');
        }

        return $this->render(
            '@KodmitUserBundle/register.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/change-password", name="kodmit_userbundle_change_password", methods={"GET","POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function changePassword(Request $request){

        $form = $this->createFormBuilder()
            ->add('oldPassword', PasswordType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'New password'),
                'second_options' => array('label' => 'Repeat new Password'),
            ))
            ->getForm()
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();
            $data = $form->getData();

            $passwordEncoder = $this->get("security.password_encoder");
            $password = $passwordEncoder->encodePassword($user, $data['plainPassword']);

            $user->setPassword($password);

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Password updated");
            return $this->redirectToRoute("kodmit_userbundle_change_password");
        }

        return $this->render(
            '@KodmitUserBundle/change_password.html.twig', [
                'form' => $form->createView()
            ]
        );

    }

}
