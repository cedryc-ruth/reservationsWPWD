<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Show;
use App\Entity\Reservation;
use App\Form\ReservationType;

class ShowController extends AbstractController
{
    /**
     * @Route("/show", name="show")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Show::class);
        $shows = $repository->findAll();
        
        return $this->render('show/index.html.twig', [
            'shows' => $shows,
            'resource' => 'spectacles',
        ]);
    }
    
    /**
     * @Route("/show/{id}", name="show_show")
     */
    public function show($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Show::class);
        $show = $repository->find($id);
        $notification = "";
        $collaborateurs = [];
        
        foreach($show->getArtistTypes() as $at) {
            $collaborateurs[$at->getType()->getType()][] = $at->getArtist();
        }
        
        //Gestion de la réservation d'une représentation
        $reservation = new Reservation();
        
        $form = $this->createForm(ReservationType::class,$reservation);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           //Associer l'utilisateur en cours à la réservation
           $reservation->setUser($this->getUser());
           
           //Redirection vers Reservation.pay
           //$this->redirectToRoute('reservation_pay',['reservation'=>$reservation]);
           return $this->render('reservation/pay.html.twig', [
            'reservation' => $reservation,
        ]);
        }
        
        return $this->render('show/show.html.twig', [
            'show' => $show,
            'collaborateurs' => $collaborateurs,
            'formReservation' => $form->createView(),
            'notification' => $notification,
        ]);
    }
}
