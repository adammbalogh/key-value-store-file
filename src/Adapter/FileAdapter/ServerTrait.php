<?php namespace AdammBalogh\KeyValueStore\Adapter\FileAdapter;

trait ServerTrait
{
    use ClientTrait;

    /**
     * @return void
     *
     * @throws \Exception
     */
    public function flush()
    {
        $this->getClient()->flush();
    }
}
