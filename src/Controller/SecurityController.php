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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator, ValidatorInterface $validator): Response {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');
        
        //S'il est connecté, on le redirige
        $user = $this->getUser();
        if($user) {
            return $this->redirectToRoute('show');
        }
        
        $title = 'Inscription';
        $user = new User();
        $repository = $this->getDoctrine()->getRepository(Role::class);
        $roleMember = $repository->findOneBy(['role'=>'member']);
        $user->addRole($roleMember);
        
        $errors = [];
        $form = $this->createForm(UserType::class,$user);
        //$form->remove('roles');
        $form->remove('password');
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            //Association des champs de formulaire avec l'entité (patch)
            $user = $form->getData();
            $user->setPassword($form->get('plainPassword')->getData());

            //Validation par rapport aux contraintes de l'entité
            $errors = $validator->validate($user);

            if(count($errors)==0) {
                //Hashage du mot de passe
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                // do anything else you need here, like send an email

                return $guardHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main' // firewall name in security.yaml
                );
            }
        }
        
        return $this->render('security/signin.html.twig',[
            'title' => $title,
            'formRegister' => $form->createView(),
            'errors' => $errors,
        ]);
    }
}
