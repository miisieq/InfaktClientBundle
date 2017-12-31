<?php

namespace Infakt\ClientBundle\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;

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
    public function request($method, $uri = '', array $options = [])
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

            $e->getResponse()->getBody()->rewind();

            return $e->getResponse();
        }
    }

    /**
     * @return array
     */
    public function getCollectedData()
    {
        return $this->requests;
    }

    /**
     * Collect request and response data.
     *
     * @param $requestMethod
     * @param $requestUri
     * @param $responseCode
     * @param $responseTime
     * @param $responseBody
     */
    protected function collectRequest($requestMethod, $requestUri, $responseCode, $responseTime, $responseBody)
    {
        $this->requests[] = [
            'requestMethod' => $requestMethod,
            'requestUri' => $requestUri,
            'responseCode' => $responseCode,
            'responseTime' => $responseTime,
            'responseBody' => $responseBody,
        ];
    }
}
