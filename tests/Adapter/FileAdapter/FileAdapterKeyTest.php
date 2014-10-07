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

    public function testExpire()
    {
        $this->kvs->set('key', 'value');
        $this->assertTrue($this->kvs->expire('key', 1));

        $this->assertTrue($this->kvs->has('key'));

        sleep(3);

        $this->assertFalse($this->kvs->has('key'));
    }

    public function testExpireWithNotExistedKey()
    {
        $this->assertFalse($this->kvs->expire('key', 1));
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

    public function testGetTtl()
    {
        $this->kvs->set('key', 'value');
        $this->kvs->expire('key', 10);

        $this->assertGreaterThan(0, $this->kvs->getTtl('key'));
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function testGetTtlOnPersistentKey()
    {
        $this->kvs->set('key', 'value');

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

    public function testPersist()
    {
        $this->kvs->set('key', 'value');
        $this->kvs->expire('key', 1);

        $this->assertTrue($this->kvs->persist('key'));
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function testPersistWithPersistentKey()
    {
        $this->kvs->set('key', 'value');

        $this->assertTrue($this->kvs->persist('key'));
    }

    public function testPersistWithNotExistingKey()
    {
        $this->assertFalse($this->kvs->persist('key'));
    }

    public function testPersistWithExpiredKey()
    {
        $this->kvs->set('key', 'value');
        $this->kvs->expire('key', 0);

        $this->assertFalse($this->kvs->persist('key'));
    }
}
