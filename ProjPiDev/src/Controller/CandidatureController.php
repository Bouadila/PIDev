<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Form\CandidatureType;
use App\Entity\Offre;
use App\Entity\User;
use App\Repository\CandidatureRepository;
use App\Repository\OffreRepository;
use App\Repository\UserRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\TableChart;





/**
 * @Route("/candidature")
 */
class CandidatureController extends AbstractController
{
    /**
     * @Route("/", name="candidature_index", methods={"GET"})
     */
    public function index(CandidatureRepository $candidatureRepository, Request $request, PaginatorInterface $paginator,UserRepository $repository): Response

    {
        $user = new User();
        $user = $repository->findOneBy(['email' => $this->get('session')->get('_security.last_username')]);
        $userId = $this->getUser()->getId();
        $id = array('candidat' => $userId);
        $donnees =$candidatureRepository->findBy($id);
        if ($user== null){
            dd("cette route inaccessible ");
        }
        elseif($user->getRoles()[0]=="Employeur")
        {

        }
        else{
            $candidatures = $paginator->paginate(
                $donnees, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                3// Nombre de résultats par page
            );
            return $this->render('candidature/index.html.twig', [
                'candidatures' => $candidatures,
            ]);

        }
    }

    /**
     * @Route("/candidatureEnt", name="candidatureEnt", methods={"GET"})
     */
    public function indexEnt(CandidatureRepository $candidatureRepository, Request $request, PaginatorInterface $paginator): Response

    {
        return $this->render('candidature/indexEnt.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
        ]);

    }

    /**
     * @Route("/new/{id}", name="candidature_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id, \Swift_Mailer $mailer, UserRepository $repository): Response
    {

        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
        $candidature = new Candidature();
        $candidature->setOffre($offre);
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);
        $candidature->setDateCandidature(new \DateTime('now'));
        $userId = $this->getUser()->getId();
        $name = $this->getUser()->getName();
        $user = $repository->findOneBy(['email' => $this->get('session')->get('_security.last_username')]);
        $candidature->setCandidat($user);


        if ($form->isSubmitted() && $form->isValid()) {

            $file = $candidature->getCv();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('upload_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $candidature->setCv($fileName);

            $message = (new \Swift_Message('Annonce formation'))
                ->setFrom('pidevtestad@gmail.com')
                ->setTo('pidevtestad@gmail.com')
                ->setBody(
                    $this->renderView(
                        'registration/emailcandidature.html.twig', ["name"=>$name]
                    ),
                    'text/html'
                );

            $mailer->send($message);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidature);
            $entityManager->flush();

            if($offre->getQuiz() == null)
                return $this->redirectToRoute('candidature_index');
            else
                return $this->redirectToRoute('take_quiz',['id'=>$offre->getQuiz()->getId(), 'candidature'=> $candidature->getId()]);
        }

        return $this->render('candidature/new.html.twig', [
            'candidature' => $candidature,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/view_all_candidature" , name="view_all_candidature")
     */
    public function view_all_cand(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Candidature::class);
        $candidatures = $repository->findAll();

        $jsonContent=$Normalizer->normalize($candidatures,'json', ['groups'=>'candidature']);
        /*dump($jsonContent);
        die;*/
        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/delete_candidature" , name="delete_candidature")
     * @param Request $request
     * @param NormalizerInterface $Normalizer
     * @return JsonResponse|Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */

    public function delete_candidature(Request $request , NormalizerInterface $Normalizer)
    {

        $id = $request->get("id");

        $em=$this->getDoctrine()->getManager();
        $candidature=$em->getRepository(Candidature::class)->find($id);

        if($candidature!=null)
        {
            $em->remove($candidature);
            $em->flush();

            $jsonContent=$Normalizer->normalize($candidature,'json', ['groups'=>'candidature']);
            /*dump($jsonContent);
            die;*/
            return new Response("candidature deleted".json_encode($jsonContent));


        }

        return new JsonResponse("id candidature invalide");

    }

    /**
     * @Route("/list_candidature_detail"), name="list_candidature_detlail")
     * @param Request $request
     * @param NormalizerInterface $Normalizer
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function list_Det(Request $request, NormalizerInterface $Normalizer): Response
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $candidature = $em->getRepository(Candidature::class)->find($id);
        $jsonContent=$Normalizer->normalize($candidature,'json', ['groups'=>'candidature']);
        /*dump($jsonContent);
        die;*/
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/add_candidature" , name="add_candidature" )
     * @param Request $request
     * @param NormalizerInterface $Normalizer
     * @param UserRepository $repository
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function add_candidature(Request $request , NormalizerInterface $Normalizer,UserRepository $repository,OffreRepository $repositoryOffre)
    {
        $candidature = new candidature();
        $em = $this->getDoctrine()->getManager();
        $user = $repository->findOneBy(['id' => $request->get('candidat_id')]);
        $offre = $repositoryOffre->findOneBy(['id'=>$request->get('offre_id')]);
        $candidature->setNum($request->get('num'));
        $candidature->setStatus($request->get('status'));
        $candidature->setDiplome($request->get('diplome'));
        $candidature->setCv($request->get('cv'));
        $candidature->setDateCandidature(new \DateTime('now'));
        $candidature->setCandidat($user);
        $candidature->setOffre($offre);
        $em->persist($candidature);
        $em->flush();
        $jsonContent=$Normalizer->normalize($candidature,'json', ['groups'=>'candidature']);
        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/update_candidature" , name="update_candidature")
     * @param Request $request
     * @param NormalizerInterface $Normalizer
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function update_candidature(Request $request , NormalizerInterface $Normalizer)
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $candidature = $em->getRepository(Candidature::class)->find($id);

        $candidature->setNum($request->get('num'));
        $candidature->setStatus($request->get('status'));
        $candidature->setDiplome($request->get('diplome'));
        $candidature->setCv($request->get('cv'));
        //$candidature->setDispo($request->get('dispo'));
        //$candidature->setLettre_motiv($request->get('lettre_motiv'));
        //$candidature->setCandidat_id($user);
        $candidature->setCandidat($request->get('candidat_id'));
        $candidature->setOffre($request->get('offre_id'));
        //http://127.0.0.1:8000/candidature/update_candidature?id=14&num=21544887&status=test&diplome=etst.pdf&cv=test.pdf

        $em->flush();
        $jsonContent=$Normalizer->normalize($candidature,'json', ['groups'=>'candidature']);
        /*dump($jsonContent);
        die;*/
        return new Response("Candidature updated".json_encode($jsonContent));




    }


    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/searchDate", name="search_date")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     * @throws \Exception
     */
    public function searchD(Request $request, PaginatorInterface $paginator): Response
    {
        //$userId = $this->getUser()->getId();
        //$id = array('id_candidat' => $userId);
        $orderBy = $request->query->get('order');
        $date1 =  new \DateTime($request->get('date1'));
        $date2 =  new \DateTime($request->get('date2'));

        $donnee = $this->getDoctrine()->getRepository(Candidature::class)
            // ->findBy($id)
            ->searchDate($date1, $date2, $orderBy);


        $result = $paginator->paginate(
            $donnee, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );

        return $this->render('candidature/search.html.twig', [
            'results' => $result,
            'date1' => $date1,
            'date2' => $date2,
            'order' => $orderBy,
        ]);
    }
    /**
     * @Route("/searchDateEnt", name="search_dateEnt")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     * @throws \Exception
     */
    public function searchDEnt(Request $request, PaginatorInterface $paginator): Response
    {
        //$userId = $this->getUser()->getId();
        //$id = array('id_candidat' => $userId);
        $orderBy = $request->query->get('order');
        $date1 =  new \DateTime($request->get('date1'));
        $date2 =  new \DateTime($request->get('date2'));

        $donnee = $this->getDoctrine()->getRepository(Candidature::class)
            // ->findBy($id)
            ->searchDate($date1, $date2, $orderBy);


        $result = $paginator->paginate(
            $donnee, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );

        return $this->render('candidature/searchEnt.html.twig', [
            'results' => $result,
            'date1' => $date1,
            'date2' => $date2,
            'order' => $orderBy,
        ]);
    }

    /**
     * @Route("/search", name="search_index")
     * @param Request $request
     * @return Response
     */
    public function search(Request $request, PaginatorInterface $paginator): Response
    {
        //$userId = $this->getUser()->getId();
        //$id = array('id_candidat' => $userId);
        $query = $request->query->get('query');
        $orderBy = $request->query->get('order');

        $donnee = $this->getDoctrine()->getRepository(Candidature::class)
            // ->findBy($id)
            ->search($query, $orderBy);


        $result = $paginator->paginate(
            $donnee, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );

        return $this->render('candidature/search.html.twig', [
            'results' => $result,
            'query' => $query,
            'order' => $orderBy,
        ]);
    }

    /**
     * @Route("/searchEnt", name="search_indexEnt")
     * @param Request $request
     * @return Response
     */
    public function searchEnt(Request $request, PaginatorInterface $paginator): Response
    {
        //$userId = $this->getUser()->getId();
        //$id = array('id_candidat' => $userId);
        $query = $request->query->get('query');
        $orderBy = $request->query->get('order');

        $donnee = $this->getDoctrine()->getRepository(Candidature::class)
            // ->findBy($id)
            ->search($query, $orderBy);


        $result = $paginator->paginate(
            $donnee, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );

        return $this->render('candidature/searchEnt.html.twig', [
            'results' => $result,
            'query' => $query,
            'order' => $orderBy,
        ]);
    }

    /**
     * @Route("/{id}", name="candidature_show", methods={"GET"})
     */
    public function show(Candidature $candidature): Response
    {
        return $this->render('candidature/show.html.twig', [
            'candidature' => $candidature,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="candidature_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Candidature $candidature): Response
    {
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('candidature_index');
        }

        return $this->render('candidature/edit.html.twig', [
            'candidature' => $candidature,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="candidature_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Candidature $candidature): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidature->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($candidature);
            $entityManager->flush();
        }

        return $this->redirectToRoute('candidature_index');
    }

    /**
     * @Route("/searchCandidature ", name="searchCandidature")
     */
    public function searchVideo(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Candidature::class);
        $requestString=$request->get('searchValue');
        $candidature = $repository->findCandidatureParNom($requestString);
        // $serializer = new Serializer(array(new DateTimeNormalizer('Y-m-d H:i:s')));
        $data=array();

        foreach ($candidature as $c)
        {
            array_push($data,array("id"=>$c->getId(),"nom"=>$c->getNom(),"prenom"=>$c->getPrenom()));
        }

        return new JsonResponse($data);
    }




}
