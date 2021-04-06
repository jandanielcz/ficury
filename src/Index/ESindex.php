<?php


namespace Ficury\Index;


use Elasticsearch\Client;
use Ficury\Feature;
use Ficury\Index;
use Psr\Log\LoggerInterface;

class ESindex extends Index
{

    public function __construct(
        protected LoggerInterface $logger,
        protected Client $elastic
    ) {}

    public function store(array $features): bool
    {

        return true;
    }
}