<?php namespace AdammBalogh\KeyValueStore\Adapter\FileAdapter;

trait ServerTrait
{
    use ClientTrait;

    /**
     * Removes all keys.
     *
     * @return void
     *
     * @throws \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function flush()
    {
        $this->getClient()->flush();
    }
}
