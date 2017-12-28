<?php

namespace Infakt\ClientBundle\DataCollector;

use Infakt\ClientBundle\Client\DataCollectorClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class ClientDataCollector extends DataCollector
{
    public function __construct(DataCollectorClient $client)
    {
        $this->data = $client->getCollectedData();
    }

    public function getData()
    {
        return $this->data;
    }

    public function getTotalTime()
    {
        $time = 0;

        foreach ($this->data as $data) {
            $time += $data['responseTime'];
        }

        return $time;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        $this->data = [];
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return 'app.infakt_collector';
    }
}
