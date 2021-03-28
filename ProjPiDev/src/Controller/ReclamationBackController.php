<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationBackController extends AbstractController
{
    /**
     * @Route("/back/reclamation", name="reclamation_back")
     */
    public function index(): Response
    {
        return $this->render('reclamation_back/index.html.twig', [
            'controller_name' => 'ReclamationBackController',
        ]);
    }

    /**
     * @Route("/back/reclamation/affiche", name="affiche_back_Reclamation")
     */
    public function Show(): Response
    {
        $em = $this->getDoctrine()->getRepository(Reclamation::class);
        $list = $em->findAll();

        return $this->render('reclamation_back/affiche_reclamation_back.html.twig', [
            'controller_name' => 'ReclamationController',
            'list'=>$list
        ]);
    }

    /**
     * @Route("/back/reclamation/delete/{id}", name="delete_back_reclamation")
     */
    public function Delete($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("affiche_back_Reclamation");
    }
}
