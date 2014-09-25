<?php namespace AdammBalogh\KeyValueStore\Adapter;

use AdammBalogh\KeyValueStore\AbstractTestCase;

class FileAdapterStringTest extends AbstractTestCase
{
    public function testAppend()
    {
        $this->kvs->set('key', 'value');
        $this->kvs->append('key', '-appended');

        $this->assertEquals('value-appended', $this->kvs->get('key'));
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\KeyNotFoundException
     */
    public function testAppendWithKeyNotFound()
    {
        $this->kvs->append('key', '-appended');
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function testAppendWithHugeKey()
    {
        $this->kvs->append(str_repeat('a', 1500), 'appended');
    }

    public function testDecrement()
    {
        $this->kvs->set('key', '1');
        $this->kvs->decrement('key');

        $this->assertEquals(0, $this->kvs->get('key'));
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function testDecrementByNotInteger()
    {
        $this->kvs->set('key', '10.01');
        $this->kvs->decrementBy('key', 5);
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function testDecrementWithHugeKey()
    {
        $this->kvs->decrementBy(str_repeat('a', 1500), 5);
    }

    public function testGet()
    {
        $this->kvs->set('key', '1773');

        $this->assertEquals('1773', $this->kvs->get('key'));
    }

    public function testGetValueLength()
    {
        $this->kvs->set('key', 'this is a text');

        $this->assertEquals(strlen('this is a text'), $this->kvs->getValueLength('key'));
    }

    public function testIncrement()
    {
        $this->kvs->set('key', '1');
        $this->kvs->increment('key');

        $this->assertEquals(2, $this->kvs->get('key'));
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function testIntegerByNotInteger()
    {
        $this->kvs->set('key', '10.01');
        $this->kvs->incrementBy('key', 5);
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function testIncrementByWithHugeKey()
    {
        $this->kvs->incrementBy(str_repeat('a', 1500), 5);
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function testSetWithHugeKey()
    {
        $this->kvs->set(str_repeat('a', 1500), 'value');
    }

    public function testSetIfNotExists()
    {
        $this->assertTrue($this->kvs->setIfNotExists('key', 'value'));
    }

    public function testSetIfNotExistsWithAlreadyExistsKey()
    {
        $this->kvs->set('key', 'value');
        $this->assertFalse($this->kvs->setIfNotExists('key', 'value'));
    }
}
