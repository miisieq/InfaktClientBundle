<?php

declare(strict_types=1);

namespace Infakt\ClientBundle\DataCollector;

use Infakt\ClientBundle\Client\DataCollectorClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

/**
 * Class ClientDataCollector.
 */
class ClientDataCollector extends DataCollector
{
    /**
     * ClientDataCollector constructor.
     *
     * @param DataCollectorClient $client
     */
    public function __construct(DataCollectorClient $client)
    {
        $this->data = $client->getCollectedData();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getTotalTime(): int
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
    public function collect(Request $request, Response $response, \Exception $exception = null): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): void
    {
        $this->data = [];
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName(): string
    {
        return 'app.infakt_collector';
    }
}
