<?php

namespace Kodmit\UserBundle\Controller;

use Kodmit\UserBundle\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {

    /**
     * @Route("/profile", name="kodmit_userbundle_profile", methods={"GET"})
     * @return Response
     */
    public function profile(){
        return $this->render('@KodmitUserBundle/profile.html.twig', ['user' => $this->getUser()]);
    }

    /**
     * @Route("/profile/edit", name="kodmit_userbundle_profile_edit", methods={"GET","POST"})
     * @return Response
     */
    public function editProfile(Request $request){

        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Profile updated");
            return $this->redirectToRoute("kodmit_userbundle_profile_edit");
        }
        return $this->render('@KodmitUserBundle/edit_profile.html.twig', ['form' => $form->createView()]);
    }
}