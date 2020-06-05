<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Agent;
use App\Entity\Artist;
use App\Form\ArtistTransfertType;

class AgentController extends AbstractController
{
    /**
     * @Route("/agent", name="agent")
     */
    public function index()
    {
        $repository = $this->getdoctrine()->getRepository(Agent::class);
        $agents = $repository->findAll();
        
        return $this->render('agent/index.html.twig', [
            'title' => 'Liste des agents',
            'agents' => $agents,
        ]);
    }
    
    /**
     * @Route("/agent/{id}/transfert/{artistId}", name="agent_transfert")
     */
    public function transfert(Request $request, int $id, int $artistId): Response
    {
        //Autorisation: seul l'admin a accès (mettez en commentaire pour tester sans)
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $user = $this->getUser();
        
        if(!in_array('admin',$user->getRoles())) {
            throw new \Exception('Access denied for user without "admin" role.');
        }
        //----
        
        $repository = $this->getDoctrine()->getRepository(Artist::class);
        $artist = $repository->find($artistId);
        
        $form = $this->createForm(ArtistTransfertType::class,$artist);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           //Persister les modifications de l'artiste
           $this->getDoctrine()->getManager()->flush();
           
           //Redirection vers la fiche de l'artiste
           return $this->redirectToRoute('artist_show',['id'=>$artist->getId()]);
        }
        
        return $this->render('agent/transfert.html.twig', [
            'artist' => $artist,
            'formTransfert' => $form->createView(),
        ]);
    }
}
