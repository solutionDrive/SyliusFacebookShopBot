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

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class ClientService extends Client implements ClientInterface
{

}