<?php namespace AdammBalogh\KeyValueStore\Adapter\FileAdapter;

trait ClientTrait
{
    /**
     * @return \Flintstone\FlintstoneDB
     */
    public function getClient()
    {
        return $this->client;
    }
}
