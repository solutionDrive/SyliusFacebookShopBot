<?php
/**
 * Created by solutionDrive GmbH.
 *
 * @author   :  Julius Noack <noack@solutionDrive.de>
 * @date     :  14.10.17
 * @time     :  15:56
 * @copyright:  2017 solutionDrive GmbH
 */

namespace ApiBundle\Services;

use ApiBundle\Models\Messaging;
use ApiBundle\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class FacebookService
{
    protected $client;
    public function __construct(ClientService $client)
    {
        $this->client = $client;
    }

    public function sendMessage($message, $fromId, $toId)
    {
        $oMessaging = new Messaging();
        $oSender = new User();
        $oReceiver = new User();
        $oSender->setId($fromId);
        $oMessaging->setSender($oSender);
        $oReceiver->setId($toId);
        $oMessaging->setRecipient($oReceiver);
        $oMessaging->setMessage($message);

        $this->client->request('POST', 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAXTdOc8KwIBAHFaOa6PKT5ad1jEatXgPS2TffgfNSjUZBqyFSNpBlcwmU5MbZCUduZAtuqH9R3dGkKJQmYDNEaW37FZAZBzm4MHYi1ZAZBL8yuEW7teq6u9l0uHWa1DtyyFJep9DgNNwY0wu3aKNj2MKeGSnOyn0ZCHepRixMl4J0ktQSnODUIcLDvymZATEyToZD',
            [
                'json' => $oMessaging->getArray()
            ]
        );
    }
}