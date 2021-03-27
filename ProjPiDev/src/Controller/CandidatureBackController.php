<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CandidatureRepository;
use App\Entity\Candidature;
use App\Form\CandidatureType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/candidatureback")
 */
class CandidatureBackController extends AbstractController
{
     /**
     * @Route("/", name="candidatureback_index", methods={"GET"})
     * @param CandidatureRepository $candidatureRepository
     * @return Response
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
        $donnees =$candidatureRepository->findAll();
        $candidatures = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5// Nombre de résultats par page
        );
        return $this->render('candidature_back/index.html.twig', [
            'candidatures' => $candidatures,
        ]);
    }

    /**
     * @Route("/stats", name="stats")
     */
    public function stats() : Response
    {

        $p=$this->getDoctrine()->getRepository(Candidature::class);
        //year
        $years = $p->getYear();
        $data = [['Years', 'Nombre de postulations']];
        foreach($years as $year)
        {
            $data[] = array($year['year'], $year['post']);
        }

        $bar1 = new barchart();
        $bar1->getData()->setArrayToDataTable(
            $data
        );
        $bar1->getOptions()->setTitle('par années');
        $bar1->getOptions()->getTitleTextStyle()->setColor('#07600');
        $bar1->getOptions()->getTitleTextStyle()->setFontSize(25);

        //month
        $months = $p->getMonth();
        $data = [['Mois', 'Nombre de postulations']];
        foreach($months as $month)
        {
            $data[] = array($month['month'], $month['post']);
        }

        $bar2 = new barchart();
        $bar2->getData()->setArrayToDataTable(
            $data
        );
        $bar2->getOptions()->setTitle('par mois');
        $bar2->getOptions()->getTitleTextStyle()->setColor('#07600');
        $bar2->getOptions()->getTitleTextStyle()->setFontSize(25);

        //day
        $days = $p->getDay();
        $data = [['Années', 'Nombre de postulations']];
        foreach($days as $day)
        {
            $data[] = array($day['day'], $day['post']);
        }

        $bar3 = new barchart();
        $bar3->getData()->setArrayToDataTable(
            $data
        );
        $bar3->getOptions()->setTitle('par jour');
        $bar3->getOptions()->getTitleTextStyle()->setColor('#07600');
        $bar3->getOptions()->getTitleTextStyle()->setFontSize(25);


        return $this->render('candidature_back/stats.html.twig', array('barchart1' => $bar1, 'barchart2' => $bar2,'barchart3' => $bar3));
    }

    /**
     * @Route("/searchCandidatureback ", name="searchCandidatureback")
     */
    public function searchCandback(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Candidature::class);
        $requestString=$request->get('searchValue');
        $candidature = $repository->findCandidatureParNom($requestString);
        //$serializer = new Serializer(array(new DateTimeNormalizer('Y-m-d H:i:s')));
        $data=array();

        foreach ($candidature as $c)
        {
            array_push($data,array("id_offer"=>$c->getIdOffer(),
                "nom"=>$c->getNom(),
                "prenom"=>$c->getPrenom(),
                "sexe"=>$c->getSexe(),
                "email"=>$c->getEmail(),
               // "date_naiss"=>$serializer->normalize($c->getDateNaiss()),
                "num"=>$c->getNum(),
                "status"=>$c->getStatus(),
                "diplome"=>$c->getDiplome(),
                "cv"=>$c->getCv(),
               // "date_cand"=>$serializer->normalize($c->getDateCandidature())
            ));
        }

        return new JsonResponse($data);
    }




    /**
     * @Route("/new", name="candidatureback_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $candidature = new Candidature();
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

                $candidature->setDateCandidature(new \DateTime('now'));
        
        $userId = $this->getUser()->getId();
        $candidature->setIdCandidat($userId);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidature);
            $entityManager->flush();

            return $this->redirectToRoute('candidatureback_index');
        }

        return $this->render('candidature_back/new.html.twig', [
            'candidature' => $candidature,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="candidatureback_show", methods={"GET"})
     * @param Candidature $candidature
     * @return Response
     */
    public function show(Candidature $candidature): Response
    {
        return $this->render('candidature_back/show.html.twig', [
            'candidature' => $candidature,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="candidatureback_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Candidature $candidature
     * @return Response
     */
    public function edit(Request $request, Candidature $candidature): Response
    {
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('candidatureback_index');
        }

        return $this->render('candidature_back/edit.html.twig', [
            'candidature' => $candidature,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="candidatureback_delete", methods={"DELETE"})
     * @param Request $request
     * @param Candidature $candidature
     * @return Response
     */
    public function delete(Request $request, Candidature $candidature): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidature->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($candidature);
            $entityManager->flush();
        }

        return $this->redirectToRoute('candidatureback_index');
    }



}