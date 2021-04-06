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
    ) {
    }

    /**
     * @param Feature[] $features
     */
    public function store(array $features): bool
    {
        foreach ($features as $feature) {
            $a = (array)$feature;
            $now = new \DateTimeImmutable('now', new \DateTimeZone('utc'));
            $a['lastSeen'] = $now->format(DATE_ISO8601);
            $a['firstSeen'] = $now->format(DATE_ISO8601);
            $id = $feature->hashId();

            $this->elastic->update([
                'index'  => 'ficury',
                'id'     => $id,
                'body'   => [
                    'script' => [
                        'lang'   => 'painless',
                        'source' => 'ctx._source.lastSeen = params.now',
                        'params' => [
                            'now' => $now->format(DATE_ISO8601)
                        ]
                    ],
                    'upsert' => $a
                ]
            ]);
        }

        return true;
    }
}