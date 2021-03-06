<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AnnonceBackController extends AbstractController
{
    /**
     * @Route("/back/annonce/ajout", name="AnnonceAjout")
     */
    public function AnnonceAjout(Request $request): Response
    {
        $annonce= new Annonce();
        $form = $this->createForm(AnnonceType::class,$annonce);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $uploadedFile=$form['img']->getData();
            $filename=md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $annonce->setImg($filename);
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('annonce_back_affiche');
        }
        return $this->render('annonce_back/ajout_annonce.html.twig', [
            'controller_name' => 'AnnonceController',
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/back/annonce/affiche", name="annonce_back_affiche")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getRepository(Annonce::class);
        $list = $em->findAll();
        /*$result = $paginator->paginate(
            $list,
            $request->query->getInt('page', 1),
            5
        );*/
        return $this->render('annonce_back/liste_annonce_back.html.twig', [
            'controller_name' => 'AnnonceController',
            'list'=>$list,
        ]);
    }

    /**
     * @param Request $request
     * @Route ("/back/annonce/modify/{id}" , name="modifyAnnonce")
     */
    public function Modify (Request $request, $id, AnnonceRepository $annonceRepository)
    {
        $annonce =$annonceRepository->find($id);
        $form = $this->createForm(AnnonceType::class ,$annonce);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("annonce_back_affiche");
        }
        return $this->render('annonce_back/modif_annonce_back.html.twig', ['form' => $form->createView(),'id'=>$id]);
    }

    /**
     * @param Request $request
     * @Route ("/back/annonce/delete/{id}" , name="DeleteAnnonce")
     */
    public function Delete (Request $request, $id, AnnonceRepository $annonceRepository)
    {
        $annonce =$annonceRepository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($annonce);
        $em->flush();
        return $this->redirectToRoute("annonce_back_affiche");
    }


    /**
     * @Route("/searchAnnonce ", name="searchAnnonce")
     */
    public function searchVideo(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Annonce::class);
        $requestString=$request->get('searchValue');
        $annonce = $repository->findAnnonceParTitre($requestString);
        $data=array();

        foreach ($annonce as $a)
        {
            array_push($data,array("id"=>$a->getId(),"nom"=>$a->getNom(),
               "img"=>$a->getImg(),"origine"=>$a->getOrigine()));
        }


        return new JsonResponse($data);
    }



}
