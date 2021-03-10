<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/home_candidat", name="home_candidat")
     */
    public function indexCandidat(): Response
    {
        return $this->render('home/home_candidat.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
