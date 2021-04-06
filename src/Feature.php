<?php


namespace Ficury;


class Feature
{
    public string $title;
    public ?string $description;
    public string $url;
    public string $product;
    public string $language;

    public function hashId():string
    {
        $key = sprintf(
            '%s%s%s%s%s',
            $this->title,
            ($this->description ?? ''),
            $this->url,
            $this->product,
            $this->language
        );

        return sha1($key, false);
    }
}