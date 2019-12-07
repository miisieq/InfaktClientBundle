<?php

declare(strict_types=1);

namespace Infakt\ClientBundle\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;

/**
 * Extended \GuzzleHttp\Client which collects information about requests.
 */
class DataCollectorClient extends GuzzleClient
{
    /**
     * @var array
     */
    protected $requests = [];

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request($method, $uri = '', array $options = []): ResponseInterface
    {
        $startTime = microtime(true);

        try {
            $response = parent::request($method, $uri, $options);

            $this->collectRequest(
                $method,
                $uri,
                $response->getStatusCode(),
                (int) round((microtime(true) - $startTime) * 1000, 0),
                $response->getBody()->getContents()
            );

            $response->getBody()->rewind();

            return $response;
        } catch (BadResponseException $e) {
            $this->collectRequest(
                $method,
                $uri,
                $e->getResponse()->getStatusCode(),
                (int) round((microtime(true) - $startTime) * 1000, 0),
                $e->getResponse()->getBody()->getContents()
            );

            throw $e;
        }
    }

    /**
     * @return array
     */
    public function getCollectedData(): array
    {
        return $this->requests;
    }

    /**
     * Collect request and response data.
     *
     * @param string $requestMethod
     * @param string$requestUri
     * @param int    $responseCode
     * @param int    $responseTime
     * @param string $responseBody
     */
    protected function collectRequest(
        string $requestMethod,
        string $requestUri,
        int $responseCode,
        int $responseTime,
        string $responseBody
    ): void {
        $this->requests[] = [
            'requestMethod' => $requestMethod,
            'requestUri' => $requestUri,
            'responseCode' => $responseCode,
            'responseTime' => $responseTime,
            'responseBody' => $responseBody,
        ];
    }
}
