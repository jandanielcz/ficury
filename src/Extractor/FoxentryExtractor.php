<?php


namespace Ficury\Extractor;


use Ficury\Feature;
use Psr\Log\LoggerInterface;
use Symfony\Component\DomCrawler\Crawler;

class FoxentryExtractor
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
        $functionsAll = $this->crawler->filter('.functions-all');
        $articles = $functionsAll->filter('article');

        $features = [];

        foreach ($articles as $article) {
            $f = new Feature();
            $article = new Crawler($article);
            $f->title = $article->filter('h4')->text();
            $f->description = $article->filter('p')->text();

            $features[] = $f;
        }

        return $features;
    }
}