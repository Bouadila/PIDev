<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Employeur;
use App\Form\EmployeurType;
use App\Repository\EmployeurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\FormTypeInterface;

class EspaceEmployeurController extends AbstractController
{
    /**
     * @Route("espace/employeur", name="espace_employeur")
     */
    public function index(): Response
    {
        return $this->render('espace_employeur/index.html.twig', [
            'controller_name' => 'EspaceEmployeurController',
        ]);
    }


    /**
     * @param  Request $request
     * @Route("/ajout/espace/employeur", name="ajout_espace_employeur")
     */
    public function Add(Request $request,EmployeurRepository $repository): Response
    {
        $employeur = new Employeur();
        $form =$this->createForm(EmployeurType::class,$employeur);
        $form->handleRequest($request);
        $employeurCH = $repository->findOneBy(['email' => $employeur->getEmail()]);
        if($employeurCH!=null){
            echo($employeurCH->getEmail());
        }elseif ($employeurCH==null){
            if($form->isSubmitted() ) {
 // && $form->isValid()

                $session= new Session();
                $session->set('email',$employeur->getEmail());
                $session->set('id',$employeur->getId());
                $employeur->setEtat('0');
                //get the entity manager that exists in doctrine( entity manager and repository)
                $em=$this->getDoctrine()->getManager();
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $em->persist($employeur);
                // actually executes the queries
                $em->flush();
                // return to the affiche
                return $this->redirectToRoute('aff_espace_employeur');
            }
        }

        return $this->render('espace_employeur/ajout_espace_employeur.html.twig', [
            'controller_name' => 'EspaceEmployeurController',
            'form'=>$form->createView(),
        ]);

    }


    /**
     * @Route("/aff/espace/employeur", name="aff_espace_employeur")
     */

    public function Read(EmployeurRepository $repository)
    {
        //Creer un objet Doctrine
        $em=$this->getDoctrine();
//        $candidat=$em->getRepository(Candidat::class)->findAll();
        $employeur = $repository->findOneBy(['email' => $this->get('session')->get('email')]);
        if($employeur->getEtat()=='1'){
            echo("compte desactive");
        }else {
            echo($this->get('session')->get('id'));
            echo($this->get('session')->get('email'));}
        return $this->render('espace_employeur/aff_espace_employeur.html.twig',
            ['employeur' => $employeur,

            ]);

    }

    /**
     * @Route("/Supp/espace/employeur", name="Supp_espace_employeur")
     */
    public function delete(Request $request, EmployeurRepository $repository): Response
    {
        $employeur = $repository->findOneBy(['email' => $this->get('session')->get('email') ]);
//        dd($candidat);
        $employeur->setEtat('1');
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute('home');

        return $this->render('espace_employeur/Supp_espace_employeur.html.twig', array(
                'employeur' => $employeur,)
        );
    }

    /**
     * @Route("/Modif/espace/employeur", name="Modif_espace_employeur")
     */
    public function Update(Request $request, EmployeurRepository $repository)
    {
        $employeur = $repository->findOneBy(['email' => $this->get('session')->get('email') ]);
        $form=$this->createForm(EmployeurType::class,$employeur);
//        $form->add('Modifier candidat',SubmitType::class);
        $form->handleRequest($request);

            if($form->isSubmitted()  )        {
//                && $form->isValid()
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("aff_espace_employeur");
        }
        return $this->render('espace_employeur/Modif_espace_employeur.html.twig',array(
                'form'=>$form->createView() ,
            )
        );
    }


    /**
     * @Route("/affback/espace/employeur", name="affback_espace_employeur")
     */
    public function ReadB()
    {
        //Creer un objet Doctrine
        $em=$this->getDoctrine();
        $employeur=$em->getRepository(Employeur::class)->findAll();
        return $this->render('espace_employeur/affback_espace_employeur.html.twig',
            ['employeur'=> $employeur ,
            ]);
    }
}
