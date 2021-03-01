<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspaceEmployeurController extends AbstractController
{
    /**
     * @Route("/espace/employeur", name="espace_employeur")
     */
    public function index(): Response
    {
        return $this->render('espace_employeur/index.html.twig', [
            'controller_name' => 'EspaceEmployeurController',
        ]);
    }

    /**
     * @Route("/ajout/espace/employeur", name="ajout_espace_employeur")
     */
    public function listA(): Response
    {
        return $this->render('espace_employeur/ajout_espace_employeur.html.twig', [
            'controller_name' => 'EspaceEmployeurController',
        ]);
    }


    /**
     * @Route("/aff/espace/employeur", name="aff_espace_employeur")
     */
    public function listeD(): Response
    {
        return $this->render('espace_employeur/aff_espace_employeur.html.twig', [
            'controller_name' => 'EspaceEmployeurController',
        ]);
    }

    /**
     * @Route("/Supp/espace/employeur", name="Supp_espace_employeur")
     */
    public function listeSu(): Response
    {
        return $this->render('espace_employeur/Supp_espace_employeur.html.twig', [
            'controller_name' => 'EspaceEmployeurController',
        ]);
    }

    /**
     * @Route("/Modif/espace/employeur", name="Modif_espace_employeur")
     */
    public function listeModif(): Response
    {
        return $this->render('espace_employeur/Modif_espace_employeur.html.twig', [
            'controller_name' => 'EspaceEmployeurController',
        ]);
    }

    /**
     * @Route("/affback/espace/employeur", name="affback_espace_employeur")
     */
    public function listeAB(): Response
    {
        return $this->render('espace_employeur/affback_espace_employeur.html.twig', [
            'controller_name' => 'EspaceEmployeurController',
        ]);
    }

}
