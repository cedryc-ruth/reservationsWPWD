<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Component\Form\Forms;
use App\Entity\User;
use App\Entity\Role;
use App\Form\UserType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    
    /**
     * @Route("/signin", name="app_signin")
     */
    public function register(){
        $title = 'Inscription';
        $user = new User();
        $roleAdmin = new Role();
        $roleAdmin->setRole('admin');
        $user->addRole($roleAdmin);
        
        $form = $this->createForm(UserType::class,$user);
        
        return $this->render('security/signin.html.twig',[
            'title' => $title,
            'formRegister' => $form->createView()
        ]);
    }
}
