<?php

namespace Softpampa\Moip\Subscription\Resources;

use GuzzleHttp\Exception\ClientException;
use Softpampa\Moip\Subscription\Contracts\MoipHttpClient;
use Softpampa\Moip\Subscription\ResourceUtils;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Invoices.
 */
class Invoices
{
    use ResourceUtils;

    const BASE_PATH = 'assinaturas/{version}/{resource}';
    const RESOURCE = 'invoices';

    /**
     * @var MoipHttpClient
     */
    protected $client;

    public function __construct(MoipHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * Consultar detalhes de uma fatura.
     *
     * @param $code
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function find($code, array $options = [])
    {
        $url = $this->interpolate($this->client->getApiUrl() . '/' . self::BASE_PATH.'/{code}', [
            'environment' => $this->client->getEnvironment(),
            'version' => $this->client->getApiVersion(),
            'resource' => self::RESOURCE,
            'code' => $code,
        ]);

        return $this->client->get($url, $options);
    }

    /**
     * Listar todos os pagamentos de uma fatura.
     *
     * @param $code
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function payments($code, array $options = [])
    {
        $url = $this->interpolate($this->client->getApiUrl() . '/' . self::BASE_PATH.'/{code}/payments', [
            'environment' => $this->client->getEnvironment(),
            'version' => $this->client->getApiVersion(),
            'resource' => self::RESOURCE,
            'code' => $code,
        ]);

        return $this->client->get($url, $options);
    }

    /**
     * Retentar um pagamento.
     *
     * @param $code
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function retryPayment($code, array $options = [])
    {
        $url = $this->interpolate($this->client->getApiUrl() . '/' . self::BASE_PATH.'/{code}/payments', [
            'environment' => $this->client->getEnvironment(),
            'version' => $this->client->getApiVersion(),
            'resource' => self::RESOURCE,
            'code' => $code,
        ]);

        return $this->client->get($url, $options);
    }
}
