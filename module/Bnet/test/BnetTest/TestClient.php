<?php

namespace BnetTest;

use Zend\Http\Client as HttpClient;
use Bnet\Region;
use Zend\Cache\StorageFactory;

class TestClient extends \Bnet\Core\AbstractClient {

    protected $game;

    // protected $mock;

    public function __construct($game) {
        $this->game = $game;
        //   $this->mock = new MockHandler([]);
        $this->client = new HttpClient();
        $adapter = new \Zend\Http\Client\Adapter\Curl();
        $adapter->setCurlOption(CURLOPT_SSL_VERIFYPEER, false);

        $this->client->setAdapter($adapter);

        // $this->client = new Client([
        //   'handler' => HandlerStack::create($this->mock)
        //]);
        $cache = StorageFactory::adapterFactory('memory ', array('ttl' => 100));
        parent::__construct('5nssdkuvwub25ydqzhwwznvzh8hh2ag9', new Region(Region::EUROPE), $cache);
    }

    public function get($url, array $options = []) {
        $query = (empty($options) === true) ? '' : implode('&', $options['query']);
        //$body  = getFixture($this->game, $url.'?'.$query);
        //$this->mock->append(new Response(200, [], $body));

        return $this->makeRequest($this->region->getApiHost($this->game) . $url, $options);
    }

    public function getRawUrl($url, array $options = []) {
        return $this->get($url, $options);
    }

}
