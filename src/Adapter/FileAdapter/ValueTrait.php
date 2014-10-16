<?php namespace AdammBalogh\KeyValueStore\Adapter\FileAdapter;

use AdammBalogh\KeyValueStore\Adapter\Util;
use AdammBalogh\KeyValueStore\Exception\KeyNotFoundException;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
trait ValueTrait
{
    use ClientTrait;

    /**
     * Gets the value of a key.
     *
     * @param string $key
     *
     * @return mixed The value of the key.
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function get($key)
    {
        $getResult = $this->getValue($key);
        $unserialized = @unserialize($getResult);

        if (Util::hasInternalExpireTime($unserialized)) {

            $this->handleTtl($key, $unserialized['ts'], $unserialized['s']);

            $getResult = $unserialized['v'];
        }

        return $getResult;
    }

    /**
     * Sets the value of a key.
     *
     * @param string $key
     * @param mixed $value Can be any of serializable data type.
     *
     * @return bool True if the set was successful, false if it was unsuccessful.
     *
     * @throws \Exception
     */
    public function set($key, $value)
    {
        return $this->getClient()->set($key, $value);
    }

    /**
     * @param string $key
     *
     * @return string
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    protected function getValue($key)
    {
        $getResult = $this->getClient()->get($key);
        if ($getResult === false) {
            throw new KeyNotFoundException($key);
        }

        return $getResult;
    }

    /**
     * If ttl is lesser or equals 0 delete key.
     *
     * @param string $key
     * @param int $expireSetTs
     * @param int $expireSec
     *
     * @return int ttl
     *
     * @throws KeyNotFoundException
     */
    protected function handleTtl($key, $expireSetTs, $expireSec)
    {
        $ttl = $expireSetTs + $expireSec - time();
        if ($ttl <= 0) {
            $this->getClient()->delete($key);
            throw new KeyNotFoundException();
        }

        return $ttl;
    }
}
