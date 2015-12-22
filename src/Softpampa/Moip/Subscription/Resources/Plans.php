<?php

namespace Softpampa\Moip\Subscription\Resources;

use GuzzleHttp\Exception\ClientException;
use Softpampa\Moip\Subscription\Contracts\MoipHttpClient;
use Softpampa\Moip\Subscription\ResourceUtils;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Plans.
 */
class Plans
{
    use ResourceUtils;

    const BASE_PATH = 'assinaturas/{version}/{resource}';
    const RESOURCE = 'plans';

    /**
     * @var MoipHttpClient
     */
    protected $client;

    public function __construct(MoipHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * Criar um plano.
     *
     * @param array $data
     * @param array $options
     *
     * @throws ClientException
     *
     * @return ResponseInterface
     */
    public function create(array $data, array $options = [])
    {
        $url = $this->interpolate($this->client->getApiUrl() . '/' . self::BASE_PATH, [
            'environment' => $this->client->getEnvironment(),
            'version' => $this->client->getApiVersion(),
            'resource' => self::RESOURCE,
        ]);

        $options = array_merge($options, ['body' => json_encode($data)]);

        return $this->client->post($url, $options);
    }

    /**
     * Listar todos os planos.
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
     * Consultar detalhes de um plano.
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
            $find = $this->client->get($url, $options);
        } catch (ClientException $e) {
            $find = [];
        }

        return $find;
    }

    /**
     * Alterar um plano.
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
     * Ativar um plano.
     *
     * @param $code
     * @param array $options
     *
     * @throws ClientException
     *
     * @return ResponseInterface
     */
    public function active($code, array $options = [])
    {
        return $this->toogleActive($code, 'activate', $options);
    }

    /**
     * Desativar um plano.
     *
     * @param $code
     * @param array $options
     *
     * @throws ClientException
     *
     * @return ResponseInterface
     */
    public function deactivate($code, array $options = [])
    {
        return $this->toogleActive($code, 'inactivate', $options);
    }

    /**
     * Ativar ou desativar um plano.
     *
     * @param $code
     * @param $status [activate, inactivate]
     * @param array $options
     *
     * @throws ClientException
     *
     * @return ResponseInterface
     */
    protected function toogleActive($code, $status, array $options = [])
    {
        $url = $this->interpolate($this->client->getApiUrl() . '/' . self::BASE_PATH.'/{code}/{status}', [
            'environment' => $this->client->getEnvironment(),
            'version' => $this->client->getApiVersion(),
            'resource' => self::RESOURCE,
            'code' => $code,
            'status' => $status,
        ]);

        return $this->client->put($url, $options);
    }
}
