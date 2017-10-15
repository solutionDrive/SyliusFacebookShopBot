<?php

namespace ApiBundle\Controller;

use ApiBundle\Models\Entry;
use ApiBundle\Models\FacebookResponse;
use ApiBundle\Models\Messaging;
use ApiBundle\Models\User;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    const PAGE_ID = "125407384752995";
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|Response
     */
    public function indexAction(Request $request)
    {
        $mode = $request->get('hub_mode');
        $challenge = $request->get('hub_challenge');
        $token = $request->get('hub_verify_token');

        if ($mode !== 'subscribe' && $token !== "SyliusHackerton") {
            return $this->json(['success' => false]);
        }

        return new Response("$challenge", 200);
    }

    /**
     * @param Request $request
     */
    public function receiveAction(Request $request)
    {
        $oRequest = $request->getContent();
        $aRequest = json_decode($oRequest, true);
        $logger = $this->get('logger');
        $logger->error(var_export($request->getContent(), true));
        $this->sendMessage($aRequest);

        return $this->json([]);
    }

    /**
     * @param $aRequest
     */
    protected function sendMessage($aRequest)
    {
        $oMessaging = new Messaging();
        $oSender = new User();
        $oReceiver = new User();

        if ($aRequest['entry'][0]['messaging'][0]['sender']['id'] === self::PAGE_ID) {
            return;
        }

        $oSender->setId($aRequest['entry'][0]['messaging'][0]['recipient']['id']);
        $oMessaging->setSender($oSender);
        $oReceiver->setId($aRequest['entry'][0]['messaging'][0]['sender']['id']);
        $oMessaging->setRecipient($oReceiver);
        $oMessaging->setMessage('hallo');

        $oGuzzle = $this->get('api.client');
        $oGuzzle->request('POST', 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAXTdOc8KwIBAHFaOa6PKT5ad1jEatXgPS2TffgfNSjUZBqyFSNpBlcwmU5MbZCUduZAtuqH9R3dGkKJQmYDNEaW37FZAZBzm4MHYi1ZAZBL8yuEW7teq6u9l0uHWa1DtyyFJep9DgNNwY0wu3aKNj2MKeGSnOyn0ZCHepRixMl4J0ktQSnODUIcLDvymZATEyToZD',
            [
                'json' => $oMessaging->getArray()
            ]
        );
    }
}
