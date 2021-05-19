<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class UserMobileController extends AbstractController
{
    /**
     * @Route("/user/mobile", name="user_mobile")
     */
    public function index(): Response
    {
        return $this->render('user_mobile/index.html.twig', [
            'controller_name' => 'UserMobileController',
        ]);
    }
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     *
     * @Route("registrationmob", name="registrationmob")
     * @param Request $request
     */
    public function indexcandidat(Request $request,  SerializerInterface $serializer , UserRepository $repository ,\Swift_Mailer $mailer)
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

        }
        $json = $serializer->serialize($form,'json',['groups' => 'User']);
        return new Response($json);

    }

    /**
     * @Route("/aff_user_mobile", name="aff_user_mobile")
     */

    public function Read(UserRepository $repository ,Request $request, SerializerInterface $serializer )
    {
        $id = $request->get("id");//kima query->get wala get directement c la meme chose
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        $em=$this->getDoctrine();
        if($user->getRoles()==["Candidat","ROLE_USER"]){
            $rol='Candidat';
        } else if ($user->getRoles()==["Employeur","ROLE_USER"]) {
            $rol='Employeur';
        } else {  $rol='Admin';}

        return $this->json([
            'prenom' => $user->getPrenom(),
            'name' => $user->getName(),
            'gover' => $user->getGover(),
            'special' => $user->getSpecial(),
            'roles' => $rol,
            'email' => $user->getEmail(),
        ]);
    }


    /**
     * @Route("/Supp_user_mobile", name="Supp_user_mobile")
     */
    public function delete(Request $request, UserRepository $repository ,SerializerInterface $serializer)
    {
        $id = $request->get("id");//kima query->get wala get directement c la meme chose
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        //bon l modification bch na3mlouha bel image ya3ni kif tbadl profile ta3ik tzid image
        $user->setEtat('1');

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("desactive",200);//200 ya3ni http result ta3 server OK
        }catch (\Exception $ex) {
            return new Response("active");
        }


    }
    /**
     * @Route("/reactive_user_mobile", name="reactive_user_mobile")
     */
    public function reactive_user(Request $request, UserRepository $repository ,SerializerInterface $serializer)
    {
        $id = $request->get("id");//kima query->get wala get directement c la meme chose
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        //bon l modification bch na3mlouha bel image ya3ni kif tbadl profile ta3ik tzid image
        $user->setEtat('0');

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("active",200);//200 ya3ni http result ta3 server OK
        }catch (\Exception $ex) {
            return new Response("desactive");
        }


    }

    /**
     * @Route("/signin", name="signin", methods={"POST"})
     */
    public function login(Request $request): Response
    {
        $user = $this->getUser();
        if($user) {
            return $this->json([
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'roles' => $user->getRoles(),
//        'activation_token'=>$user->getActivationToken(),
                'name' => $user->getName()
            ]);
        }else
        {
            return new Response("failed");
        }

    }

    /**
     * @Route("/newFsmb", name="newFsmb", methods={"POST"})
     */
    public function newFsmb(Request $request,UserRepository $userRep,SerializerInterface $serializer,\Swift_Mailer $mailer ,UserPasswordEncoderInterface $userPasswordEncoder ): Response
    {
        $email=$request->query->get("email");
        $username=$request->query->get("name");
//        $img=$request->query->get("img");
        $pwd=$request->query->get("password");
        $roles= $request->query->get("roles");
        $prenom=$request->query->get("prenom");
        $gov=$request->query->get("gover");
        $specia=$request->query->get("special");
        $pwd=$request->query->get("password");
        $user=new User();
        $user->setName($username);
        $user->setEmail($email);
        $user->setImg("person_3.jpg");
        $hash = $userPasswordEncoder->encodePassword($user, $pwd);
        $user->setPassword($hash);
        $user->setEtat('0');
//        $uploadedFile = $user['image']->getData();
//        $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
//        $uploadedFile->move($this->getParameter('upload_directory'),$filename);
//        $user->setImg($filename);
        $user->setRoles(array($roles));//aleh array khater roles par defaut fi security  type ta3ha array

//            $user->setCreatedAt();
        $user->setCreatedAt(new \DateTime('now'));
        //get the entity manager that exists in doctrine( entity manager and repository)
        // Save
        // On génère un token et on l'enregistre
        $user->setActivationToken(md5(uniqid()));
        $user->setPrenom($prenom);
        $user->setGover($gov);
        $user->setSpecial($specia);
        try {
            $mn = $this->getDoctrine()->getManager();
            $mn->persist($user);
            $mn->flush();

            $response = new JsonResponse("account",200);
            $response->setStatusCode(201); // User Created
            return $response;

        }
        catch (\Exception $ex)
        {
            return  new Response("excep".$ex->getMessage());
        }

    }
    /**
     * @Route("user_ediUser", name="idaffiche")
     */


    public function editUser(Request $request, UserRepository $repository, UserPasswordEncoderInterface $passwordEncoder) {
        $id = $request->get("id");//kima query->get wala get directement c la meme chose
        $username = $request->query->get("name");
        $password = $request->query->get("password");
        $email = $request->query->get("email");
        $em=$this->getDoctrine()->getManager();
        $prenom=$request->query->get("prenom");
        $gov=$request->query->get("gover");
        $specia=$request->query->get("special");
        $user = $em->getRepository(User::class)->find($id);
        //bon l modification bch na3mlouha bel image ya3ni kif tbadl profile ta3ik tzid image
//        $img=$request->query->get("img");

//        if($request->files->get("img")!= null) {
//
//            $file = $request->files->get("img");//njib image fi url
//            $fileName = $file->getClientOriginalName();//nom ta3ha
//            $file->move($fileName);
//            $user->setImg($fileName);
//        }
//        $user->setImg($img);

        $user->setPrenom($prenom);
        $user->setGover($gov);
        $user->setSpecial($specia);
        $user->setName($username);
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $password
            )
        );

        $user->setEmail($email);


        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("success",200);//200 ya3ni http result ta3 server OK
        }catch (\Exception $ex) {
            return new Response("fail ".$ex->getMessage());
        }

    }

    /**
     * @Route("getPasswordByEmail", name="app_passwordd")
     */

    public function getPassswordByEmail(Request $request) {

        $email = $request->get('email');
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['email'=>$email]);
        if($user) {
            $password = $user->getPassword();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($password);
            return new JsonResponse($formatted);
        }
        return new Response("user not found");
    }

    /**
     * @Route("getPasswordmobile", name="app_password")
     */
    public function editUserr(Request $request, UserRepository $repository, UserPasswordEncoderInterface $passwordEncoder) {


        $email = $request->get('email');
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['email'=>$email]);
        $password = $request->query->get("password");

        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $password
            )
        );

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("success",200);//200 ya3ni http result ta3 server OK
        }catch (Exception $ex) {
            return new Response("fail ");
        }

    }

    /**
     * @Route("activecomptemobile", name="app_passworddd")
     */
    public function active(Request $request, UserRepository $repository, UserPasswordEncoderInterface $passwordEncoder) {


        $email = $request->get('email');
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['email'=>$email]);

        $user->setActivationToken(NULL);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new JsonResponse("success",200);//200 ya3ni http result ta3 server OK
        }catch (Exception $ex) {
            return new Response("fail ");
        }


    }

    /**
     * @Route("tokenlogin", name="tokenlogin")
     */
    public function token(Request $request, UserRepository $repository, UserPasswordEncoderInterface $passwordEncoder) {


        $email = $request->get('email');
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['email'=>$email]);
        if($user) {
            $password = $user->getActivationToken();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($password);
            if ($password==null)
            {      return new Response("oui");}
            else           {  return new Response("non");}

        }
        return new Response("user not found");
    }

    /**
     * @Route("etatcompte", name="etatcompte")
     */
    public function etatcompte(Request $request, UserRepository $repository, UserPasswordEncoderInterface $passwordEncoder) {


        $email = $request->get('email');
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['email'=>$email]);
        if($user) {
            $password = $user->getEtat();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($password);
            if ($password=='0')
            {      return new Response("active");}
            else           {  return new Response("nonactive");}

        }
        return new Response("user not found");
    }


}