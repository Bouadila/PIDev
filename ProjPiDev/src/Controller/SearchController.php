<?php

namespace App\Controller;

use App\Entity\Candidature;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search_index")
     */
    public function search(Request $request): Response
    {
    $query = $request->query->get('query');
    $orderBy = $request->query->get('order');
    
    $result = $this->getDoctrine()->getRepository(Candidature::class)
        ->search($query, $orderBy);

    
    return $this->render('search/search.html.twig', [
        'results' => $result,
        'query' => $query,
        'order' => $orderBy,
      ]);
    }

    /**
     * @Route("/searchback")
     */
    public function searchback(Request $request): Response
    {
    $query = $request->query->get('query');
    $orderBy = $request->query->get('order');

    $result = $this->getDoctrine()->getRepository(Candidature::class)
        ->search($query, $orderBy);

    
    return $this->render('search/searchback.html.twig', [
        'results' => $result,
        'query' => $query,
        'order' => $orderBy
      ]);
    }
}
