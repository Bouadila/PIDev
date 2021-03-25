<?php

namespace App\Controller;

use App\Entity\Rendezvous;
use App\Form\RendezvousType;
use App\Repository\RendezvousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rendezvous")
 */
class RendezvousController extends AbstractController
{
    /**
     * @Route("/", name="rendezvous_index", methods={"GET"})
     */
    public function index(RendezvousRepository $rendezvousRepository): Response
    {
        //dd($rendezvousRepository->findAll());
        return $this->render('rendezvous/index.html.twig', [
            'rendezvouses' => $rendezvousRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rendezvous_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rendezvou = new Rendezvous();
        $form = $this->createForm(RendezvousType::class, $rendezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rendezvou);
            $entityManager->flush();

            return $this->redirectToRoute('rendezvous_index');
        }

        return $this->render('rendezvous/new.html.twig', [
            'rendezvou' => $rendezvou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rendezvous_show", methods={"GET"})
     */
    public function show(Rendezvous $rendezvou): Response
    {
        return $this->render('rendezvous/show.html.twig', [
            'rendezvou' => $rendezvou,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rendezvous_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rendezvous $rendezvou): Response
    {
        $form = $this->createForm(RendezvousType::class, $rendezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rendezvous_index');
        }

        return $this->render('rendezvous/edit.html.twig', [
            'rendezvou' => $rendezvou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rendezvous_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rendezvous $rendezvou): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezvou->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rendezvou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rendezvous_index');
    }
}
