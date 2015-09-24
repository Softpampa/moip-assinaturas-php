<?php namespace Softpampa\Moip\Subscription\Resources;

use GuzzleHttp\Exception\ClientException;
use Softpampa\Moip\Subscription\Contracts\MoipHttpClient;
use Softpampa\Moip\Subscription\ResourceUtils;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Payments
 * @package Softpampa\Moip\Subscription\Resources
 */
class Payments {

    use ResourceUtils;

    const BASE_PATH = "assinaturas/{version}/{resource}";
    const RESOURCE  = "payments";

    /**
     * @var MoipHttpClient
     */
    protected $client;

    /**
     * @param MoipHttpClient $client
     */
    public function __construct(MoipHttpClient $client){
        $this->client = $client;
    }

    /**
     * Consultar detalhes de um pagamento
     *
     * @param $code
     * @param array $options
     * @throws ClientException
     * @return ResponseInterface
     */
    public function find($code, array $options = []){

        $url = $this->interpolate( self::BASE_PATH."/{code}", [
            'version'   => $this->client->getApiVersion(),
            'resource'  => self::RESOURCE,
            'code'      => $code
        ]);

        return $this->client->get($url, $options);
    }

}