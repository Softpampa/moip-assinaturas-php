<?php

namespace Softpampa\Moip\Subscription\Resources;

use GuzzleHttp\Exception\ClientException;
use Softpampa\Moip\Subscription\Contracts\MoipHttpClient;
use Softpampa\Moip\Subscription\ResourceUtils;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Preferences.
 */
class Preferences
{
    use ResourceUtils;

    const BASE_PATH = 'assinaturas/{version}/{resource}';
    const RESOURCE = 'users/preferences';

    /**
     * @var MoipHttpClient
     */
    protected $client;

    public function __construct(MoipHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * Configurar preferências de notificação.
     *
     * @param array $data
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function setPreferences(array $data, array $options = [])
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
     * Criar regras de retentativas automáticas.
     *
     * @param array $data
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function setPreferencesRetry(array $data, array $options = [])
    {
        $url = $this->interpolate($this->client->getApiUrl() . '/' . self::BASE_PATH, [
            'environment' => $this->client->getEnvironment(),
            'version' => $this->client->getApiVersion(),
            'resource' => self::RESOURCE,
        ]);

        $options = array_merge($options, ['body' => json_encode($data)]);

        return $this->client->post($url, $options);
    }
}
