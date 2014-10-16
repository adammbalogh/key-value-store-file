<?php namespace AdammBalogh\KeyValueStore\Adapter\FileAdapter;

use AdammBalogh\KeyValueStore\AbstractKvsFileTestCase;

class ValueTraitKvsFileTest extends AbstractKvsFileTestCase
{
    public function testGet()
    {
        $this->kvs->set('key', '1773');

        $this->assertEquals('1773', $this->kvs->get('key'));
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function testSetWithHugeKey()
    {
        $this->kvs->set(str_repeat('a', 1500), 'value');
    }

    public function testSetAndGet()
    {
        $this->assertTrue($this->kvs->set('key', 1337));
        $this->assertEquals(1337, $this->kvs->get('key'));

        $this->assertTrue($this->kvs->set('key1', ['1', '2']));
        $this->assertEquals(['1', '2'], $this->kvs->get('key1'));
    }
}
