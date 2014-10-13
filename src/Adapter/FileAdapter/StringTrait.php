<?php namespace AdammBalogh\KeyValueStore\Adapter\FileAdapter;

use AdammBalogh\KeyValueStore\Adapter\Util;
use AdammBalogh\KeyValueStore\Exception\KeyNotFoundException;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
trait StringTrait
{
    use ClientTrait;

    /**
     * @param string $key
     * @param string $value
     *
     * @return int The length of the string after the append operation.

     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function append($key, $value)
    {
        $storedValue = $this->get($key);
        $this->set($key, $storedValue . $value);

        return strlen($storedValue . $value);
    }

    /**
     * @param string $key
     *
     * @return int The value of key after the decrement
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function decrement($key)
    {
        return $this->decrementBy($key, 1);
    }

    /**
     * @param string $key
     * @param int $decrement
     *
     * @return int The value of key after the decrement
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function decrementBy($key, $decrement)
    {
        return $this->incrementBy($key, -$decrement);
    }

    /**
     * @param string $key
     *
     * @return string The value of the key
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
     * @param string $key
     *
     * @return int
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function getValueLength($key)
    {
        return strlen($this->get($key));
    }

    /**
     * @param string $key
     *
     * @return int The value of key after the increment
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function increment($key)
    {
        return $this->incrementBy($key, 1);
    }

    /**
     * @param string $key
     * @param int $increment
     *
     * @return int The value of key after the increment
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function incrementBy($key, $increment)
    {
        $storedValue = $this->get($key);

        Util::checkInteger($storedValue);

        $this->set($key, (string)($storedValue + $increment));

        return $storedValue + $increment;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool True if the set was successful, false if it was unsuccessful
     *
     * @throws \Exception
     */
    public function set($key, $value)
    {
        return $this->getClient()->set($key, $value);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool True if the set was successful, false if it was unsuccessful
     *
     * @throws \Exception
     */
    public function setIfNotExists($key, $value)
    {
        if ($this->has($key)) {
            return false;
        }

        return $this->set($key, $value);
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
            $this->delete($key);
            throw new KeyNotFoundException();
        }

        return $ttl;
    }
}
