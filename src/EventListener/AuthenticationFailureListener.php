<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;

class AuthenticationFailureListener
{
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $data = 'E - Mail ou mot de passe incorrect, veuillez réessayer';


        $response = new JWTAuthenticationFailureResponse($data);

        $event->setResponse($response);
    }

}
