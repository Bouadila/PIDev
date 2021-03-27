<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OfferRepository;
use App\Entity\Offer;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/home_candidat", name="home_candidat", methods={"GET"})
     */
    public function indexCandidat(OfferRepository $offerRepository): Response
    {
        return $this->render('home/home_candidat.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);
    }

}
