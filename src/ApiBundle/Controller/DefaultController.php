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
        $aRequest = json_decode($oRequest);
        $oResponse = $this->_setRequest($aRequest);
        return $this->json($oResponse->getArray());
    }

    /**
     * @param $aRequest
     */
    protected function _setRequest($aRequest)
    {
        $oFacebookResponse = new FacebookResponse();
        $oEntry = new Entry();
        $oMessaging = new Messaging();
        $oSender = new User();
        $oFacebookResponse->setObject($aRequest['object']);
        $oFacebookResponse->setEntry($aRequest['entry']);
        $oEntry->setId($aRequest['entry']['id']);
        $oEntry->setTime($aRequest['entry']['time']);
        $oEntry->setMessaging($aRequest['entry']['messaging']);
        $oSender->setId($aRequest['entry']['messaging']['recipient']['id']);
        $oMessaging->setSender($oSender);
        $oSender->setId($aRequest['entry']['messaging']['sender']['id']);
        $oMessaging->setSender($oSender);
        return $oFacebookResponse;
    }
}
