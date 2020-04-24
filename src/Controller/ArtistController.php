<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Artist;

class ArtistController extends AbstractController
{
    /**
     * @Route("/artist", name="artist")
     */
    public function index()
    {
        $titre = 'Liste des artistes';
        
        $repository = $this->getDoctrine()->getRepository(Artist::class);
        $artists = $repository->findAll();
        
        return $this->render('artist/index.html.twig', [
            'titre' => $titre,
            'artists' => $artists,
        ]);
    }
    
    /**
     * 
     * @Route("/artist/{id}", name="artist_show")
     * @param type $id
     */
    public function show(Artist $artist) {
        $titre = 'Fiche artiste';
        
        return $this->render('artist/show.html.twig',[
            'titre' => $titre,
            'artist' => $artist,
        ]);
    }
}
