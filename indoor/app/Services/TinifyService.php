<?php

namespace App\Services;

use Tinify\Source;
use Tinify\Tinify;

class TinifyService
{
    public function __construct()
    {
        $this->apikey = config('tinify.api_key');
        if (! $this->apikey) {
            throw new \InvalidArgumentException('Please set TINIFY_APIKEY environment variables.');
        }
        $this->client = new Tinify;
        $this->client->setKey($this->apikey);
    }

    public function setKey($key)
    {
        $this->client->setKey($key);

        return $this;
    }

    public function getCompressionCount()
    {
        return $this->client->getCompressionCount();
    }

    public function fromFile($path)
    {
        return Source::fromFile($path);
    }

    public function fromBuffer($string)
    {
        return Source::fromBuffer($string);
    }

    public function fromUrl($string)
    {
        return Source::fromUrl($string);
    }
}
