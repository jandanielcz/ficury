<?php


namespace Ficury;


class Downloader
{
    protected function generateCacheKey():string
    {
        $classPart = basename(str_replace('\\', '/', get_called_class()));
        return sprintf('%s|html', $classPart);
    }
}