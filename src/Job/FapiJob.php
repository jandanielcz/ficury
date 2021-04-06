<?php


namespace Ficury\Job;


use Ficury\Downloader\FapiDownloader;
use Ficury\Extractor\FapiExtractor;
use Ficury\Feature;
use Ficury\Index;
use Ficury\Job;
use Psr\Log\LoggerInterface;

class FapiJob extends Job
{

    protected string $url = 'https://fapi.cz/jak-to-funguje/';
    protected string $product = 'fapi';
    protected string $lang = 'cs';



    public function __construct(
        protected LoggerInterface $logger,
        protected FapiDownloader $downloader,
        protected FapiExtractor $extractor,
        protected Index $index
    )
    {
        parent::__construct($logger);
    }

    public function run()
    {
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
    }
}