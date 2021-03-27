<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\PostLike;
use App\Repository\PostLikeRepository;
use App\Entity\user;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use Symfony\Component\Serializer\Serializer;

class VideoController extends AbstractController
{
    /**
     * @Route("/video", name="video")
     */
    public function index(): Response
    {
        return $this->render('video/index.html.twig', [
            'controller_name' => 'VideoController',
        ]);
    }

    /**
     * @Route("/addvideo" , name="Addvideo")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return RedirectResponse|Response
     */

    public function addVid(Request $request , \Swift_Mailer $mailer)
    {
        $link = "https://www.youtube.com/embed/";
        $date = new \DateTime();
        $video = new Video();
        $form = $this->createFormBuilder($video)
            ->add('url',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Url video',
                    'name'=>'name',
                ]
            ])
            ->add('title',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Titre',
                    'name'=>'name',
                ]
            ])
            ->add('domaine', ChoiceType::class,[
                'choices'  => [
                    'Aéronautique Et Espace' => 'Aéronautique Et Espace',
                    'Agriculture - Agroalimentaire' => 'Agriculture - Agroalimentaire',
                    'Artisanat' => 'Artisanat',
                    'Audiovisuel, Cinéma' => 'Audiovisuel, Cinéma',
                    'Audit, Comptabilité, Gestion' => 'Audit, Comptabilité, Gestion',
                    'Automobile' => 'Automobile',
                    'Banque, Assurance' => 'Banque, Assurance',
                    'Bâtiment, Travaux Publics' => 'Bâtiment, Travaux Publics',
                    'Biologie, Chimie, Pharmacie' => 'Biologie, Chimie, Pharmacie',
                    'Commerce, Distribution' => 'Commerce, Distribution',
                    'Communication' => 'Communication',
                    'Création, Métiers art' => 'Création, Métiers art',
                    'Culture, Patrimoine' => 'Culture, Patrimoine',
                    'Défense, Sécurité, Armée' => 'Défense, Sécurité, Armée',
                    'Documentation, Bibliothèque' => 'Documentation, Bibliothèque',
                    'Droit' => 'Droit',
                    'Edition, Livre' => 'Edition, Livre',
                    'Enseignement' => 'Enseignement',
                    'Environnement' => 'Environnement',
                    'Ferroviaire' => 'Ferroviaire',
                    'Foires, Salons Et Congrès' => 'Foires, Salons Et Congrès',
                    'Fonction Publique' => 'Fonction Publique',
                    'Hôtellerie, Restauration' => 'Hôtellerie, Restauration',
                    'Humanitaire' => 'Humanitaire',
                    'Immobilier' => 'Immobilier',
                    'Industrie' => 'Industrie',
                    'Informatique, Télécoms, Web' => 'Informatique, Télécoms, Web',
                    'Jeu Vidéo' => 'Jeu Vidéo',
                    'Journalisme' => 'Journalisme',
                    'Langues' => 'Langues',
                    'Marketing, Publicité' => 'Marketing, Publicité',
                    'Médical' => 'Médical',
                    'Mode-Textile' => 'Mode-Textile',
                    'Paramédical' => 'Paramédical',
                    'Propreté Et Services Associés' => 'Propreté Et Services Associés',
                    'Psychologie' => 'Psychologie',
                    'Ressources Humaines' => 'Ressources Humaines',
                    'Sciences Humaines Et Sociales' => 'Sciences Humaines Et Sociales',
                    'Secrétariat' => 'Secrétariat',
                    'Social' => 'Social',
                    'Spectacle - Métiers De La Scène' => 'Spectacle - Métiers De La Scène',
                    'Sport' => 'Sport',
                    'Tourisme' => 'Tourisme',
                    'Transport-Logistique' => 'Transport-Logistique',
                ],
            ])
            ->add('description',TextareaType::class,[
                'attr'=>[
                    'placeholder'=>'Description',
                    'name'=>'name',
                ]
            ])
            ->add('publishDate',DateType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $url = $video->getUrl();
            $link = $link.substr($url,-11);
            //$link = (($link . $this->between ('=', '&', $url)) || ($link.substr($url,-11))) ;
            $video->setUrl($link);
            $video->setVotes(0);
            $video->setPublishDate($date);
            $video->setIdCand($this->getUser());

            $message = (new \Swift_Message('Annonce formation'))
                ->setFrom('nour.mrad181@gmail.com')
                ->setTo('nourmrad171199@gmail.com')
                ->setBody(
                    $this->renderView(
                        'video/email.html.twig', ["video"=>$video]
                    ),


                    'text/html'
                );

            $mailer->send($message);
            $em->persist($video);
            $em->flush();



            return $this->redirectToRoute('Viewvideo');


        }
        return $this->render("video/add_video.html.twig",["f"=>$form->createView()]);
    }




    /**
     * @Route("/viewvideo" , name="Viewvideo" )
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function viewVid(PaginatorInterface $paginator, Request $request): Response
    {
        $userId = $this->getUser()->getId();
        $id = array('id_cand' => $userId);
        $video = $this->getDoctrine()->getManager()->getRepository(video::class);
        $videos=$video->findby($id);

        $videos = $paginator->paginate(
        // Doctrine Query, not results
            $videos,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );

        return $this->render("video/list_videos.html.twig",["videos"=>$videos]);
    }


    /**
     * @Route("/deletevideo/{id}" , name="DeleteVideo" )
     * @param $id
     * @return RedirectResponse
     */

    public function deleteAction($id)
    {

        $video=$this->getDoctrine()->getRepository(Video::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($video);
        $em->flush();
        return $this->redirectToRoute("Viewvideo");

    }


    /**
     * @Route("/updatevideo/{id}" , name="Updatevideo")
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function updateVid(Request $request,$id)
    {
        $link = "https://www.youtube.com/embed/";
        $date = new \DateTime();
        $video = $this->getDoctrine()->getRepository(video::class)->find($id);

        $form = $this->createFormBuilder($video)
            ->add('url',TextType::class)
            ->add('title',TextType::class)
            ->add('domaine', ChoiceType::class,[
                'choices'  => [
                    'Aéronautique Et Espace' => 'Aéronautique Et Espace',
                    'Agriculture - Agroalimentaire' => 'Agriculture - Agroalimentaire',
                    'Artisanat' => 'Artisanat',
                    'Audiovisuel, Cinéma' => 'Audiovisuel, Cinéma',
                    'Audit, Comptabilité, Gestion' => 'Audit, Comptabilité, Gestion',
                    'Automobile' => 'Automobile',
                    'Banque, Assurance' => 'Banque, Assurance',
                    'Bâtiment, Travaux Publics' => 'Bâtiment, Travaux Publics',
                    'Biologie, Chimie, Pharmacie' => 'Biologie, Chimie, Pharmacie',
                    'Commerce, Distribution' => 'Commerce, Distribution',
                    'Communication' => 'Communication',
                    'Création, Métiers art' => 'Création, Métiers art',
                    'Culture, Patrimoine' => 'Culture, Patrimoine',
                    'Défense, Sécurité, Armée' => 'Défense, Sécurité, Armée',
                    'Documentation, Bibliothèque' => 'Documentation, Bibliothèque',
                    'Droit' => 'Droit',
                    'Edition, Livre' => 'Edition, Livre',
                    'Enseignement' => 'Enseignement',
                    'Environnement' => 'Environnement',
                    'Ferroviaire' => 'Ferroviaire',
                    'Foires, Salons Et Congrès' => 'Foires, Salons Et Congrès',
                    'Fonction Publique' => 'Fonction Publique',
                    'Hôtellerie, Restauration' => 'Hôtellerie, Restauration',
                    'Humanitaire' => 'Humanitaire',
                    'Immobilier' => 'Immobilier',
                    'Industrie' => 'Industrie',
                    'Informatique, Télécoms, Web' => 'Informatique, Télécoms, Web',
                    'Jeu Vidéo' => 'Jeu Vidéo',
                    'Journalisme' => 'Journalisme',
                    'Langues' => 'Langues',
                    'Marketing, Publicité' => 'Marketing, Publicité',
                    'Médical' => 'Médical',
                    'Mode-Textile' => 'Mode-Textile',
                    'Paramédical' => 'Paramédical',
                    'Propreté Et Services Associés' => 'Propreté Et Services Associés',
                    'Psychologie' => 'Psychologie',
                    'Ressources Humaines' => 'Ressources Humaines',
                    'Sciences Humaines Et Sociales' => 'Sciences Humaines Et Sociales',
                    'Secrétariat' => 'Secrétariat',
                    'Social' => 'Social',
                    'Spectacle - Métiers De La Scène' => 'Spectacle - Métiers De La Scène',
                    'Sport' => 'Sport',
                    'Tourisme' => 'Tourisme',
                    'Transport-Logistique' => 'Transport-Logistique',
                ],
            ])
            ->add('description',TextType::class)
            ->add('publishDate',DateType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted())
        {

            $em = $this->getDoctrine()->getManager();
            $url = $video->getUrl();
            $link = $link.substr($url,-11);
            //$link = (($link . $this->between ('=', '&', $url)) || ($link.substr($url,-11))) ;
            $video->setUrl($link);
            $video->setPublishDate($date);
            $video->setIdCand($this->getUser());
            $em->flush();
            return $this->redirectToRoute('Viewvideo');
        }

        return $this->render('video/update_video.html.twig',array('f'=>$form->createView()));

    }




    /**
     * @Route("/viewAction" , name="list_video_back")
     */
    public function viewAction()
    {
        $video = $this->getDoctrine()->getRepository(video::class);
        $videos=$video->findAll();
        return $this->render("video/list_videos_back.html.twig",["videos"=>$videos,]);
    }


    /**
     * @Route("/listvideo" , name="list_video")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function viewAll(PaginatorInterface $paginator, Request $request): Response
    {
        $video = $this->getDoctrine()->getManager()->getRepository(video::class);
        $videos=$video->findAll();
        $videos = $paginator->paginate(
        // Doctrine Query, not results
            $videos,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );
        return $this->render("video/list_video.html.twig",["videos"=>$videos,]);
    }







    /**
     * @Route("/searchVideo ", name="searchVideo")
     */
    public function searchVideo(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Video::class);
        $requestString=$request->get('searchValue');
        $video = $repository->findVideoParTitre($requestString);
        $serializer = new Serializer(array(new DateTimeNormalizer('Y-m-d H:i:s')));
        $data=array();

        foreach ($video as $v)
        {
            array_push($data,array("id"=>$v->getId(),"title"=>$v->getTitle(),
                "publishDate"=>$serializer->normalize($v->getPublishDate()),"votes"=>count($v->getLikes()),"url"=>$v->getUrl(),"domaine"=>$v->getDomaine()));
        }


        return new JsonResponse($data);
    }



    /**
     * Permet de liker ou unliker une video
     *
     * @Route ("/video/{id}/like", name="post_like")
     *
     * @param Video $post
     * @param EntityManagerInterface $manager
     * @param PostLikeRepository $likeRepo
     * @return Response
     */

    public function like(Video $post, EntityManagerInterface $manager,  PostLikeRepository $likeRepo ) : Response
    {

        $user = $this->getUser();

        if(!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"

        ],403);


        if($post->isLikedByUser($user))

        {
            $like = $this->getDoctrine()->getRepository(PostLike::class)->findOneBy([
                'post'=>$post,
                'user'=>$user
            ]);

            $manager->remove($like);
            $manager->flush();


            return $this->json([
                'code'=>200,
                'message'=>'like bien supprime',
                'likes'=>$likeRepo->count(['post'=>$post])
            ], 200);
        }

        $like = new PostLike();
        $like->setPost($post)
              ->setUser($user);
        $manager->persist($like);
        $manager->flush();


        return $this->json([
            'code' => 200,
            'message' => 'like bien ajouter',
            'likes'=>$likeRepo->count(['post'=>$post])
            ], 200);

    }


    /**
     * @Route("/list/video/detail/{id}", name="list_video_detail" , methods={"GET"})
     * @param $id
     * @return Response
     */
    public function listDet($id): Response
    {

        $video=$this->getDoctrine()->getRepository(Video::class);
        $video=$video->find($id);
        return $this->render('video/video_detail.html.twig',['video'=>$video , ]);


    }



    /**
     * @Route("/statistiques",name="statistiques")
     */
    public function statistiques(): Response
    {
        $video=$this->getDoctrine()->getRepository(Video::class);
        $nbs = $video->getNb();
        $data = [['Date', 'Video']];
        foreach($nbs as $nb)
        {
            $data[] = array($nb['date'], $nb['vid']);
        }
        $bar = new barchart();
        $bar->getData()->setArrayToDataTable(
            $data
        );

        $bar->getOptions()->getTitleTextStyle()->setColor('#07600');
        $bar->getOptions()->getTitleTextStyle()->setFontSize(25);
        return $this->render('video/statistique.html.twig', array('barchart' => $bar,'nbs' => $nbs));

    }




    /**
     * @Route("/filtreVideo", name="filtreVideo")
     */
    public function filtreVid(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Video::class);
        $requestString=$request->get('filtreValue');
        $video = $repository->filtreVidParDomaine($requestString);

        $serializer = new Serializer(array(new DateTimeNormalizer('Y-m-d H:i:s')));
        $data=array();

        foreach ($video as $v)
        {
            array_push($data,array("id"=>$v->getId(),"title"=>$v->getTitle(),
                "publishDate"=>$serializer->normalize($v->getPublishDate()),"votes"=>count($v->getLikes()),
                "url"=>$v->getUrl(),"domaine"=>$v->getDomaine(),"description"=>$v->getDescription()));
        }



        return new JsonResponse($data);
    }



}
