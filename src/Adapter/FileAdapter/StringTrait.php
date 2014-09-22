<?php namespace AdammBalogh\KeyValueStore\Adapter\FileAdapter;

use AdammBalogh\KeyValueStore\Exception\NotImplementedException;
use AdammBalogh\KeyValueStore\Exception\InternalException;
use AdammBalogh\KeyValueStore\Exception\KeyAlreadyExistsException;
use AdammBalogh\KeyValueStore\Exception\KeyNotFoundException;
use Flintstone\FlintstoneException;

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
     * @throws InternalException
     */
    public function append($key, $value)
    {
        try {
            $storedValue = $this->get($key);
            $this->set($key, $storedValue . $value);

            return strlen($storedValue . $value);

        } catch (FlintstoneException $e) {
            throw new InternalException('', 0, $e);
        }
    }

    /**
     * @param string $key
     *
     * @return int The value of key after the decrement
     *
     * @throws KeyNotFoundException
     * @throws InternalException
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
     * @throws InternalException
     */
    public function decrementBy($key, $decrement)
    {
        try {
            $storedValue = $this->get($key);
            if ( ! $this->isInteger($storedValue)) {
                throw new InternalException('The stored value is not an integer.');
            }

            $this->set($key, (string)($storedValue - $decrement));

            return $storedValue - $decrement;

        } catch (FlintstoneException $e) {
            throw new InternalException('', 0, $e);
        }
    }

    /**
     * @param string $key
     *
     * @return string The value of the key
     *
     * @throws KeyNotFoundException
     * @throws InternalException
     */
    public function get($key)
    {
        try {
            $storedValue = $this->client->get($key);
            if ($storedValue === false) {
                throw new KeyNotFoundException($key);
            }

            return $storedValue;

        } catch (FlintstoneException $e) {
            throw new InternalException('', 0, $e);
        }
    }

    /**
     * @param string $key
     *
     * @return int
     *
     * @throws KeyNotFoundException
     * @throws InternalException
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
     * @throws InternalException
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
     * @throws InternalException
     */
    public function incrementBy($key, $increment)
    {
        try {
            $storedValue = $this->get($key);
            if ( ! $this->isInteger($storedValue)) {
                throw new InternalException('The stored value is not an integer.');
            }

            $this->set($key, (string)($storedValue + $increment));

            return $storedValue + $increment;

        } catch (FlintstoneException $e) {
            throw new InternalException('', 0, $e);
        }
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool True if the set was successful, false if it was unsuccessful
     *
     * @throws InternalException
     */
    public function set($key, $value)
    {
        try {
            return $this->client->set($key, $value);
        } catch (FlintstoneException $e) {
            throw new InternalException('', 0, $e);
        }
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool True if the set was successful, false if it was unsuccessful
     *
     * @throws KeyAlreadyExistsException
     * @throws InternalException
     */
    public function setIfNotExists($key, $value)
    {
        try {
            $storedValue = $this->client->get($key);
            if ($storedValue !== false) {
                throw new KeyAlreadyExistsException($key);
            }

            return $this->set($key, $value);

        } catch (FlintstoneException $e) {
            throw new InternalException('', 0, $e);
        }
    }

    /**
     * @param mixed $number
     *
     * @return bool
     */
    private function isInteger($number)
    {
        return is_integer($number + 0);
    }
}
