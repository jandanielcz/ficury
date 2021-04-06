<?php


namespace Ficury\Job;


use Ficury\Downloader\FoxentryDownloader;
use Ficury\Extractor\FoxentryExtractor;
use Ficury\Feature;
use Ficury\Index;
use Ficury\Job;
use Psr\Log\LoggerInterface;

class FoxentryJob extends Job
{

    protected string $url = 'https://foxentry.cz/funkce/';
    protected string $product = 'foxentry';
    protected string $lang = 'cs';



    public function __construct(
        protected LoggerInterface $logger,
        protected FoxentryDownloader $downloader,
        protected FoxentryExtractor $extractor,
        protected Index $index
    )
    {
        parent::__construct($logger);
    }

    public function run()
    {
        $this->logger->info('Running...');
        $html = $this->downloader->getHtml($this->url);
        if (!$html) {
            $this->logger->critical('No HTML content from downloader.');
            exit;
        }
        $features = $this->extractor->extract($html);
        $features = array_map(function (Feature $one) {
            $one->url = $this->url;
            $one->language = $this->lang;
            $one->product = $this->product;

            return $one;
        }, $features);
        $this->logger->info(sprintf('Found %s features', count($features)));

        $this->index->store($features);

        return 1;
    }
}