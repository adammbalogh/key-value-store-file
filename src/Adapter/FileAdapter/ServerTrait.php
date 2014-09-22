<?php namespace AdammBalogh\KeyValueStore\Adapter\FileAdapter;

use AdammBalogh\KeyValueStore\Exception\InternalException;
use Flintstone\FlintstoneException;

trait ServerTrait
{
    use ClientTrait;

    /**
     * @return bool True if the persist was success, false if the persis was unsuccessful.
     *
     * @throws InternalException
     */
    public function flush()
    {
        try {
            return $this->client->flush();
        } catch (FlintstoneException $e) {
            throw new InternalException('', 0, $e);
        }
    }
}
