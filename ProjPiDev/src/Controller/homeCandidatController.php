<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class homeCandidatController extends AbstractController
{
    /**
     * @Route("/homeCandidat", name="home_candidat")
     */
    public function index(Request $request)
    {
        return $this->render('home/homeCandidat.html.twig', [
            'controller_name' => 'homeCandidatController',
        ]);
    }
}