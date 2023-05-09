<?php

namespace App\Event;

use App\Entity\Newsletter;

class NewsletterSubscribedEvent
{
    public const NAME = 'newsletter.subscribed';

    public function __construct(
        private Newsletter $newsletter
    ) {

    }
    
    public function getNewsletter(): Newsletter
    {
        return $this->newsletter;
    }
}