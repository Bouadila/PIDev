<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeEmploiController extends AbstractController
{
    /**
     * @Route("/Ajout/demande/emploi", name="Ajout_demande_emploi")
     */
    public function Ajout(): Response
    {
        return $this->render('demande_emploi/Ajout_demande_emploi.html.twig', [
            'controller_name' => 'DemandeEmploiController',
        ]);
    }

    /**
     * @Route("/list/demande/emploi", name="list_demande_emploi")
     */
    public function listeD(): Response
    {
        return $this->render('demande_emploi/liste_demande_emploi.html.twig', [
            'controller_name' => 'DemandeEmploiController',
        ]);
    }

    /**
     * @Route("/list/demande/back", name="list_demande_back")
     */
    public function listeDB(): Response
    {
        return $this->render('demande_emploi/liste_demande_back.html.twig', [
            'controller_name' => 'DemandeEmploiController',
        ]);
    }

    /**
     * @Route("/Supp/demande/emploi", name="Supp_demande_emploi")
     */
    public function listeSu(): Response
    {
        return $this->render('demande_emploi/Supp_demande_emploi.html.twig', [
            'controller_name' => 'DemandeEmploiController',
        ]);
    }

    /**
     * @Route("/Modif/demande/emploi", name="Modif_demande_emploi")
     */
    public function listeModif(): Response
    {
        return $this->render('demande_emploi/Modif_demande_emploi.html.twig', [
            'controller_name' => 'DemandeEmploiController',
        ]);
    }

}



