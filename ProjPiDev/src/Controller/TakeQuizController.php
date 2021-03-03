<?php

namespace App\Controller;

use App\Entity\ListReponsesCondidat;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Entity\Reponse;
use App\Entity\ReponseCondidat;
use App\Entity\ReponseList;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TakeQuizController extends AbstractController
{
    /**
     * @Route("/take/quiz", name="take_quiz")
     */
    public function index(): Response
    {
        return $this->render('take_quiz/index.html.twig', [
            'controller_name' => 'TakeQuizController',
        ]);
    }


    /**
     * @Route("/take/{id}", name="quiz_take", methods={"GET", "POST"})
     */
    public function take(Request $request, Quiz $quiz): Response
    {
        $reponseList = new ListReponsesCondidat();
        $reponseList->setQuiz($quiz);
        $questions = $this->getDoctrine()->getRepository(Question::class)->findBy(["quiz_id" => $quiz->getId()]);
        $formBuilder = $this->createFormBuilder($questions);
        $i = 0;
        foreach($questions as $question){
            $i++;
            $formBuilder->add("Question".$i, TextType::class, [ 'data' => $question->getContenuQues(),'label' =>' Question '.$i, 'disabled' => true]);
            $list= [];
            $reponses = $this->getDoctrine()->getRepository(Reponse::class)->findBy(["id_ques" => $question->getId()]);
            foreach( $reponses as $reponse){
                $question->addReponse($reponse);
                $list[$reponse->getContenuRep()] = $reponse->getId();
            }
            $formBuilder->add('reponses'.$i, ChoiceType::class, ['choices' => $list,'label' =>'  ', 'multiple'=>false, 'expanded' => true]);
            $quiz->addQuestion($question);

        }
        $form = $formBuilder->getForm();
        $form->handleRequest($request);
        $reponseCondidat = new ReponseCondidat();
        if ($form->isSubmitted() && $form->isValid()) {
            $i =0 ;

            $list = [];
            foreach($form->getData() as $data){

                if($data instanceof Question){
                    $reponseCondidat = new ReponseCondidat();
                    $reponseCondidat->setQuestion($data);
                    array_push($list,$reponseCondidat);

                }
                else {
                    $reponse = $this->getDoctrine()->getRepository(Reponse::class)->find($data);
                    foreach($list as $rep){
                        if($rep->getReponse() == null){
                            $rep->setReponse($reponse);
                            $rep->setListReponsesCondidat($reponseList);
                            $reponseList->addReponse($rep);
                            break;
                        }
                    }

                }
            }
            $em= $this->getDoctrine()->getManager();
            foreach($list as $rep){
                $em->persist($rep);
                if($rep->getReponse()->getId() == $rep->getQuestion()->getRepJust()->getId())
                    $i++;
            }
            $em->persist($reponseList);
            $em->flush();
            echo "<script> alert(".$i.") </script>";

        }

        return $this->render('quiz/takeQuiz.html.twig', [
            'form' => $form->createView(),
        ]);
//        return $this->render('quiz/takeQuiz.html.twig', [
//            'quiz' => $quiz,
//        ]);
    }

}
