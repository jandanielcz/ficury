<?php


namespace Ficury\Extractor;


use Ficury\Feature;
use Psr\Log\LoggerInterface;
use Symfony\Component\DomCrawler\Crawler;

class FapiExtractor
{
    public function __construct(
        protected LoggerInterface $logger,
        protected Crawler $crawler
    ){}

    /**
     * @return Feature[]
     */
    public function extract(string $html): array
    {
        $this->crawler->addHtmlContent($html);
        $functionsAll = $this->crawler->filter('.features_element_container');
        $articles = $functionsAll->filter('.feature_text');

        $features = [];

        foreach ($articles as $article) {
            $f = new Feature();
            $article = new Crawler($article);
            $f->title = $article->filter('h3')->text();
            $f->description = $article->filter('div')->text();

            $features[] = $f;
        }

        return $features;
    }
}