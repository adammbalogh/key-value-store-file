<?php namespace AdammBalogh\KeyValueStore\Adapter\FileAdapter;

trait ServerTrait
{
    use ClientTrait;

    /**
     * Removes all keys.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function flush()
    {
        $this->getClient()->flush();
    }
}
