<?php namespace AdammBalogh\KeyValueStore\Adapter\FileAdapter;

use AdammBalogh\KeyValueStore\Exception\NotImplementedException;
use AdammBalogh\KeyValueStore\Exception\InternalException;
use Flintstone\FlintstoneException;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
trait KeyTrait
{
    use ClientTrait;

    /**
     * @param string $key
     *
     * @return bool True if the deletion was successful, false if it was unsuccessful.
     *
     * @throws InternalException
     */
    public function delete($key)
    {
        try {
            return $this->getClient()->delete($key);
        } catch (FlintstoneException $e) {
            throw new InternalException('', 0, $e);
        }
    }

    /**
     * @param string $key
     * @param int $seconds
     *
     * @throws NotImplementedException
     */
    public function expire($key, $seconds)
    {
        throw new NotImplementedException();
    }

    /**
     * @param string $key
     * @param int $timestamp
     *
     * @throws NotImplementedException
     */
    public function expireAt($key, $timestamp)
    {
        throw new NotImplementedException();
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return $this->getClient()->getKeys();
    }

    /**
     * Returns the remaining time to live of a key that has a timeout.
     *
     * @param string $key
     *
     * @throws NotImplementedException
     */
    public function getTtl($key)
    {
        throw new NotImplementedException();
    }

    /**
     * @param string $key
     *
     * @return bool True if the key does exist, false if the key does not exist.
     *
     * @throws InternalException
     */
    public function has($key)
    {
        try {
            return $this->getClient()->get($key) === false ? false : true;
        } catch (FlintstoneException $e) {
            throw new InternalException('', 0, $e);
        }
    }

    /**
     * Remove the existing timeout on key, turning the key from volatile (a key with an expire set)
     * to persistent (a key that will never expire as no timeout is associated).
     *
     * @param string $key
     *
     * @throws NotImplementedException
     */
    public function persist($key)
    {
        throw new NotImplementedException();
    }
}
