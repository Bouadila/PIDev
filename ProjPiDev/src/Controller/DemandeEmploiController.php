<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;

use App\Repository\DemandeRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;


class DemandeEmploiController extends AbstractController
{
    /**
     * @Route("/Ajout/demande/emploi", name="Ajout_demande_emploi" , methods={"GET","POST"})
     */
    public function Ajout(Request $request): Response
    {

        $demande = new demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $demande->setIdCand($this->getUser());
            $demande = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
            return $this->redirectToRoute("list_demande_emploi");


    }
        return $this->render('demande_emploi/Ajout_demande_emploi.html.twig',array('formdemande'=>$form->createView()));




    }

    /**
     * @Route("/list/demande/emploi", name="list_demande_emploi" , methods={"GET"})
     */
    public function listeD(PaginatorInterface $paginator, Request $request): Response
    {
        $userId = $this->getUser()->getId();
        $id = array('idCand' => $userId);
        $demande=$this->getDoctrine()->getRepository(Demande::class);
        $count=$demande->countNbDemande();
        $demandes=$demande->findby($id);

        $demandes = $paginator->paginate(
        // Doctrine Query, not results
            $demandes,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );
        return $this->render('demande_emploi/liste_demande_emploi.html.twig',['demandes'=>$demandes , 'c'=>$count ]);
    }

    /**
     * @Route("/list/demande/back", name="list_demande_back" , methods={"GET"})
     */
    public function listeDB(): Response
    {

        $demande=$this->getDoctrine()->getRepository(Demande::class);
        $demandes=$demande->findAll();
        return $this->render('demande_emploi/liste_demande_back.html.twig',['demandes'=>$demandes , ]);

    }



    /**
     * @Route("/Supp/demande/emploi/{id}", name="Supp_demande_emploi" , methods={"DELETE"})
     */
    public function listeSu(Request $request, Demande $demande): Response
    {
        if ($this->isCsrfTokenValid('delete' . $demande->getId(), $request->request->get('_token')))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demande);
            $entityManager->flush();
        }
        return $this->redirectToRoute("list_demande_emploi");
    }



    /**
     * @Route("/Modif/demande/emploi/{id}", name="Modif_demande_emploi" , methods={"GET","POST"})
     */
    public function listeModif(Request $request, $id): Response
    {

        $demande=$this->getDoctrine()->getRepository(Demande::class)->find($id);
        $form=$this->createForm(DemandeType::class,$demande);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("list_demande_emploi");
        }

        return $this->render("demande_emploi/Modif_demande_emploi.html.twig",array('formdemandeMod'=>$form->createView()));
    }


    /**
     * @Route("/list/demande/emploi/detail/{id}", name="list_demande_emploi_detail" , methods={"GET"})
     */
    public function listeDet($id): Response
    {

        $demande=$this->getDoctrine()->getRepository(Demande::class);
        $demande=$demande->find($id);
        return $this->render('demande_emploi/aff_demande_detail.html.twig',['demande'=>$demande , ]);


    }





    /**
     * @param DemandeRepository $repository
     * @Route("/tri", name="tri")
     * @return Response
     */
    public function tri(DemandeRepository $repository,Request $request)
    {
        $demande= $repository->OrderByStatut();
        return $this->render('demande_emploi/search.html.twig', [
            'demande' => $demande,
        ]);
    }


    /**
     * @Route("/listdem/{id}", name="listdem", methods={"GET"})
     */
    public function listdem(DemandeRepository $demandeRepository,$id): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('demande_emploi/listdem.html.twig', [
            'demande' => $demandeRepository->find($id),
        ]);


        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("cv.pdf", [
            "Attachment" => false
        ]);
    }


    /**
     * @Route("/searchDemande ", name="searchDemande")
     */
    public function searchDemande(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Demande::class);
        $requestString=$request->get('searchValue');
        $demande = $repository->findDemandePardomaineTravail($requestString);
        $jsonContent = $Normalizer->normalize($demande, 'json',['groups'=>'demande']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }


    /**
     * @Route("/filtreDemande/{statutCand} ", name="filtreDemande")
     * @param $statutCand
     */
    public function filtreDemande(NormalizerInterface $Normalizer, $statutCand)
    {
        $repository = $this->getDoctrine()->getRepository(Demande::class);
        $demande = $repository->findStatutCand($statutCand);
        $jsonContent = $Normalizer->normalize($demande, 'json',['groups'=>'demande']);
        $retour=json_encode($jsonContent);
        return new Response($retour);
    }


}



