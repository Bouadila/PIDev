<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\Rendezvous;
use App\Entity\User;
use App\Form\RendezvousType;
use App\Repository\RendezvousRepository;
use App\Repository\UserRepository;
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
     * @Route("/new/{id}", name="rendezvous_new", methods={"GET","POST"})
     */
    public function new(Request $request , \Swift_Mailer $mailer,$id,UserRepository $repository): Response
    {
        $user = new User();
        $user = $repository->findOneBy(['email' => $this->get('session')->get('_security.last_username')]);
        if ($user== null){
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }elseif ($user->getRoles()[0]=="Employeur"){
        $rendezvous = new Rendezvous();
        $form = $this->createForm(RendezvousType::class, $rendezvous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $candidature = $entityManager->getRepository(Candidature::class)->find($id);
            $rendezvous->setCandidature($candidature);
            $rendezvous->setAllDay(false);
            $rendezvous->setBackgroundColor("#ff0000");
            $rendezvous->setBorderColor("#000000");
            $rendezvous->setTextColor("#fcfcfc");
            $rendezvous->setTitre($candidature->getCandidat()->getName());
            //dd($candidature , $rendezvou);
            $message = (new \Swift_Message('confirmation rendez vous entretien d\'embauche'))
                ->setFrom($user->getEmail())
                ->setTo($rendezvous->getCandidature()->getCandidat()->getEmail())
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'rendezvous/email.html.twig',
                        ['rendezvous' => $rendezvous]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            $entityManager->persist($rendezvous);
            $entityManager->flush();
            return $this->redirectToRoute('rendezvous_index');
        }}
        else{dd("vous ne pouvez pas ajouter  des rendezvous ");}
        return $this->render('rendezvous/new.html.twig', [
            'rendezvou' => $rendezvous,
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
    public function edit(Request $request, Rendezvous $rendezvous , \Swift_Mailer $mailer,UserRepository $repository): Response
    {
        $user = new User();
        $user = $repository->findOneBy(['email' => $this->get('session')->get('_security.last_username')]);
        if ($user== null){
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }elseif ($user->getRoles()[0]=="Employeur"){
            $form = $this->createForm(RendezvousType::class, $rendezvous);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                //dd($rendezvous->getCandidature()->getCandidat());
                $message = (new \Swift_Message('confirmation rendez vous entretien d\'embauche'))
                    ->setFrom($user->getEmail())
                    ->setTo($rendezvous->getCandidature()->getCandidat()->getEmail())
                    ->setBody(
                        $this->renderView(
                        // templates/emails/registration.html.twig
                            'rendezvous/email.html.twig',
                            ['rendezvous' => $rendezvous]
                        ),
                        'text/html'
                    );
                $mailer->send($message);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('rendezvous_index');
            }

            return $this->render('rendezvous/edit.html.twig', [
                'rendezvou' => $rendezvous,
                'form' => $form->createView(),
            ]);
        }else{
            dd("vous ne pouvez pas modifir  des rendezvous ");
        }

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
