<?php namespace AdammBalogh\KeyValueStore\Adapter;

use AdammBalogh\KeyValueStore\AbstractTestCase;

class FileAdapterKeyTest extends AbstractTestCase
{
    public function testDelete()
    {
        $this->kvs->set('key', 'value');
        $this->kvs->set('key1', 'value2');

        $this->assertCount(2, $this->kvs->getKeys());

        $this->kvs->delete('key1');

        $this->assertCount(1, $this->kvs->getKeys());
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function testDeleteWithWrongKey()
    {
        $this->kvs->delete(str_repeat('a', 2048));
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\NotImplementedException
     */
    public function testExpire()
    {
        $this->kvs->expire('key', 10);
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\NotImplementedException
     */
    public function testExpireAt()
    {
        $this->kvs->expireAt('key', time());
    }

    public function testGetKeysWithEmpty()
    {
        $this->assertCount(0, $this->kvs->getKeys());
    }

    public function testGetKeysWithNotEmpty()
    {
        $this->kvs->set('key', 'value');

        $this->assertCount(1, $this->kvs->getKeys());
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\NotImplementedException
     */
    public function testGetTtl()
    {
        $this->kvs->getTtl('key');
    }

    public function testHas()
    {
        $this->assertFalse($this->kvs->has('key'));

        $this->kvs->set('key', 'value');

        $this->assertTrue($this->kvs->has('key'));
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function testHasWithWrongKey()
    {
        $this->kvs->has(str_repeat('a', 2048));
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\NotImplementedException
     */
    public function testPersist()
    {
        $this->kvs->persist('key');
    }
}
