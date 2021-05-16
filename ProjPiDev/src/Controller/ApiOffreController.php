<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Repository\ContratRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ApiOffreController extends AbstractController
{
    /**
     * @Route("/api/offre", name="api_offre", methods={"GET"})
     */
    public function index(NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Offre::class);
        $offres = $repository->findAll();
        $jsonContent = $Normalizer->normalize($offres,'json',['groups'=>'offre:get']);
//        dd($jsonContent);
        return new Response(json_encode($jsonContent));

//        return $this->render('api_offre/index.html.twig', [
//            'controller_name' => 'ApiOffreController',
//        ]);
    }

    /**
     * @Route("/api/offre/{id}", name="api_offre_show", methods={"GET"})
     */
    public function show( Request $request , $id ,NormalizerInterface $Normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository(Offre::class)->find($id);
        $jsonContent = $Normalizer->normalize($offre,'json',['groups'=>'offre:get']);
        //dd($jsonContent);
        return new Response(json_encode($jsonContent));

    }
    /**
     * @Route("/api/offre/new", name="api_offre_add", methods={"POST"})
     */
    public function new( Request $request,NormalizerInterface $Normalizer,UserRepository $repository ,ContratRepository $contratRepository)
    {

        $em = $this->getDoctrine()->getManager();
        $offre = new Offre();
        $entpreprise = $repository->findOneBy(['id' => $request->get('entpreprise')]);
        $contrat = $contratRepository->findOneBy(['id'=>$request->get('contrat')]);
//        dd($entpreprise , $contrat,$request->get('description'),$request->get('salaire'),$request->get('dateExpiration')
//        ,$request->get('nombrePlace'),$request->get('post'),$request->get('objectif'));
        $offre->setDescription($request->get('description'));
        $offre->setSalaire($request->get('salaire'));
        //$offre->setDateExpiration($request->get('dateExpiration'));
        $offre->setDateExpiration(\DateTime::createFromFormat('Y-m-d', $request->get('dateExpiration')));
        $offre->setNombrePlace($request->get('nombrePlace'));
        $offre->setContrat($contrat);
        $offre->setPost($request->get('post'));
        $offre->setObjectif($request->get('objectif'));
        $offre->setCompetences($request->get('competences'));
        $offre->setDomaine($request->get('domaine'));
        $offre->setExperienceMin($request->get('experienceMin'));
        $offre->setExperienceMax($request->get('experienceMax'));
        $offre->setEntreprise($entpreprise);

        $em->persist($offre);
        $em->flush();
        $jsonContent = $Normalizer->normalize($offre,'json',['groups'=>'offre:get']);
        //dd($jsonContent);
        return new Response(json_encode($jsonContent));

    }
    /**
     * @Route("/api/offre/update/{id}", name="api_offre_update")
     */
    public function update( Request $request,NormalizerInterface $Normalizer,UserRepository $repository ,ContratRepository $contratRepository,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository(Offre::class)->find($id);
        $entpreprise = $repository->findOneBy(['id' => $request->get('entpreprise')]);
        $contrat = $contratRepository->findOneBy(['id'=>$request->get('contrat')]);
        $offre->setDescription($request->get('description'));
        $offre->setSalaire($request->get('salaire'));
        $offre->setDateExpiration(\DateTime::createFromFormat('Y-m-d', $request->get('dateExpiration')));
        $offre->setNombrePlace($request->get('nombrePlace'));
        $offre->setContrat($contrat);
        $offre->setPost($request->get('post'));
        $offre->setObjectif($request->get('objectif'));
        $offre->setCompetences($request->get('competences'));
        $offre->setDomaine($request->get('domaine'));
        $offre->setExperienceMin($request->get('experienceMin'));
        $offre->setExperienceMax($request->get('experienceMax'));
        $offre->setEntreprise($entpreprise);
        $em->flush();
        $jsonContent = $Normalizer->normalize($offre,'json',['groups'=>'offre:get']);
        //dd($jsonContent);
        return new Response("Information updated successfully".json_encode($jsonContent));
    }

    /**
     * @Route("/api/offre/delete/{id}", name="api_offre_delete")
     */
    public function delete( Request $request , $id ,NormalizerInterface $Normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository(Offre::class)->find($id);
        $em->remove($offre);
        $em->flush();
        $jsonContent = $Normalizer->normalize($offre,'json',['groups'=>'offre:get']);
        //dd($jsonContent);
        return new Response("Information deleted successfully".json_encode($jsonContent));

    }
}
