<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Repository\CandidatRepository;


class EspaceCandidatController extends AbstractController
{
    /**
     * @Route("/espace/candidat", name="espace_candidat" , methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('espace_candidat/index.html.twig', [
            'controller_name' => 'EspaceCandidatController',
        ]);
    }



    /**
     *
     * @param  Request $request
     * @Route("/ajout/espace/candidat", name="ajout_espace_candidat")
     */
    public function Add(Request $request): Response
    {
        $candidat = new Candidat();
        $form =$this->createForm(CandidatType::class,$candidat);
        $form->handleRequest($request);
        if($form->isSubmitted() ){
            //get the entity manager that exists in doctrine( entity manager and repository)
            $em=$this->getDoctrine()->getManager();
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($candidat);
            // actually executes the queries
            $em->flush();
            // return to the affiche
            return $this->redirectToRoute('aff_espace_candidat');
        }
        return $this->render('espace_candidat/ajout_espace_candidat.html.twig', [
            'controller_name' => 'EspaceCandidatController',
            'form'=>$form->createView(),
        ]);

    }

    /**
     * @Route("/aff/espace/candidat", name="aff_espace_candidat")
     */
    public function listeD(): Response
    {
        return $this->render('espace_candidat/aff_espace_candidat.html.twig', [
            'controller_name' => 'EspaceCandidatController',
        ]);
    }

    /**
     * @Route("/Supp/espace/candidat", name="Supp_espace_candidat")
     */
    public function listeSu(): Response
    {
        return $this->render('espace_candidat/Supp_espace_candidat.html.twig', [
            'controller_name' => 'EspaceCandidatController',
        ]);
    }

    /**
     * @Route("/Modif/espace/candidat", name="Modif_espace_candidat")
     */
    public function listeModif(): Response
    {
        return $this->render('espace_candidat/Modif_espace_candidat.html.twig', [
            'controller_name' => 'EspaceCandidatController',
        ]);
    }


//    /**
//     * @Route("/{id}", name="candidat_show", methods={"GET"})
//     */
//    public function show(Candidat $candidat): Response
//    {
//        return $this->render('candidat/show.html.twig', [
//            'candidat' => $candidat,
//        ]);
//    }

//    /**
//     * @Route("/{id}/edit", name="candidat_edit", methods={"GET","POST"})
//     */
//    public function edit(Request $request, Candidat $candidat): Response
//    {
//        $form = $this->createForm(Candidat1Type::class, $candidat);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('candidat_index');
//        }
//
//        return $this->render('candidat/edit.html.twig', [
//            'candidat' => $candidat,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{id}", name="candidat_delete", methods={"DELETE"})
//     */
//    public function delete(Request $request, Candidat $candidat): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$candidat->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($candidat);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('candidat_index');
//    }
//}

    /**
     * @Route("/affback/espace/candidat", name="affback_espace_candidat")
     */
    public function listeAB(): Response
    {
        return $this->render('espace_candidat/affback_espace_candidat.html.twig', [
            'controller_name' => 'EspaceCandidatController',
        ]);
    }

}
