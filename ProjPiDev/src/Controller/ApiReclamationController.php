<?php

namespace App\Controller;

use App\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Repository\ContratRepository;



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


    /**
     * @Route("/api_reclamation_new", name="api_reclamation_add")
     */
    //public function new( Request $request,NormalizerInterface $Normalizer,UserRepository $repository ,ContratRepository $contratRepository)
    public function new( Request $request,NormalizerInterface $Normalizer)
        {

        $em = $this->getDoctrine()->getManager();
        $reclamation = new Reclamation();
        $newDate = new \DateTime('now');
        $reclamation->setTitle($request->get('title'));
        $reclamation->setDateReclamation($newDate->format('Y-m-d H:i:s'));
        $reclamation->setDescriptionReclamation($request->get('description_reclamation'));
        $reclamation->setType($request->get('type'));
        $reclamation->setEmail('test@email.tn');
        $reclamation->setStatus('Non Approuvé');
        $reclamation->setIdUser(1);
        $em->persist($reclamation);
        $em->flush();
        $jsonContent = $Normalizer->normalize($reclamation,'json',['groups'=>'reclamation:get']);
        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/api/reclamation/update/{id}", name="api_reclamation_update")
     */
    //public function update( Request $request,NormalizerInterface $Normalizer,UserRepository $repository ,ContratRepository $contratRepository,$id)
    public function update( Request $request,NormalizerInterface $Normalizer,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $reclamation =$em->getRepository(Reclamation::class)->find($id);
        $reclamation->setTitle($request->get('title'));
        $reclamation->setDescriptionReclamation($request->get('description_Reclamation'));
        $em->flush();
        $jsonContent = $Normalizer->normalize($reclamation,'json',['groups'=>'reclamation:get']);
        return new Response("Information updated successfully".json_encode($jsonContent));
    }
}

