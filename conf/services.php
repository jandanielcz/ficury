<?php

$builder = new \DI\ContainerBuilder();
$c = $builder->build();

$c->set(
    \splitbrain\phpcli\PSR3CLI::class,
    function (\Psr\Container\ContainerInterface $c) {
        return new \Ficury\Cli($c);
    }
);

$c->set(
    \Psr\Log\LoggerInterface::class,
    function (\Psr\Container\ContainerInterface $c) {
        return $c->get(\splitbrain\phpcli\PSR3CLI::class);
    }
);

$c->set(
    \Symfony\Contracts\Cache\CacheInterface::class,
    function (\Psr\Container\ContainerInterface $c) {
        return new \Symfony\Component\Cache\Adapter\FilesystemAdapter();
    }
);

$c->set(
    \Ficury\Index::class,
    function (\Psr\Container\ContainerInterface $c) {
        return $c->get(\Ficury\Index\ESindex::class);
    }
);

$c->set('ES_HOST', DI\env('FICURE_ES_HOST'));

$c->set(
    \Elasticsearch\Client::class,
    function (\Psr\Container\ContainerInterface $c) {
        $builder = \Elasticsearch\ClientBuilder::create();
        $hosts = [
            $c->get('ES_HOST')
        ];
        return $builder->setHosts($hosts)->build();
    }
);

