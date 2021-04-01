<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Commentaire;
use App\Form\AnnonceType;
use App\Form\CommentaireType;
use App\Repository\AnnonceRepository;
use App\Repository\CommentaireRepository;
use ContainerBRQgFOK\PaginatorInterface_82dac15;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce", name="annonce")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request,PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getRepository(Annonce::class);
        $list = $em->findAll();
        $result = $paginator->paginate(
            $list,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('annonce/liste_annonce.html.twig', [
            'controller_name' => 'AnnonceController',
            'list'=>$result,
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
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function Delete ($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaire = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($commentaire);
        $em->flush();
        return $this->redirectToRoute('afficheAnnonce',array('id'=>$commentaire->getAnnonce()->getId()));
    }
}
