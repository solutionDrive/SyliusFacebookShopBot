<?php

namespace ApiBundle\Controller;

use ApiBundle\Models\Entry;
use ApiBundle\Models\FacebookResponse;
use ApiBundle\Models\Messaging;
use ApiBundle\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Doctrine\Common\Util\Debug;
use Symfony\Component\Config\Definition\Exception\Exception;
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
     * @todo fix that shitty mess x)
     */
    protected function sendMessage($aRequest)
    {
        $logger = $this->get('logger');
        $pageMessage = "";
        $shop = $this->get('api.taxonsproducts');
        $facebook = $this->get('api.facebook');
        $senderId = $aRequest['entry'][0]['messaging'][0]['sender']['id'];
        $receiverId = $aRequest['entry'][0]['messaging'][0]['recipient']['id'];
        $userMessage = $aRequest['entry'][0]['messaging'][0]['message']['text'];

        if ($senderId === self::PAGE_ID) {
            return;
        }

        try {
            $aProducts = $shop->fetchItems($userMessage);
        } catch (\Exception $exception) {
            $aProducts = [];
        }
        $logger->error(var_export($aProducts, true));

        if (empty($aProducts)) {
            $pageMessage = "i did not found any " . $userMessage;
            $facebook->sendMessage($pageMessage, $receiverId, $senderId);
            return;
        }

        $iMaxProducts = 4;
        $iCounter = 0;
        foreach ($aProducts as $key => $item) {
            if ($iCounter >= $iMaxProducts) {
                break;
            }
            $iCounter++;
            try {
                $facebook->sendMessage($item['name'], $receiverId, $senderId);
                $facebook->sendAttachment($item['image'], $receiverId, $senderId);
                sleep(0.1);
            } catch (ClientException $exception) {
                continue;
            }
        }
    }
}
