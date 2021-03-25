<?php

namespace App\Controller;

use App\Entity\Rendezvous;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
    /**
     * @Route("/api/{id}/edit", name="api_event_edit", methods={"PUT"})
     */
    public function majEvent(?Rendezvous $rendezvous, Request $request)
    {
        // On récupère les données
        $donnees = json_decode($request->getContent());
        if(
            isset($donnees->titre) && !empty($donnees->titre) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->backgroundColor) && !empty($donnees->backgroundColor) &&
            isset($donnees->borderColor) && !empty($donnees->borderColor) &&
            isset($donnees->textColor) && !empty($donnees->textColor)
        ){
            // Les données sont complètes
            // On initialise un code
            $code = 200;

            // On vérifie si l'id existe
            if(!$rendezvous){
                // On instancie un rendez-vous
                $rendezvous = new Rendezvous();

                // On change le code
                $code = 201;
            }

            // On hydrate l'objet avec les données
            $rendezvous->setTitre($donnees->titre);
            $rendezvous->setDescription($donnees->description);
            $rendezvous->setStart(new DateTime($donnees->start));
            if($donnees->allDay){
                $rendezvous->setEnd(new DateTime($donnees->start));
            }else{
                $rendezvous->setEnd(new DateTime($donnees->end));
            }
            $rendezvous->setAllDay($donnees->allDay);
            $rendezvous->setBackgroundColor($donnees->backgroundColor);
            $rendezvous->setBorderColor($donnees->borderColor);
            $rendezvous->setTextColor($donnees->textColor);
            $rendezvous->setCandidature($rendezvous->getCandidature());

            $em = $this->getDoctrine()->getManager();
            $em->persist($rendezvous);
            $em->flush();

            // On retourne le code
            return new Response('Ok', $code);
        }else{
            // Les données sont incomplètes
            return new Response('Données incomplètes', 404);
        }
    }
}
