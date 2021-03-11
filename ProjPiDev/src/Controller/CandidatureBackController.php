<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CandidatureRepository;
use App\Entity\Candidature;
use App\Form\CandidatureType;
use Doctrine\Migrations\Query\Query;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/candidatureback")
 */
class CandidatureBackController extends AbstractController
{
    /**
     * @Route("/", name="candidatureback_index", methods={"GET"})
     */
    public function index(CandidatureRepository $candidatureRepository): Response
    {
        return $this->render('candidature_back/index.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
        ]);
     
    }

    /**
     * @Route("/new", name="candidatureback_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $candidature = new Candidature();
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

                $candidature->setDateCandidature(new \DateTime('now'));
        
        $userId = $this->getUser()->getId();
        $candidature->setIdCandidat($userId);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidature);
            $entityManager->flush();

            return $this->redirectToRoute('candidatureback_index');
        }

        return $this->render('candidature_back/new.html.twig', [
            'candidature' => $candidature,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="candidatureback_show", methods={"GET"})
     */
    public function show(Candidature $candidature): Response
    {
        return $this->render('candidature_back/show.html.twig', [
            'candidature' => $candidature,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="candidatureback_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Candidature $candidature): Response
    {
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('candidatureback_index');
        }

        return $this->render('candidature_back/edit.html.twig', [
            'candidature' => $candidature,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="candidatureback_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Candidature $candidature): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidature->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($candidature);
            $entityManager->flush();
        }

        return $this->redirectToRoute('candidatureback_index');
    }

    /**
     * @Route("/searchCandidaturex ", name="searchCandidaturex")
     */
    public function searchCandidaturex(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Candidature::class);
        $requestString=$request->get('searchValue');
        $$candidatures = $repository->findCandidatureById($requestString);
        $jsonContent = $Normalizer->normalize($candidatures, 'json',['groups'=>'candidatures']);
        $retour=json_encode($jsonContent);
        return new Response($retour);
      
    }


}