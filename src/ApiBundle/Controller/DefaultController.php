<?php

namespace ApiBundle\Controller;

use ApiBundle\Models\Entry;
use ApiBundle\Models\FacebookResponse;
use ApiBundle\Models\Messaging;
use ApiBundle\Models\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        $mode = $request->get('hub_mode');
        $challenge = $request->get('hub_challenge');
        $token = $request->get('hub_verify_token');

        if ($mode === 'subscribe' && $token === "SyliusHackerton") {
            return $this->json(['success' => false]);
        }

        return new Response("value=$challenge", 200);
    }

    /**
     * @param Request $request
     */
    public function receiveAction(Request $request)
    {
        // @todo parse this shit
        return $this->json([]);
    }
}
