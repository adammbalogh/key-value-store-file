<?php namespace AdammBalogh\KeyValueStore\Adapter;

use AdammBalogh\KeyValueStore\AbstractTestCase;
use AdammBalogh\KeyValueStore\KeyValueStore;
use Flintstone\Flintstone;
use org\bovigo\vfs\vfsStream;

class FileAdapterServerTest extends AbstractTestCase
{
    public function testFlush()
    {
        $this->kvs->set('key', 'value');
        $this->kvs->set('key1', 'value1');

        $this->assertCount(2, $this->kvs->getKeys());

        $this->kvs->flush();

        $this->assertCount(0, $this->kvs->getKeys());
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
