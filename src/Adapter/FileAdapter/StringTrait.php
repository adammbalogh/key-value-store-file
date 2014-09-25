<?php namespace AdammBalogh\KeyValueStore\Adapter\FileAdapter;

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
        $storedValue = $this->get($key);
        if (!$this->isInteger($storedValue)) {
            throw new \Exception('The stored value is not an integer.');
        }

        $this->set($key, (string)($storedValue - $decrement));

        return $storedValue - $decrement;
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
        $storedValue = $this->getClient()->get($key);
        if ($storedValue === false) {
            throw new KeyNotFoundException($key);
        }

        return $storedValue;
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
        if (!$this->isInteger($storedValue)) {
            throw new \Exception('The stored value is not an integer.');
        }

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
        $storedValue = $this->getClient()->get($key);
        if ($storedValue !== false) {
            return false;
        }

        return $this->set($key, $value);
    }

    /**
     * @param mixed $number
     *
     * @return bool
     */
    private function isInteger($number)
    {
        if (is_numeric($number) && is_integer($number + 0)) {
            return true;
        }
        return false;
    }
}
