<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 14.10.17
 * Time: 14:37
 */

namespace ApiBundle\Services;


use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class TaxonsProductsService
{

    const ENDPOINT = 'http://demo.sylius.org/shop-api/taxon-products/%s?channel=US_WEB';
    const IMAGE_URL = 'http://demo.sylius.org/media/cache/sylius_shop_product_large_thumbnail/%s';

    /**
     * @var ClientInterface
     */
    private $client;


    /**
     * TaxonsProductsService constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchItems(string $taxon)
    {
        $result = $this->client->request('GET', sprintf(self::ENDPOINT, $taxon));

        return $this->parseItems($result->getBody());
    }

    private function parseItems(string $body)
    {
        $json = json_decode($body);
        $result = [];
        foreach ($json->items as $item)
        {
            $result[$item->code] = [
                'name' => $item->name,
                'image' => sprintf(self::IMAGE_URL, $item->images[0]->path)
            ];

        }
        return $result;

    }

}