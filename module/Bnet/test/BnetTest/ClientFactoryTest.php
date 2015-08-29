<?php

namespace BnetTest;

use Bnet\ClientFactory;
use Bnet\Region;
use Zend\Cache\StorageFactory;

class ClientFactoryTest extends \PHPUnit_Framework_TestCase {

    public function testGetCache() {
        $pool = StorageFactory::adapterFactory('memory ', array('ttl' => 100));
        $factory = new ClientFactory('apikey', $pool);
        $this->assertSame($pool, $factory->getCache());
    }

    public function testDefaultCache() {
        $factory = new ClientFactory('apikey');
        $this->assertInstanceOf('Zend\Cache\Storage\StorageInterface', $factory->getCache());
    }

    public function testSetCache() {
        $pool = StorageFactory::adapterFactory('memory ', array('ttl' => 100));
        $factory = new ClientFactory('apikey');
        $factory->setCache($pool);
        $this->assertSame($pool, $factory->getCache());
    }

    public function testDiablo() {
        $pool = StorageFactory::adapterFactory('memory ', array('ttl' => 100));
        $factory = new ClientFactory('apikey', $pool);
        $this->assertInstanceOf('Bnet\Diablo\Client', $factory->diablo(new Region(Region::EUROPE)));
    }

    public function testStarcraft() {
        $pool = StorageFactory::adapterFactory('memory ', array('ttl' => 100));
        $factory = new ClientFactory('apikey', $pool);
        $this->assertInstanceOf('Bnet\Starcraft\Client', $factory->starcraft(new Region(Region::EUROPE)));
    }

    public function testWarcraft() {
        $pool = StorageFactory::adapterFactory('memory ', array('ttl' => 100));
        $factory = new ClientFactory('apikey', $pool);
        $this->assertInstanceOf('Bnet\Warcraft\Client', $factory->warcraft(new Region(Region::EUROPE)));
    }

}
