<?php

namespace AppBundle\Controller;

use AppBundle\Service\TaxonsProductsService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FetchTaxonProductsController extends Controller
{

    /**
     * @Route("/taxonproducts", name="taxonproducts")
     */
    public function index(Request $request)
    {
        $service = $this->container->get(TaxonsProductsService::class);
        //$service = new TaxonsProductsService(new Client());
        $result = $service->fetchItems($request->getQueryString());
        return new JsonResponse($result);
    }
}
