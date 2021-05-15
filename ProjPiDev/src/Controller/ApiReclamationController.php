<?php

namespace App\Controller;

use App\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ApiReclamationController extends AbstractController
{
    /**
     * @Route("/api/reclamation", name="api_reclamation", methods={"GET"})
     */
    public function index(NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Reclamation::class);
        $reclamation = $repository->findAll();
        $jsonContent = $Normalizer->normalize($reclamation,'json',['groups'=>'reclamation:get']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/api/reclamation/{id}", name="api_reclamation_show", methods={"GET"})
     */
    public function show( Request $request , $id ,NormalizerInterface $Normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);
        $jsonContent = $Normalizer->normalize($reclamation,'json',['groups'=>'reclamation:get']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/api/reclamation/delete/{id}", name="api_reclamation_delete")
     */
    public function delete( Request $request , $id ,NormalizerInterface $Normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        $jsonContent = $Normalizer->normalize($reclamation,'json',['groups'=>'reclamation:get']);
        return new Response("Information deleted successfully".json_encode($jsonContent));
    }
}
