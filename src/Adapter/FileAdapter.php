<?php namespace AdammBalogh\KeyValueStore\Adapter;

use AdammBalogh\KeyValueStore\Adapter\FileAdapter\ClientTrait;
use AdammBalogh\KeyValueStore\Adapter\FileAdapter\KeyTrait;
use AdammBalogh\KeyValueStore\Adapter\FileAdapter\ServerTrait;
use AdammBalogh\KeyValueStore\Adapter\FileAdapter\StringTrait;
use Flintstone\FlintstoneDB;

class FileAdapter extends AbstractAdapter
{
    use ClientTrait, KeyTrait, StringTrait, ServerTrait {
        ClientTrait::getClient insteadof KeyTrait;
        ClientTrait::getClient insteadof StringTrait;
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
