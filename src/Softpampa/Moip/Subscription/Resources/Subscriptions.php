<?php

namespace Softpampa\Moip\Subscription\Resources;

use GuzzleHttp\Exception\ClientException;
use Softpampa\Moip\Subscription\Contracts\MoipHttpClient;
use Softpampa\Moip\Subscription\ResourceUtils;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Subscriptions.
 */
class Subscriptions
{
    use ResourceUtils;

    const BASE_PATH = 'assinaturas/{version}/{resource}';
    const RESOURCE = 'subscriptions';

    /**
     * @var MoipHttpClient
     */
    protected $client;

    /**
     * Constructor.
     *
     * @param MoipHttpClient $client
     */
    public function __construct(MoipHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * Criar Assinatura.
     *
     * @param array $data
     * @param bool  $new_customer
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function create(array $data, $new_customer = false, array $options = [])
    {
        $url = $this->interpolate($this->client->getApiUrl() . '/' . self::BASE_PATH.'?new_customer={new_customer}', [
            'environment' => $this->client->getEnvironment(),
            'version' => $this->client->getApiVersion(),
            'resource' => self::RESOURCE,
            'new_customer' => $new_customer === true ? 'true' : 'false',
        ]);

        $options = array_merge($options, ['body' => json_encode($data)]);

        return $this->client->post($url, $options);
    }

    /**
     * Listar todas assinaturas.
     *
     * @param array $options
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
     * Consultar detalhes de uma assinatura.
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

        $response = $this->client->get($url, $options);

        if (! $response->results()) {
            $response->setError('MXC6', 'Assinatura não encontrada');
        }

        return $response;
    }

    /**
     * Alterar uma assinatura.
     *
     * @param $code
     * @param array $data
     * @param array $options
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
     * Listar todas as faturas de uma assinatura.
     *
     * @param $code
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function invoices($code, array $options = [])
    {
        $url = $this->interpolate($this->client->getApiUrl() . '/' . self::BASE_PATH.'/{code}/invoices', [
            'environment' => $this->client->getEnvironment(),
            'version' => $this->client->getApiVersion(),
            'resource' => self::RESOURCE,
            'code' => $code,
        ]);

        return $this->client->get($url, $options);
    }

    /**
     * Suspender uma Assinatura.
     *
     * @param $code
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function suspend($code, array $options = [])
    {
        return $this->toogleStatus($code, 'suspend', $options);
    }

    /**
     * Reativar uma Assinatura.
     *
     * @param $code
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function activate($code, array $options = [])
    {
        return $this->toogleStatus($code, 'activate', $options);
    }

    /**
     * Cancelar uma Assinatura.
     *
     * @param $code
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function cancel($code, array $options = [])
    {
        return $this->toogleStatus($code, 'cancel', $options);
    }

    /**
     * Suspender, reativar e cancelar uma Assinatura.
     *
     * @param $code
     * @param $status [activate, inactivate]
     * @param array $options
     *
     * @return ResponseInterface
     */
    protected function toogleStatus($code, $status, array $options = [])
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
