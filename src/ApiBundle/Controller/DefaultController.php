<?php

namespace ApiBundle\Controller;

use ApiBundle\Models\Entry;
use ApiBundle\Models\FacebookResponse;
use ApiBundle\Models\Messaging;
use ApiBundle\Models\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $recipient = new User();
        $recipient->setId('123');

        $sender = new User();
        $sender->setId('1234');

        $messaging = new Messaging();
        $messaging->setRecipient($recipient);
        $messaging->setSender($sender);

        $entry = new Entry();
        $entry->setId('125407384752995');
        $entry->setTime(time());
        $entry->setMessaging($messaging);

        $response = new FacebookResponse();
        $response->setEntry($entry);
        $response->setObject('page');

        return $this->json($response->getArray());
    }
}
