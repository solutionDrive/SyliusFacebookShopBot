<?php
/**
 * Created by PhpStorm.
 * User: it
 * Date: 14.10.17
 * Time: 14:28
 */

namespace SyliusConnection\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\VarDumper\VarDumper;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $result = [];
        $client = new Client();
        $taxonsResponse = $client->request('GET', 'https://demo.sylius.org/shop-api/taxons');
        if($taxonsResponse->getStatusCode() === 200) {
            $content = $taxonsResponse->getBody();
            $contentList = (current(\json_decode($content->getContents(), true)));
            foreach($contentList['children'] as $children) {
                $result[$children['slug']] = $children['description'];
            }
        }
        return $this->json($result);
    }
}