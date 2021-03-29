<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Commentaire;
use App\Form\AnnonceType;
use App\Form\CommentaireType;
use App\Repository\AnnonceRepository;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce", name="annonce")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getRepository(Annonce::class);
        $list = $em->findAll();
        return $this->render('annonce/liste_annonce.html.twig', [
            'controller_name' => 'AnnonceController',
            'list'=>$list,
        ]);
    }
    /**
     * @Route ("/annonce/affiche/{id}" , name="afficheAnnonce")
     */
    public function Affiche ( Request $request, $id, AnnonceRepository $annonceRepository, CommentaireRepository $commentaireRepository )
    {
        $annonce=$annonceRepository->find($id);
        $comments=$commentaireRepository->findBy(['annonce'=>$annonce]);

        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $newDate = new \DateTime('now');
            $commentaire->setNbrReac(0);
            $commentaire->setAnnonce($annonce);
            $commentaire->setTimeStamp($newDate->format('Y-m-d H:i:s'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('afficheAnnonce',array('id'=>$id));
        }

        return $this->render('annonce/affiche_annonce.html.twig',['annonce'=>$annonce,'formComm'=>$form->createView(),'comments'=>$comments]);
    }
    /**
     * @Route("/like/{id}", name="like")
     */
    public function LikeComm ($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaire = $repo->find($id);
        $commentaire->setNbrReac($commentaire->getNbrReac()+1);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute('afficheAnnonce',array('id'=>$commentaire->getAnnonce()->getId()));
    }
    /**
     * @Route("/dislike/{id}", name="dislike")
     */
    public function DislikeComm ($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaire = $repo->find($id);
        $commentaire->setNbrReac($commentaire->getNbrReac()-1);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute('afficheAnnonce',array('id'=>$commentaire->getAnnonce()->getId()));
    }
}
