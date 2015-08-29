<?php

namespace Bnet;

use Bnet\Diablo\Client as DiabloClient;
use Bnet\Starcraft\Client as StarcraftClient;
use Bnet\Warcraft\Client as WarcraftClient;
use Zend\Cache\StorageFactory;
use Zend\Cache\Storage\StorageInterface;

class ClientFactory {

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var StorageInterface
     */
    protected $cache;

    /**
     * @param string        $apiKey
     * @param StorageInterface $cache
     */
    public function __construct($apiKey, StorageInterface $cache = null) {
        $this->apiKey = $apiKey;

        if ($cache === null) {
            $cache = StorageFactory::adapterFactory('memory ', array('ttl' => 100));
        }

        $this->cache = $cache;
    }

    /**
     * @return StorageInterface
     */
    public function getCache() {
        return $this->cache;
    }

    /**
     * @param StorageInterface $cache
     *
     * @return void
     */
    public function setCache(StorageInterface $cache) {
        $this->cache = $cache;
    }

    /**
     * @param Region $region
     *
     * @return DiabloClient
     */
    public function diablo(Region $region) {
        return new DiabloClient($this->apiKey, $region, $this->cache);
    }

    /**
     * @param Region $region
     *
     * @return StarcraftClient
     */
    public function starcraft(Region $region) {
        return new StarcraftClient($this->apiKey, $region, $this->cache);
    }

    /**
     * @param Region $region
     *
     * @return WarcraftClient
     */
    public function warcraft(Region $region) {
        return new WarcraftClient($this->apiKey, $region, $this->cache);
    }

}
