<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offer;
use App\Repository\OfferRepository;

/**
     * @Route("/offer")
     */
class OfferController extends AbstractController
{
    /**
     * @Route("/", name="offer_index", methods={"GET"})
     */
    public function index(OfferRepository $offerRepository): Response
    {
        return $this->render('offer/index.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);

    }

    /**
     * @Route("/back", name="offer_back", methods={"GET"})
     */
    public function index_back(OfferRepository $offerRepository): Response
    {
        return $this->render('offer/offer_back.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);

    }

}
