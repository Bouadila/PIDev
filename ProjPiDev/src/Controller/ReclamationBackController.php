<?php

namespace App\Controller;

use App\Entity\Commentaire;
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
    public function Show(Request $request): Response
    {
        $em = $this->getDoctrine()->getRepository(Reclamation::class);
        $list = $em->findAll();

        /*$paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $list,
            $request->query->getInt('page', 1),
            10
        );*/

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
    /**
     * @Route("/back/reclamation/approve/{id}", name="approve")
     */
    public function Approve ($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Reclamation::class);
        $etat = $repo->find($id);
        $etat->setStatus('Résolu');
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute('affiche_back_Reclamation',array('id'=>$etat->getId()));
    }
    /**
     * @Route("/back/reclamation/disapprove/{id}", name="disapprove")
     */
    public function Disapprove ($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Reclamation::class);
        $etat = $repo->find($id);
        $etat->setStatus('Non Résolu');
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute('affiche_back_Reclamation',array('id'=>$etat->getId()));
    }
}
