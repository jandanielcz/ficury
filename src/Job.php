<?php


namespace Ficury;


use Psr\Log\LoggerInterface;

abstract class Job
{
    public function __construct(
        protected LoggerInterface $logger
    ) {}

    public abstract function run();
}