<?php namespace AdammBalogh\KeyValueStore\Adapter\FileAdapter;

use AdammBalogh\KeyValueStore\AbstractKvsFileTestCase;

class KeyTraitKvsFileTest extends AbstractKvsFileTestCase
{
    public function testDelete()
    {
        $this->kvs->set('key', 'value');

        $this->assertTrue($this->kvs->has('key'));

        $this->kvs->delete('key');

        $this->assertFalse($this->kvs->has('key'));
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function testDeleteWithWrongKey()
    {
        $this->kvs->delete(str_repeat('a', 2048));
    }

    public function testDeleteExpiredKey()
    {
        $this->kvs->set('key', 'value');
        $this->kvs->expire('key', 1);

        sleep(2);

        $this->assertFalse($this->kvs->delete('key'));
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

    public function testPersistWithNonPersistentKey()
    {
        $this->kvs->set('key', 'value');

        $this->assertFalse($this->kvs->persist('key'));
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
