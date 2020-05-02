<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Representation;

class RepresentationController extends AbstractController
{
    /**
     * @Route("/representation", name="representation")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Representation::class);
        $representations = $repository->findAll();
        
        return $this->render('representation/index.html.twig', [
            'representations' => $representations,
            'resource' => 'représentations',
        ]);
    }
    
    /**
     * @Route("/representation/{id}", name="representation_show")
     */
    public function show($id)
    {
        $repository = $this->getDoctrine()->getRepository(Representation::class);
        $representation = $repository->find($id);

        return $this->render('representation/show.html.twig', [
            'representation' => $representation,
        ]);
    }

}
