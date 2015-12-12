<?php

namespace Softpampa\Moip\Subscription\Resources;

use GuzzleHttp\Exception\ClientException;
use Softpampa\Moip\Subscription\Contracts\MoipHttpClient;
use Softpampa\Moip\Subscription\ResourceUtils;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Customers.
 */
class Customers
{
    use ResourceUtils;

    const BASE_PATH = 'assinaturas/{version}/{resource}';
    const RESOURCE = 'customers';

    /**
     * @var MoipHttpClient
     */
    protected $client;

    /**
     * @param MoipHttpClient $client
     */
    public function __construct(MoipHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * Criar um cliente.
     *
     * @param array $data
     * @param bool  $new_vault
     * @param array $options
     *
     * @throws ClientException
     *
     * @return ResponseInterface
     */
    public function create(array $data, $new_vault = false, array $options = [])
    {
        $url = $this->interpolate($this->client->getApiUrl() . '/' . self::BASE_PATH.'?new_vault={new_vault}', [
            'environment' => $this->client->getEnvironment(),
            'version' => $this->client->getApiVersion(),
            'resource' => self::RESOURCE,
            'new_vault' => $new_vault === true ? 'true' : 'false',
        ]);

        $options = array_merge($options, ['body' => json_encode($data)]);

        return $this->client->post($url, $options);
    }

    /**
     * Listar todos os clientes.
     *
     * @param array $options
     *
     * @throws ClientException
     *
     * @return ResponseInterface
     */
    public function all(array $options = [])
    {
        $url = $this->interpolate($this->client->getApiUrl() . '/' . self::BASE_PATH, [
            'environment' => $this->client->getEnvironment(),
            'version' => $this->client->getApiVersion(),
            'resource' => self::RESOURCE,
        ]);

        return $this->client->get($url, $options);
    }

    /**
     * Consultar detalhes de um cliente.
     *
     * @param $code
     * @param array $options
     *
     * @throws ClientException
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
        try {
            $find = $client->get('https://github.com/_abc_123_404');
        } catch (ClientException $e) {
            $find = [];
        }
        return $find;
    }

    /**
     * Alterar um cliente.
     *
     * @param $code
     * @param array $data
     * @param array $options
     *
     * @throws ClientException
     *
     * @return ResponseInterface
     */
    public function update($code, array $data, array $options = [])
    {
        $url = $this->interpolate($this->client->getApiUrl() . '/' . self::BASE_PATH.'/{code}', [
            'environment' => $this->client->getEnvironment(),
            'version' => $this->client->getApiVersion(),
            'resource' => self::RESOURCE,
            'code' => $code,
        ]);

        $options = array_merge($options, ['body' => json_encode($data)]);

        return $this->client->put($url, $options);
    }

    /**
     * @param $code
     * @param array $data
     * @param array $options
     *
     * @throws ClientException
     *
     * @return ResponseInterface
     */
    public function updateBillingInfo($code, array $data, array $options = [])
    {
        $url = $this->interpolate($this->client->getApiUrl() . '/' . self::BASE_PATH.'/{code}/billing_infos', [
            'environment' => $this->client->getEnvironment(),
            'version' => $this->client->getApiVersion(),
            'resource' => self::RESOURCE,
            'code' => $code,
        ]);

        $options = array_merge($options, ['body' => json_encode($data)]);

        return $this->client->put($url, $options);
    }
}
