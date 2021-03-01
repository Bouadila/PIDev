<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeEmploiController extends AbstractController
{
    /**
     * @Route("/Ajout/demande/emploi", name="Ajout_demande_emploi" , methods={"GET","POST"})
     */
    public function Ajout(Request $request): Response
    {

        $demande=new demande();
        $form=$this->createForm(DemandeType::class,$demande);
        $form->add('Ajouter Demande',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
            return $this->redirectToRoute("list_demande_emploi");
        }

        return $this->render('demande_emploi/Ajout_demande_emploi.html.twig',array('formdemande'=>$form->createView()));

    }

    /**
     * @Route("/list/demande/emploi", name="list_demande_emploi" , methods={"GET"})
     */
    public function listeD(): Response
    {

        $demande=$this->getDoctrine()->getRepository(Demande::class);
        $demandes=$demande->findAll();
        return $this->render('demande_emploi/liste_demande_emploi.html.twig',['demandes'=>$demandes , ]);
    }

    /**
     * @Route("/list/demande/back", name="list_demande_back" , methods={"GET"})
     */
    public function listeDB(): Response
    {

        $demande=$this->getDoctrine()->getRepository(Demande::class);
        $demandes=$demande->findAll();
        return $this->render('demande_emploi/liste_demande_back.html.twig',['demandes'=>$demandes , ]);

    }

    /**
     * @Route("/Supp/demande/emploi/{id}", name="Supp_demande_emploi" , methods={"DELETE"})
     */
    public function listeSu(Request $request, Demande $demande): Response
    {
        if ($this->isCsrfTokenValid('delete' . $demande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demande);
            $entityManager->flush();
        }
        return $this->redirectToRoute("list_demande_emploi");
    }


        /**
     * @Route("/Modif/demande/emploi/{id}", name="Modif_demande_emploi" , methods={"GET","POST"})
     */
    public function listeModif(Request $request, $id): Response
    {

        $demande=$this->getDoctrine()->getRepository(Demande::class)->find($id);
        $form=$this->createForm(DemandeType::class,$demande);
        $form->add('Modifier Demande',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("list_demande_emploi");
        }

        return $this->render("demande_emploi/Modif_demande_emploi.html.twig",array('formdemande'=>$form->createView()));
    }

}



