<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiRendezvousController extends AbstractController
{
    /**
     * @Route("/api/rendezvous", name="api_rendezvous")
     */
    public function index(): Response
    {
        return $this->render('api_rendezvous/index.html.twig', [
            'controller_name' => 'ApiRendezvousController',
        ]);
    }
}
