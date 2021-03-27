<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EntrepriseType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     *
     * @param  Request $request
     * @Route("registration", name="registration")
     */
    public function indexcandidat(Request $request ,UserRepository $repository)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            // Set their role
            $user->setEtat('0');
            $uploadedFile = $form['image']->getData();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $user->setImg($filename);
            $user->setRoles(['Candidat']);
//            if($user->getNomEntre()!=null){
//                $user->setRoles(['Employeur']);
//            }elseif ($user->getNomEntre()==null){
//                $user->setRoles(['Candidat']);
//            }
            //get the entity manager that exists in doctrine( entity manager and repository)
            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

//            return $this->redirectToRoute('app_login');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @param  Request $request
     * @Route("registrationentrep", name="registrationentrep")
     */
    public function indexentreprice(Request $request ,UserRepository $repository)
    {
        $user = new User();
        $form = $this->createForm(EntrepriseType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            // Set their role
            $user->setEtat('0');
            $uploadedFile = $form['image']->getData();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $user->setImg($filename);
            $user->setRoles(['Employeur']);
//            if($user->getNomEntre()!=null){
//                $user->setRoles(['Employeur']);
//            }elseif ($user->getNomEntre()==null){
//                $user->setRoles(['Candidat']);
//            }
            //get the entity manager that exists in doctrine( entity manager and repository)
            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

//            return $this->redirectToRoute('app_login');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/indexEntreprise.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/aff/user", name="aff_user")
     */

    public function Read(UserRepository $repository )
    {
        $em=$this->getDoctrine();
//        $candidat=$em->getRepository(Candidat::class)->findAll();
        $user = $repository->findOneBy(['email' => $this->get('session')->get('_security.last_username')]);
//               dd( $user);
        if($user->getEtat()=='1'){
            echo("compte desactive");
        } else {
            echo($this->get('session')->get('id'));
            echo($this->get('session')->get('email'));}

        return $this->render('espace_candidat/aff_espace_candidat.html.twig',
            ['user' => $user,
            ]);
    }

    /**
     * @Route("/Supp/user", name="Supp_user")
     */
    public function delete(Request $request, UserRepository $repository)
    {
        $user = $repository->findOneBy(['email' => $this->get('session')->get('_security.last_username') ]);
//        dd($candidat);
        $user->setEtat('1');
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute('app_logout');

        return $this->render('espace_candidat/Supp_espace_candidat.html.twig', array(
                'user' => $user,)
        );
    }


    /**
     * @param  Request $request
     * @Route("/Modif/user", name="Modif_user")
     */

    public function Update(Request $request, UserRepository $repository)
    {
//        $candidat=$em->getRepository(Candidat::class)->findAll();
        $user = $repository->findOneBy(['email' => $this->get('session')->get('_security.last_username')]);
        
//        $user = $repository->findOneBy(['email' => $this->get('email') ]);

        $form=$this->createForm(UserType::class,$user);

//        $form->add('Modifier candidat',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() )
        {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_USER']);
            $uploadedFile = $form['image']->getData();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $user->setImg($filename);
//            && $form->isValid()
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("aff_user");
        }

        return $this->render('espace_candidat/Modif_espace_candidat.html.twig',array(
                'form'=>$form->createView() ,
            )

        );
    }

}

