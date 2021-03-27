<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

class TokenController extends AbstractController
{
    /**
     * @Route("/token", name="token")
     */
    public function index()
    {
        return $this->render('token/index.html.twig', [
            'controller_name' => 'TokenController',
        ]);
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("access_token", name="access_token", methods={"POST"})
     */
    public function generate_token(Request $request)
    {

        $accountSid = 'AC46b0e17f411b116ef2f5930618f8b0e8';
        $apiKeySid = 'SK4f22453aee2baf0a77042d1499d28004';
        $apiKeySecret = 'HXStwT2q9Yz5CnpTORFD0wwWUjYQRmPU';
        $identity = uniqid();

        $roomName = json_decode($request->getContent());

        // Create an Access Token
        $token = new AccessToken(
            $accountSid,
            $apiKeySid,
            $apiKeySecret,
            3600,
            $identity
        );

        // Grant access to Video
        $grant = new VideoGrant();
        $grant->setRoom($roomName->roomName);
        $token->addGrant($grant);
        return $this->json(['token' => $token->toJWT()], 200);
    }
}