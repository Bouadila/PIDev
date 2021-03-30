<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceBackController extends AbstractController
{
    /**
     * @Route("/back/annonce/ajout", name="AnnonceAjout")
     */
    public function AnnonceAjout(Request $request): Response
    {
        $annonce= new Annonce();
        $form = $this->createForm(AnnonceType::class,$annonce);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $uploadedFile=$form['img']->getData();
            $filename=md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $annonce->setImg($filename);
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('annonce_back_affiche');
        }
        return $this->render('annonce_back/ajout_annonce.html.twig', [
            'controller_name' => 'AnnonceController',
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/back/annonce/affiche", name="annonce_back_affiche")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getRepository(Annonce::class);
        $list = $em->findAll();
        /*$paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $list,
            $request->query->getInt('page', 1),
            10
        );*/
        return $this->render('annonce_back/liste_annonce_back.html.twig', [
            'controller_name' => 'AnnonceController',
            'list'=>$list,
        ]);
    }

    /**
     * @param Request $request
     * @Route ("/back/annonce/modify/{id}" , name="modifyAnnonce")
     */
    public function Modify (Request $request, $id, AnnonceRepository $annonceRepository)
    {
        $annonce =$annonceRepository->find($id);
        $form = $this->createForm(AnnonceType::class ,$annonce);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("annonce_back_affiche");
        }
        return $this->render('annonce_back/modif_annonce_back.html.twig', ['form' => $form->createView(),'id'=>$id]);
    }

    /**
     * @param Request $request
     * @Route ("/back/annonce/delete/{id}" , name="DeleteAnnonce")
     */
    public function Delete (Request $request, $id, AnnonceRepository $annonceRepository)
    {
        $annonce =$annonceRepository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($annonce);
        $em->flush();
        return $this->redirectToRoute("annonce_back_affiche");
    }


}
