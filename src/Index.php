<?php


namespace Ficury;


abstract class Index
{
    /**
     * @param Feature[] $features
     */
    abstract public function store(array $features):bool;
}