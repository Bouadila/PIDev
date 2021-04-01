<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\Offre;
use App\Entity\User;
use App\Form\CompetenceType;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/offre")
 */
class OffreController extends AbstractController
{
    /**
     * @Route("/", name="offre_index", methods={"GET"})
     */
    public function index(OffreRepository $offreRepository,Request $request, PaginatorInterface $paginator,UserRepository $repository): Response
    {
        $user = new User();
        $user = $repository->findOneBy(['email' => $this->get('session')->get('_security.last_username')]);
        if ($user== null){
            $donnees =$offreRepository->findAll();
            $offres = $paginator->paginate(
                $donnees, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                4// Nombre de résultats par page
            );
            return $this->render('offre/jobs.html.twig', [
                'offres' => $offres,
            ]);
        }
        elseif($user->getRoles()[0]=="Employeur")
        {
        $donnees =$offreRepository->findAll();
        $offres = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4// Nombre de résultats par page
        );
        return $this->render('offre/index.html.twig', [
            'offres' => $offres,
        ]);
        }
        else{
            return $this->render('offre/jobs.html.twig', [
                'offres' => $offreRepository->findAll(),
            ]);
        }
    }
    /**
     * @Route("/new", name="offre_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserRepository $repository): Response
    {
        $offre = new Offre();
        $user = new User();
        $user = $repository->findOneBy(['email' => $this->get('session')->get('_security.last_username')]);
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $offre->setEntreprise($user);
            //dd($offre);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();

        
            if($form['test']->getData() == "oui")
                return $this->redirectToRoute('quiz_new',['offre'=> $offre->getId()]);
            else
                return $this->redirectToRoute('offre_index');
        }

        return $this->render('offre/new.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/searchOffre ", name="searchOffre")
     */
    public function searchOffre(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Offre::class);
        $requestString=$request->get('searchValue');
        $offre = $repository->findOffreParPost($requestString);
        $serializer = new Serializer(array(new DateTimeNormalizer('Y-m-d')));
        $data=array();

        foreach ($offre as $o)
        {
            array_push($data,array("id"=>$o->getId(),"post"=>$o->getPost(),"description"=>$o->getDescription(),
                "dateDepo"=>$serializer->normalize($o->getDateDepo()),"dateExpiration"=>$serializer->normalize($o->getDateExpiration()),"domaine"=>$o->getDomaine()));
        }


        return new JsonResponse($data);
    }
    /**
     * @Route("/backoffre", name="backoffre", methods={"GET"})
     */
    public function backoffre(OffreRepository $offreRepository,Request $request): Response
    {
        //dd($offreRepository->findAll());
        return $this->render('offre/show_list_back.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);
    }





    /**
     * @Route("/{id}", name="offre_show", methods={"GET"})
     */
    public function show(Offre $offre ,UserRepository $repository): Response
    {
        $user = new User();
        $user = $repository->findOneBy(['email' => $this->get('session')->get('_security.last_username')]);
        //dd($user,$offre);
        if ($user== null){
            return $this->render('offre/jobDetails.html.twig', [
                'offre' => $offre,
            ]);
        }elseif ($user->getRoles()[0]=="Employeur"){
            return $this->render('offre/show.html.twig', [
                'offre' => $offre,
            ]);
        }else{
            return $this->render('offre/jobDetails.html.twig', [
                'offre' => $offre,
            ]);
        }
    }

    /**
     * @Route("/{id}/edit", name="offre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Offre $offre): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            if($form['test']->getData() == "oui")
                return $this->redirectToRoute('quiz_new',['offre'=> $offre->getId()]);
            else
                return $this->redirectToRoute('offre_index');
        }

        return $this->render('offre/edit.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}", name="offre_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Offre $offre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            //$entityManager->remove($offre);
            $offre->setEtat(false);
            $entityManager->flush();
        }

        return $this->redirectToRoute('offre_index');
    }


}