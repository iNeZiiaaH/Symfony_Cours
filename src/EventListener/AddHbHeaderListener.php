<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class AddHbHeaderListener 
{
    public function addHeader(ResponseEvent $event)
    {
        $response = $event->getResponse();
        $response->headers->add([
            'X-DEVELOPED-BY' => 'HB Corp.'
        ]);
    }
}