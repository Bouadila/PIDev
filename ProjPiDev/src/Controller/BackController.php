<?php

namespace App\Controller;

use App\Repository\CandidatRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
class BackController extends AbstractController
{
    /**
     * @Route("/back", name="back")
     */
    public function index(): Response
    {


        return $this->render('back/index.html.twig', [
            'controller_name' => 'BackController',
        ]);
//return $this->render('back/index.html.twig',
//['amountByYear' => $chart->amountByYear()]);
    }

    /**
     * @Route("/listo", name="listo", methods={"GET"})
     */
    public function listo(UserRepository $userRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('sans-serif', 'Optima');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('back/listo.html.twig', [
            'user' => $userRepository->findAll(),
//            'user' => $userRepository->find($id), avec lfou9 $id

        ]);
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }

}
