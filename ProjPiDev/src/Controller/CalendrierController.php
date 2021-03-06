<?php

namespace App\Controller;

use App\Repository\RendezvousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendrierController extends AbstractController
{
    /**
     * @Route("/calendrier", name="calendrier")
     */
    public function index(RendezvousRepository $rendezvous): Response
    {
        $events = $rendezvous->findAll();
        $rdvs = [];
        $rdvs[] = [];
            foreach($events as $event){
                $rdvs[] = [
                    'id' => $event->getId(),
                    'start' => $event->getStart()->format('Y-m-d H:i:s'),
                    'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                    'title' => $event->getTitre(),
                    'description' => $event->getDescription(),
                    'backgroundColor' => $event->getBackgroundColor(),
                    'borderColor' => $event->getBorderColor(),
                    'textColor' => $event->getTextColor(),
                    'allDay' => $event->getAllDay(),
                ];
            }

        $data = json_encode($rdvs);
            //dd($data);
        return $this->render('calendrier/index.html.twig', compact('data'));
    }
}
