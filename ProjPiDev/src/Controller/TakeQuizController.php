<?php

namespace App\Controller;

use App\Entity\ListReponsesCondidat;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Entity\Candidature;
use App\Entity\Reponse;
use App\Entity\ReponseCondidat;
use App\Entity\ReponseList;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
     * @Route("/quiz/take/{id}", name="take_quiz", methods={"GET", "POST"})
     */
    public function takeQuiz (Request $request, Quiz $quiz): Response{
        $em = $this->getDoctrine()->getManager();
        if($request->query->get("answer")){
            $reponseList = $this->getDoctrine()->getRepository(ListReponsesCondidat::class)->find($request->query->get("rl"));
        }
        else{
        $candidature = $this->getDoctrine()->getRepository(Candidature::class)->find($request->query->get("candidature"));
            $reponseList = new ListReponsesCondidat();
            $reponseList->setQuiz($quiz);
            // $reponseList->setScore($score);
            $reponseList->setCandidature($candidature);
            $em->persist($reponseList);
        }
        if(count($quiz->getQuestions()) < ((int) $request->query->get("answer"))+1) {
            $reponses = $reponseList->getReponses();
            $score = 0;
            foreach($reponses as $rep){
                
                if( $rep->getReponse() != null && $rep->getReponse()->getId() == $rep->getQuestion()->getRepJust()->getId() )
                    $score +=1;
               
            }
            $score = ($score * 100) / count($reponses);
            $reponseList->setScore($score);
            $em->flush();
            $user = $repository->findOneBy(['email' => $this->get('session')->get('_security.last_username')]);
            
            $message = (new \Swift_Message('Resultat de quiz'))
            ->setFrom('pidevtestad@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'email/showResult.html.twig', ['quiz' => $reponseList]
                ),
                'text/html'
            );
//            $mailer->send($message);
            return $this->redirectToRoute('quiz_result', ['id' => $reponseList->getId()]);

        }

        if($request->query->get("answer")) $i=$request->query->get("answer"); else $i = 0;


        $list =[];
            $question = $quiz->getQuestions()[$i];
        foreach( $question->getReponses() as $reponse){
            $question->addReponse($reponse);
            //add every reponse to the list
            $list[$reponse->getContenuRep()] = $reponse->getId();
        }

        $form = $this->createFormBuilder()
        ->add("Questions", TextType::class, [ 'data' => $question->getContenuQues(),'label' =>' Question '.$i, 'disabled' => true])->getForm();
        if(count($question->getReponses())>1) {
            $form->add('reponses', ChoiceType::class,
                [
                    'choices' => $list,
                    'label' => '  ',
                    'multiple' => false,
                    'expanded' => true,
                ]);
        }
        else {
            $form->add('reponses', TextareaType::class, [ 'attr' => ['readonly'=> true]]);
            $question->setRepJust($question->getReponses()[0]);
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $reponseCondidat = new ReponseCondidat();
            $reponseCondidat->setListReponsesCondidat($reponseList);
            $reponseCondidat->setQuestion($question);
            if($form->getData()['reponses'])
                if(count($question->getReponses())>1) {
                    $reponseCondidat->setReponse($this->getDoctrine()->getRepository(Reponse::class)->find($form->getData()['reponses']));
                }
            else{
                if(strcmp($form->getData()['reponses'],$question->getReponses()[0]) == 0){
                    $reponseCondidat->setReponse($question->getReponses()[0]);
                }
                else {
                    $rep = new Reponse();
                    $rep->setContenuRep($form->getData()['reponses']);
                    $em->persist($rep);
                    $reponseCondidat->setReponse($rep);
                }

            }
            $reponseList->addReponse($reponseCondidat);
            $em->persist($reponseCondidat);
            $em->flush();
            return $this->redirectToRoute('take_quiz', ["id" => $quiz->getId(),
                "quiz" => $quiz,
                "answer" => $i + 1,
                "rl"=> $reponseList->getId(),
                "question" => $question,
                "form" => $form->createView()
                ]);

        }


        return $this->render('quiz/takeQuiz.html.twig', [
            'quiz' => $quiz,
            "question" => $question,
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("/take/{id}", name="quiz_take", methods={"GET", "POST"})
     */
    public function take(Request $request, Quiz $quiz, \Swift_Mailer $mailer): Response
    {
        //create a new list of questions
        $reponseList = new ListReponsesCondidat();

        //set its quiz
        $reponseList->setQuiz($quiz);
        $questions = $this->getDoctrine()->getRepository(Question::class)->findBy(["quiz_id" => $quiz->getId()]);
        $formBuilder = $this->createFormBuilder($questions);
        $i = 0;

        foreach($questions as $question){
            $i++;
            //add every question in the quiz to the new form
            $formBuilder->add("Question".$i, TextType::class, [ 'data' => $question->getContenuQues(),'label' =>' Question '.$i, 'disabled' => true]);
            //list that will contains the reponses list  of a question
            $list= [];
            $reponses = $this->getDoctrine()->getRepository(Reponse::class)->findBy(["id_ques" => $question->getId()]);
            foreach( $reponses as $reponse){
                $question->addReponse($reponse);
                //add every reponse to the list
                $list[$reponse->getContenuRep()] = $reponse->getId();
            }
            // add the list of reponse to the form then do the same for the next question
            $formBuilder->add('reponses'.$i, ChoiceType::class,
                [
                    'choices' => $list,
                    'label' =>'  ',
                    'multiple'=>false,
                    'expanded' => true,
                    ]);
            $quiz->addQuestion($question);

        }
        $form = $formBuilder->getForm();
        $form->handleRequest($request);
        $reponseCondidat = new ReponseCondidat();
        if ($form->isSubmitted() && $form->isValid()) {
            $i =0 ;

            //list will countains our ReponseCondidat which contains question and a the condidat's answer
            $list = [];
            //loop on the form data
            foreach($form->getData() as $data){
                // check if its instance is question
                if($data instanceof Question){
                    //create new instance of reponseCondidat when the instance is client
                    $reponseCondidat = new ReponseCondidat();
                    $reponseCondidat->setListReponsesCondidat($reponseList);
                    //set its question to the data we got
                    $reponseCondidat->setQuestion($data);
                    //add this reponseCondidat to our list
                    array_push($list,$reponseCondidat);

                }
                // else if our data is not a question than its a reponse
                else {
                    if($data != null){
                        $reponse = $this->getDoctrine()->getRepository(Reponse::class)->find($data);
                        // loop our reponsesCondidat list
                        foreach($list as $rep){
                            //if our reponseCondidat's reponse is null than will affect to it this reponse
                            if($rep->getReponse() == null  && $reponse->getIdQues() == $rep->getQuestion()){
                                $rep->setReponse($reponse);
                                //than will add this reponseCondidat to our table which contains the list of reponseCondidat
                                $rep->setListReponsesCondidat($reponseList);
                                $reponseList->addReponse($rep);
                                break;
                            }
                        }
                    }

                }
            }
            $em= $this->getDoctrine()->getManager();
            foreach($list as $rep){
                //presist the reonsesCondidat one by one to our database
                $em->persist($rep);
                //calculate the number of correct answers
                if($rep->getReponse() != null && $rep->getReponse()->getId() == $rep->getQuestion()->getRepJust()->getId())
                    $i++;
            }
            $score = ($i * 100) / count($list);
            

//            persist the list of reponsesCondidat
            $em->persist($reponseList);
            $em->flush();
            //alert contains the condidat's result
//            echo "<script> alert(".$i.") </script>";
            $message = (new \Swift_Message('Resultat de quiz'))
                ->setFrom('Bou3dilafiras@gmail.com')
                ->setTo('firas.bouadila@esprit.tn')
                ->setBody(
                    $this->renderView(
                        'email/showResult.html.twig', ['quiz' => $reponseList]
                    ),
                    'text/html'
                );
//            $mailer->send($message);
            return $this->redirectToRoute('quiz_result', ['id' => $reponseList->getId()]);

        }

        return $this->render('quiz/takeQuiz.html.twig', [ "quiz" => $quiz,
            'form' => $form->createView(),
        ]);
//        return $this->render('quiz/takeQuiz.html.twig', [
//            'quiz' => $quiz,
//        ]);
    }

    /**
     * @Route("/showResult/{id}", name="quiz_result", methods={"GET"})
     */
    public function show(Request $request, ListReponsesCondidat $quiz): Response{

                return $this->render('quiz/showResult.html.twig', [
            'quiz' => $quiz,
        ]);

    }

}
