<?php namespace AdammBalogh\KeyValueStore;

use org\bovigo\vfs\vfsStream;
use Flintstone\Flintstone;
use AdammBalogh\KeyValueStore\Adapter\FileAdapter;

abstract class AbstractKvsFileTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var KeyValueStore
     */
    protected $kvs;
    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected static $rootDir;
    /**
     * @var \Flintstone\FlintstoneDB $flintstoneDb
     */
    protected $flintstoneDb;

    public static function setUpBeforeClass()
    {
        static::$rootDir = vfsStream::setup('root');
    }

    public function setUp()
    {
        $this->flintstoneDb = Flintstone::load('testDb', ['dir' => vfsStream::url('root')]);

        $this->kvs = new KeyValueStore(new FileAdapter($this->flintstoneDb));
    }

    public function tearDown()
    {
        $this->flintstoneDb->flush();
        Flintstone::unload('testDb');
        unset($this->kvs);
    }
}
