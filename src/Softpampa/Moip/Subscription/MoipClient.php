<?php

namespace Softpampa\Moip\Subscription;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Softpampa\Moip\Subscription\Contracts\MoipHttpClient;

/**
 * Class MoipClient.
 */
class MoipClient implements MoipHttpClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Api Token.
     *
     * @var string
     */
    protected $apiToken;

    /**
     * Api Key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Ambiente da API.
     *
     * @var string
     */
    protected $environment = MoipHttpClient::SANDBOX;

    /**
     * Versão da API.
     *
     * @var string
     */
    protected $apiVersion = 'v1';

    /**
     * Url da API.
     *
     * @var string
     */
    protected $apiUrl = 'https://{environment}.moip.com.br';

    protected $response = [];

    protected $requestOptions = [];

    /**
     * Moip.
     *
     * @param $apiToken
     * @param $apiKey
     * @param string $environment
     */
    public function __construct($apiToken, $apiKey, $environment = MoipHttpClient::PRODUCTION)
    {
        $this->setCredential(['token' => $apiToken, 'key' => $apiKey]);
        $this->setEnvironment($environment);

        $base_uri = str_replace('{environment}', $this->environment, $this->apiUrl);
        $this->client = new Client(['base_uri' => $base_uri, 'http_errors' => false]);

        $this->requestOptions = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode("{$this->apiToken}:{$this->apiKey}"),
            ],
        ];
    }

    /**
     * Define as credenciais de acesso a API.
     *
     * @param array $credentials
     *
     * @return $this
     */
    public function setCredential($credentials = [])
    {
        $this->apiKey = $credentials['key'];
        $this->apiToken = $credentials['token'];

        return $this;
    }

    /**
     * Define o ambiente a ser utilizado.
     *
     * @param $environment
     *
     * @return $this
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * Retorna o ambiente atual
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Retorna uma intância do Client Http.
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Retorna a versão da API.
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * Retoran a URL da API
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * Executa uma requisição.
     *
     * @param string $url
     * @param array  $options
     *
     * @return void
     */
    protected function request($method, $url, $options = [])
    {
        $response = $this->client->request($method, $url, $this->getOptions($options));

        $this->response['http_code'] = $response->getStatusCode();
        $this->response['content'] = $response->getBody()->getContents();
    }

    /**
     * Retorna resultados.
     *
     * @return void
     */
    public function results() {
        return $this->response['content'];
    }

    /**
     * Verifica se há erros.
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return $this->response['http_code'] >= 400;
    }

    /**
     * Retorna erros.
     *
     * @return array
     */
    public function errors()
    {
        return json_decode($this->response['content'])->errors;
    }

    /**
     * Executa uma requisição do tipo GET.
     *
     * @param null  $url
     * @param array $options
     *
     * @throws ClientException
     *
     * @return string
     */
    public function get($url = null, $options = [])
    {
        $this->request('get', $url, $options);

        return $this;
    }

    /**
     * Executa uma requisição do tipo POST.
     *
     * @param null  $url
     * @param array $options
     *
     * @throws ClientException
     *
     * @return string
     */
    public function post($url = null, $options = [])
    {
        $this->request('post', $url, $options);

        return $this;
    }

    /**
     * Executa uma requisição do tipo PUT.
     *
     * @param null  $url
     * @param array $options
     *
     * @throws ClientException
     *
     * @return string
     */
    public function put($url = null, $options = [])
    {
        $this->request('put', $url, $options);

        return $this;

    }

    /**
     * Executa uma requisição do tipo DELETE.
     *
     * @param null  $url
     * @param array $options
     *
     * @throws ClientException
     *
     * @return string
     */
    public function delete($url = null, $options = [])
    {
        $this->request('delete', $url, $options);

        return $this;
    }


    /**
     * @param array $options
     *
     * @return array
     */
    public function getOptions($options = [])
    {
        return array_merge($this->requestOptions, $options);
    }
}
