<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Role;

class RoleController extends AbstractController
{
    /**
     * @Route("/role", name="role")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Role::class);
        $roles = $repo->findAll();
        $titre = 'Liste des rôles';
        
        return $this->render('role/index.html.twig', [
            'roles' => $roles,
            'titre' => $titre,
        ]);
    }
    
    /**
     * @Route("/role/{id}", name="role_show")
     */
    public function show(Role $role)
    {
        $titre = 'Fiche rôle';
        
        return $this->render('role/show.html.twig', [
            'role' => $role,
            'titre' => $titre,
        ]);
    }
}
