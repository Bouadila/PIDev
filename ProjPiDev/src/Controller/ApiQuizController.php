<?php

namespace App\Controller;

use App\Entity\ListReponsesCondidat;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Entity\Reponse;
use App\Entity\ReponseCondidat;
use App\Repository\ContratRepository;
use App\Repository\OffreRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ApiQuizController extends AbstractController
{

    /**
     * @Route("/api/quiz", name="api_quiz", methods={"GET"})
     */
    public function index(NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Quiz::class);
        $quizs = $repository->findAll();
        $jsonContent = $Normalizer->normalize($quizs ,'json',['groups'=>'quiz:get']);
//        dd($jsonContent);
        return new Response(json_encode($jsonContent));

//        return $this->render('api_offre/index.html.twig', [
//            'controller_name' => 'ApiOffreController',
//        ]);
    }
    /**
     * @Route("/api/quiz/{id}", name="api_quiz_show", methods={"GET"})
     */
    public function show( Request $request , $id ,NormalizerInterface $Normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $quiz = $em->getRepository(Quiz::class)->find($id);
        $jsonContent = $Normalizer->normalize($quiz,'json',['groups'=>'quiz:get']);
        //dd($jsonContent);
        return new Response(json_encode($jsonContent));

    }



    /**
     * @Route("/api/quiz/new", name="api_quiz_add", methods={"POST"})
     */
    public function new( Request $request,NormalizerInterface $Normalizer, OffreRepository $offre)
    {

        $results = $offre->findBy(array(),array('id'=>'DESC'),1,0);
        $em = $this->getDoctrine()->getManager();
        $quiz = new Quiz();
        $quiz->setOffre($results);
        $quiz->setNomQuiz($request->get('nom_quiz'));
        $quiz->setNombQuestion($request->get('nb'));
        $em->persist($quiz);
        $em->flush();
        $jsonContent = $Normalizer->normalize($quiz,'json',['groups'=>'quiz:get']);
        //dd($jsonContent);
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/api/ques/new", name="api_ques_add", methods={"POST"})
     */
    public function newQues( Request $request,NormalizerInterface $Normalizer, QuizRepository  $quizrep)
    {
        $results = $quizrep->findBy(array(),array('id'=>'DESC'),1,0);
        $question = new Question();
        $question->setNombRep(intval($request->get('nb')));
        $question->setQuizId($results[0]);
        $question->setContenuQues($request->get('nom'));
        $question->setDuree(2);
        $reponse1 = new Reponse();
        $reponse1->setContenuRep($request->get('rep1'));
        $question->addReponse($reponse1);
        $em = $this->getDoctrine()->getManager();
        if($request->get("rep") == 1){
            $question->setRepJust($reponse1);
        }
        $em->persist($reponse1);
        $reponse2 = new Reponse();
        $reponse2->setContenuRep($request->get('rep2'));
        $question->addReponse($reponse2);
        $em->persist($reponse2);
        if($request->get("rep") == 2){
            $question->setRepJust($reponse2);
        }
        if($request->query->has('rep3')){
            $reponse3 = new Reponse();
            $reponse3->setContenuRep($request->get('rep3'));
            $question->addReponse($reponse3);
            $em->persist($reponse3);
            if($request->get("rep") == 3){
                $question->setRepJust($reponse3);
            }
    }
        if($request->query->has('rep4')){
            $reponse4 = new Reponse();
            $reponse4->setContenuRep($request->get('rep4'));
            $question->addReponse($reponse4);
            $em->persist($reponse4);
            if($request->get("rep") == 4){
                $question->setRepJust($reponse4);
            }

        }


        $em->persist($question);
        $em->flush();
        $jsonContent = $Normalizer->normalize($question,'json',['groups'=>'question:get']);
        //dd($jsonContent);
        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/api/take", name="api_take")
     */
    public function take( Request $request,NormalizerInterface $Normalizer, QuizRepository  $quizrep, QuestionRepository $quesrep, ReponseRepository $reprep){

        $em = $this->getDoctrine()->getManager();
        $reponseList = new ListReponsesCondidat();
        $quiz = new Quiz();
        $quiz = $quizrep->find($request->query->get("quiz"));
        $score = (int)$request->query->get("score");
        $reponseList->setQuiz($quiz);
        $reponseList->setScore($score);
        $question  = new Question();
        $reponse = new Reponse();
        for( $i  = (int)1; $i < 50 ; $i++){

            $str = "question".$i;
            if($request->query->has($str)){
                $reponseCondidat = new ReponseCondidat();
                $reponseCondidat->setListReponsesCondidat($reponseList);

                $question = $quesrep->find((int)$request->query->get($str));
                $reponseCondidat->setQuestion($question);
                $str = "reponse".$i;
                $reponse = $reprep->find((int)$request->query->get($str));
                $reponseCondidat->setReponse($reponse);
                $em->persist($reponseCondidat);

            }
            else
                break;
        }

        $em->persist($reponseList);
        $em->flush();
        return new Response();

    }
}
