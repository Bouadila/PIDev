<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation", name="reclamation")
     */
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }

    /**
     * @Route("/reclamation/ajout", name="ajoutReclamation")
     */
    public function Ajout(Request $request, \Swift_Mailer $mailer): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class,$reclamation);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $newDate = new \DateTime('now');
            $reclamation->setEmail('test@email.tn');
            $reclamation->setDateReclamation($newDate->format('Y-m-d H:i:s'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            $message = (new \Swift_Message('Nouvelle Réclamation'))
                ->setFrom('pidevtestad@gmail.com')
                ->setTo('khalil.azizi@esprit.tn')
                ->setBody(
                    $this->renderView(
                        'email/emailReclamation.html.twig' , ["reclamation"=>$reclamation]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            return $this->redirectToRoute('afficheReclamation');
        }
        return $this->render('reclamation/ajoutReclamation.html.twig', [
            'controller_name' => 'ReclamationController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reclamation/affiche", name="afficheReclamation")
     */
    public function Affiche(): Response
    {
        $em = $this->getDoctrine()->getRepository(Reclamation::class);
        $list = $em->findAll();

        return $this->render('reclamation/afficheReclamation.html.twig', [
            'controller_name' => 'ReclamationController',
            'list'=>$list
        ]);
    }

    /**
     * @param Request $request
     * @Route ("/reclamation/modify/{id}" , name="modifyReclamation")
     */
    public function Modify (Request $request, $id , \Swift_Mailer $mailer)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation =$em->getRepository(Reclamation::class)->find($id);
        $form = $this->createForm(ReclamationType::class ,$reclamation);

        $form->handleRequest($request);
        if ($form->isSubmitted()){

            $em->flush();
            $message = (new \Swift_Message('Modification sur une Réclamation'))
                ->setFrom('pidevtestad@gmail.com')
                ->setTo('khalil.azizi@esprit.tn')
                ->setBody(
                    $this->renderView(
                        'email/emailReclamation.html.twig' , ["reclamation"=>$reclamation]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            return $this->redirectToRoute("afficheReclamation");
        }
        return $this->render('reclamation/modifyReclamation.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/reclamation/supprimer/{id}", name="deleteReclamation")
     */
    public function Supprimer($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("afficheReclamation");
    }


}
