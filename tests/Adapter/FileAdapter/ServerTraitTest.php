<?php namespace AdammBalogh\KeyValueStore\Adapter;

use AdammBalogh\KeyValueStore\AbstractTestCase;
use AdammBalogh\KeyValueStore\KeyValueStore;
use Flintstone\Flintstone;
use org\bovigo\vfs\vfsStream;

class ServerTraitTest extends AbstractTestCase
{
    public function testFlush()
    {
        $this->kvs->set('key', 'value');

        $this->assertTrue($this->kvs->has('key'));

        $this->kvs->flush();

        $this->assertFalse($this->kvs->has('key'));
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\InternalException
     */
    public function testFlushWithNotReadableDatabase()
    {
        $flintstoneDb = Flintstone::load('okke', ['dir' => vfsStream::url('root')]);
        $kvs = new KeyValueStore(new FileAdapter($flintstoneDb));

        chmod(vfsStream::url('root/okke.dat'), 0500);

        $kvs->flush();
    }
}
