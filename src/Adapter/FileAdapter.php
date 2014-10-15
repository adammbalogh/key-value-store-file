<?php namespace AdammBalogh\KeyValueStore\Adapter;

use AdammBalogh\KeyValueStore\Adapter\FileAdapter\ClientTrait;
use AdammBalogh\KeyValueStore\Adapter\FileAdapter\KeyTrait;
use AdammBalogh\KeyValueStore\Adapter\FileAdapter\ValueTrait;
use AdammBalogh\KeyValueStore\Adapter\FileAdapter\ServerTrait;
use Flintstone\FlintstoneDB;

class FileAdapter extends AbstractAdapter
{
    use ClientTrait, KeyTrait, ValueTrait, ServerTrait {
        ClientTrait::getClient insteadof KeyTrait;
        ClientTrait::getClient insteadof ValueTrait;
        ClientTrait::getClient insteadof ServerTrait;
    }

    /**
     * @var \Flintstone\FlintstoneDB
     */
    protected $client;

    /**
     * @param FlintstoneDB $client
     */
    public function __construct(FlintstoneDB $client)
    {
        $this->client = $client;
    }
}
