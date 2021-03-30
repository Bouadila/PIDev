<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Form\CandidatureType;
use App\Entity\Offre;
use App\Entity\User;
use App\Repository\CandidatureRepository;
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
    public function index(CandidatureRepository $candidatureRepository, Request $request, PaginatorInterface $paginator): Response

    {
      //  $userId = $this->getUser()->getId();
     //   $id = array('id_candidat' => $userId);
     //   return $this->render('candidature/index.html.twig', [
     //       'candidatures' => $candidatureRepository->findBy($id),
     //   ]);

        $userId = $this->getUser()->getId();
        $id = array('id_candidat' => $userId);
        $donnees =$candidatureRepository->findBy($id);
        $candidatures = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );
        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidatures,
        ]);
    }

    /**
     * @Route("/ent/{id_offer}", name="candidatureEnt", methods={"GET"})
     */
    public function indexEnt(CandidatureRepository $candidatureRepository, $id_offer, Request $request, PaginatorInterface $paginator): Response

    {

        $candidatureRepository = $this->getDoctrine()->getRepository(Candidature::class);
        $id = array('id_offer' => $id_offer);
        $donnees =$candidatureRepository->findBy($id);
        $candidatures = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );
        return $this->render('candidature/indexEnt.html.twig', [
            'candidatures' => $candidatures,
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
