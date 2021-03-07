<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatModifType;
use App\Form\CandidatType;
use App\Repository\CandidatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;



class EspaceCandidatController extends AbstractController
{
    /**
     * @Route("espace/candidat", name="espace_candidat" , methods={"GET"})
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
    public function Add(Request $request,CandidatRepository $repository): Response
    {
        $candidat = new Candidat();
        $form =$this->createForm(CandidatType::class,$candidat);
        $form->handleRequest($request);
        $candidatCH = $repository->findOneBy(['email' => $candidat->getEmail()]);
        if($candidatCH!=null){
            echo($candidatCH->getEmail());
        }elseif ($candidatCH==null){
            if($form->isSubmitted()   ) {
//                && $form->isValid()
                $session= new Session();
                $session->set('email',$candidat->getEmail());
                $session->set('id',$candidat->getId());
                $candidat->setEtat('0');
                $uploadedFile = $form['image']->getData();
                $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
                $uploadedFile->move($this->getParameter('upload_directory'),$filename);
                $candidat->setImg($filename);
                //get the entity manager that exists in doctrine( entity manager and repository)
                $em=$this->getDoctrine()->getManager();
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $em->persist($candidat);
                // actually executes the queries
                $em->flush();
                // return to the affiche
                return $this->redirectToRoute('aff_espace_candidat');
            }
        }

        return $this->render('espace_candidat/ajout_espace_candidat.html.twig', [
            'controller_name' => 'EspaceCandidatController',
            'form'=>$form->createView(),
        ]);
    }


    /**
     * @Route("/aff/espace/candidat", name="aff_espace_candidat")
     */

    public function Read(CandidatRepository $repository)
    {
        //Creer un objet Doctrine
        $em=$this->getDoctrine();
//        $candidat=$em->getRepository(Candidat::class)->findAll();
        $candidat = $repository->findOneBy(['email' => $this->get('session')->get('email')]);
        if($candidat->getEtat()=='1'){
            echo("compte desactive");
        }else {
            echo($this->get('session')->get('id'));
            echo($this->get('session')->get('email'));}
            return $this->render('espace_candidat/aff_espace_candidat.html.twig',
                ['candidat' => $candidat,

                ]);
    }

    /**
     * @Route("/Supp/espace/candidat", name="Supp_espace_candidat")
     */
    public function delete(Request $request, CandidatRepository $repository): Response
    {
        $candidat = $repository->findOneBy(['email' => $this->get('session')->get('email') ]);
//        dd($candidat);
        $candidat->setEtat('1');
        $em = $this->getDoctrine()->getManager();
            $em->flush();
        return $this->redirectToRoute('home');

            return $this->render('espace_candidat/Supp_espace_candidat.html.twig', array(
            'candidat' => $candidat,)
        );
    }

    /**
     * @param  Request $request
     * @Route("/Modif/espace/candidat", name="Modif_espace_candidat")
     */

    public function Update(Request $request, CandidatRepository $repository)
    {
        $candidat = $repository->findOneBy(['email' => $this->get('session')->get('email') ]);
        $form=$this->createForm(CandidatType::class,$candidat);
//        $form->add('Modifier candidat',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() )
        {
//            && $form->isValid()
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("aff_espace_candidat");
        }

        return $this->render('espace_candidat/Modif_espace_candidat.html.twig',array(
                'form'=>$form->createView() ,
            )

        );
    }

    /**
     * @Route("/affback/espace/candidat", name="affback_espace_candidat")
     */
    public function ReadB()
    {
        //Creer un objet Doctrine
        $em=$this->getDoctrine();
        $candidat=$em->getRepository(Candidat::class)->findAll();
        return $this->render('espace_candidat/affback_espace_candidat.html.twig',
            ['candidat'=> $candidat ,

            ]);
    }

}