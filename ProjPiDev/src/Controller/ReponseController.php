<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\ReponseList;
use App\Form\ReponseType;
use App\Form\ReponseListType;

use App\Repository\ReponseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reponse")
 */
class ReponseController extends AbstractController
{
    /**
     * @Route("/", name="reponse_index", methods={"GET"})
     */
    public function index(ReponseRepository $reponseRepository): Response
    {
        return $this->render('reponse/index.html.twig', [
            'reponses' => $reponseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reponse_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reponseList = new ReponseList();
        $question = $this->getDoctrine()->getRepository(Question::class)->find($request->query->get("ques_id"));

        for ($x = 0; $x < $question->getNombRep(); $x++){
            $reponse = new Reponse();
            $reponse->setIdQues($question);
            $reponseList->addReponse($reponse);
        }

        $form = $this->createForm(ReponseListType::class, $reponseList);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            foreach($reponseList->getReponses() as $rep)
                $entityManager->persist($rep);
            $entityManager->flush();

            return $this->redirectToRoute('question_new', ['id_quiz' => $question->getId()]);
        }

        return $this->render('reponse/new.html.twig', [
            'reponse' => $reponseList,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/select", name="select_reponse", methods={"GET"})
     */
    public function select(Request $request): Response
    {
        $question = $this->getDoctrine()->getRepository(Question::class)->find($request->query->get("ques_id"));
        $reponses = $this->getDoctrine()->getRepository(Reponse::class)->findBy(['id_ques' => $question]);

        $list=array();

        foreach($reponses as $rep)
            $list[ $rep->getContenuRep() ] = $rep->getId();

        $form = $this->createFormBuilder($reponses)->add(
            'reponses',CollectionType::class,
            [
                'entry_type' => CheckboxType::class,
            ])->add('', ChoiceType::class,['choices'  => $list]
        )->getForm();

        return $this->render('reponse/new.html.twig', [
            'reponse' => $reponses,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="reponse_show", methods={"GET"})
     */
    public function show(Reponse $reponse): Response
    {
        return $this->render('reponse/show.html.twig', [
            'reponse' => $reponse,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reponse_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reponse $reponse): Response
    {
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reponse_index');
        }

        return $this->render('reponse/edit.html.twig', [
            'reponse' => $reponse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reponse_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reponse $reponse): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reponse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reponse_index');
    }
}
