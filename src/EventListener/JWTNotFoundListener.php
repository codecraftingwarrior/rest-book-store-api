<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class JWTNotFoundListener
{
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $data = [
            'status'  => '403 Accés refusé.',
            'message' => 'Veuillez vous authentifier.',
        ];

        $response = new JsonResponse($data, 403);
        $event->setResponse($response);
    }
}
