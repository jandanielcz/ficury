<?php


namespace Ficury\Downloader;


use Ficury\Downloader;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class SimpleDownloader extends Downloader
{

    public function __construct(
        protected LoggerInterface $logger,
        protected Client $guzzle,
        protected CacheInterface $cache,
    ) {}

    public function getHtml($url): ?string
    {
        return $this->cache->get($this->generateCacheKey(), function(ItemInterface $item) use ($url) {
            $this->logger->info('No cache found.');
            $item->expiresAfter(60 * 5);
            return $this->download($url);
        });
    }

    protected function download($url): ?string
    {
        $req = $this->guzzle->get($url);
        if ($req->getStatusCode() !== 200) {
            $this->logger->critical(sprintf('Request returned status code %s.', $req->getStatusCode()));
            return null;
        }
        return $req->getBody();
    }
}