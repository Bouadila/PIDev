<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EntrepriseType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\RegistrationFormType;
//use App\Recaptcha\RecaptchaValidator;
use App\Security\EmailVerifier;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\FormError;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpFoundation\JsonResponse;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Serializer\Serializer ;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer ;
class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     *
     * @Route("registration", name="registration")
     * @param Request $request
     */
    public function indexcandidat(Request $request , UserRepository $repository ,\Swift_Mailer $mailer)
     {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->isSubmitted() and $form->isValid() ) {

            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            // Set their role
            $user->setEtat('0');
            $uploadedFile = $form['image']->getData();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $user->setImg($filename);
            $user->setRoles(['Candidat']);
//            $user->setCreatedAt();
                $user->setCreatedAt(new \DateTime('now'));
            //get the entity manager that exists in doctrine( entity manager and repository)
            // Save
                // On génère un token et on l'enregistre
                $user->setActivationToken(md5(uniqid()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
                // On crée le message
                $message = (new \Swift_Message('Nouveau compte'))
                    ->setFrom('yasmin.hachicha@esprit.tn')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'emails/activation.html.twig', ['token' => $user->getActivationToken()]
                        ),
                        'text/html'
                    );
                $mailer->send($message);

            return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/index.html.twig', [

//        return $this->render('registration/confirm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @param  Request $request
     * @Route("registrationentrep", name="registrationentrep")
     */
    public function indexentreprice(Request $request ,UserRepository $repository,\Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(EntrepriseType::class, $user);
        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->isSubmitted() and $form->isValid()) {

                // Encode the new users password
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            // Set their role
            $user->setEtat('0');
            $uploadedFile = $form['image']->getData();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $user->setImg($filename);
            $user->setRoles(['Employeur']);
            $user->setCreatedAt(new \DateTime('now'));
            $user->setActivationToken(md5(uniqid()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

//            return $this->redirectToRoute('app_login');
                $message = (new \Swift_Message('Nouveau compte'))
                    ->setFrom('yasmin.hachicha@esprit.tn')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'emails/activation.html.twig', ['token' => $user->getActivationToken()]
                        ),
                        'text/html'
                    );
                $mailer->send($message);

                return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/indexEntreprise.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/aff/user", name="aff_user1")
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
     * @Route("/aff/employ", name="aff_user")
     */

    public function Read2(UserRepository $repository )
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

        return $this->render('espace_employeur/aff_espace_employeur.html.twig',
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
        if($form->isSubmitted() and $form->isValid() )
        {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
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
    /**
     * @param  Request $request
     * @Route("/Modif/useremploy", name="Modif_useremploy")
     */
    public function Update2(Request $request, UserRepository $repository)
    {
//        $candidat=$em->getRepository(Candidat::class)->findAll();
        $user = $repository->findOneBy(['email' => $this->get('session')->get('_security.last_username')]);

//        $user = $repository->findOneBy(['email' => $this->get('email') ]);

        $form=$this->createForm(EntrepriseType::class,$user);

//        $form->add('Modifier candidat',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid() )
        {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            $uploadedFile = $form['image']->getData();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $user->setImg($filename);
//            && $form->isValid()
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("aff_user");
        }

        return $this->render('espace_employeur/Modif_espace_employeur.html.twig',array(
                'form'=>$form->createView() ,
            )
        );
    }

    /**
     * @Route("/affback/user", name="affback_user")
     */
    public function ReadB()
    {
        //Creer un objet Doctrine
        $em=$this->getDoctrine();
        $user=$em->getRepository(User::class)->findAll();
        return $this->render('espace_candidat/affback_espace_candidat.html.twig',
            ['user'=> $user ,

            ]);
    }
    /**
     * @Route("/activation/app_actvcompte", name="app_actvcompte" )
     */
    public function index12(UserRepository $userRepository): Response
    {
        $user = new User();
        $user = $userRepository->findOneBy(['email' => $this->get('session')->get('_security.last_username')]);        $user->setEtat("0");
        $em=$this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute('app_logout');
    }
    /**
     * @Route("/activation/{token}", name="activation")
     */
    public function activation($token, UserRepository $user)
    {
        // On recherche si un utilisateur avec ce token existe dans la base de données
        $users = $user->findOneBy(['activation_token' => $token]);

        // Si aucun utilisateur n'est associé à ce token
        if(!$users){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        // On supprime le token
        $users->setActivationToken(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($users);
        $entityManager->flush();

        // On génère un message
        $this->addFlash('message', 'Utilisateur activé avec succès');

        // On retourne à l'accueil
        return $this->redirectToRoute('home');
    }



    /**
     * @Route("/searchcompte ", name="searchcompte")
     */
    public function searchcompte(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $requestString=$request->get('searchValue');
        $compte = $repository->findUserParName($requestString);
        $serializer = new Serializer(array(new DateTimeNormalizer('Y-m-d H:i')));
        $data=array();

        foreach ($compte as $c)
        {
            array_push($data,array("name"=>$c->getName(),"prenom"=>$c->getPrenom() ,"email"=>$c->getEmail() ,
                "DateNaiss"=>$serializer->normalize($c->getDateNaiss()) , "etat"=>$c->getEtat() ,"gover"=>$c->getGover() ,
                "NomEntre"=>$c->getNomEntre() , "special"=>$c->getSpecial(),));
        }
        return new JsonResponse($data); }

    /**
     * @Route("/stats", name="stats")
     */
    public function statistiques(UserRepository $userRepository)
    {
        $users = $userRepository->countByDate();
//$users1 = $userRepository->countByDate2();
        $dates = [];
        foreach($users as $user){
            $dates[] = $user['count'];
        }
////
        $users1 = $userRepository->countByDate2();

        $date = [];
        $annoncesCounte = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($users1 as $userss){
            $date[] = $userss['dateCompte'];
            $annoncesCounte[] = $userss['counte'];
        }


        return $this->render('espace_candidat/statistic.html.twig', [
            'dates' => json_encode($dates),
            'date' => json_encode($date),
            'annoncesCounte' => json_encode($annoncesCounte),
        ]); }

    }

