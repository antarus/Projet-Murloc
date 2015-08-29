<?php

namespace Bnet\Core;

use Zend\Http\Client as HttpClient;
use Zend\Http\Request;
use Bnet\Exceptions\BattleNetException;
use Bnet\Region;
use Zend\Cache\Storage\StorageInterface;

abstract class AbstractClient {

    /**
     * @var string
     */
    const VERSION = '1.0';

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var StorageInterface
     */
    protected $cache;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Region
     */
    protected $region;

    /**
     * @var Version
     */
    protected $version;

    /**
     * @param string        $apiKey
     * @param Region        $region
     * @param StorageInterface $cache
     */
    public function __construct($apiKey, Region $region, StorageInterface $cache) {
        $this->apiKey = $apiKey;
        $this->cache = $cache;
        $this->region = $region;
        //$this->cache->setNamespace(str_replace('\\', '', get_class($this)));
    }

    /**
     * @param string $url
     * @param array  $options
     *
     * @return array
     */
    public function get($url, array $options = []) {
        return $this->makeRequest($this->region->getApiHost(static::API) . $url, $options);
    }

    /**
     * @param string $url
     * @param array  $options
     *
     * @return array
     */
    public function getRawUrl($url, array $options = []) {
        return $this->makeRequest($url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     *
     * @return string
     */
    protected function getRequestKey($url, array $options) {
        return hash_hmac('md5', $url, serialize($options));
    }

    /**
     * @return string
     */
    protected function getUserAgent() {
        static $defaultAgent = '';

        if ($defaultAgent === '') {
            $defaultAgent = 'bnet/' . static::VERSION;
        }

        return $defaultAgent;
    }

    /**
     * @param ResponseInterface $response
     * @param ItemInterface     $key
     * @param array|null        $data
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    protected function handleSuccessfulResponse(\Zend\Http\Response $response, $key) {
        switch ((int) $response->getStatusCode()) {
            case 200:
                $data = json_decode($response->getBody(), true);
                if ($response->getHeaders()->has('Last-Modified') === true) {
                    $this->cache->replaceItem($key, $data);
//                    $key->set([
//                        'modified' => $response->getHeaders()->get('Last-Modified'),
//                        'json' => $data,
//                    ]);
                }
                return $data;
            case 304:
                return $this->cache->getItem($key);
                ;
            case 404:
                return null;
            default:
                throw new \RuntimeException('No support added for HTTP Status Code ' . $response->getStatusCode());
        }
    }

    /**
     * @param string $url
     * @param array  $options
     *
     * @return array
     */
    protected function makeRequest($url, array $options = []) {
        if ($this->client === null) {
            $this->client = new HttpClient();
            $adapter = new \Zend\Http\Client\Adapter\Curl();
            $adapter->setCurlOption(CURLOPT_SSL_VERIFYPEER, false);

            $this->client->setAdapter($adapter);
        }
        $key = $this->getRequestKey($url, $options);

        if ($this->cache->hasItem($key) === true) {
            $options = array_replace_recursive($options, [
                'headers' => [
                    'If-Modified-Since' => $this->cache->getMetadata($key)['mtime'],
                ],
            ]);
        }

        $options = array_replace_recursive($options, [
            'headers' => [
                'Accept' => 'application/json',
                'User-Agent' => $this->getUserAgent(),
            ],
            'query' => [
                'apikey' => $this->apiKey,
                'locale' => $this->region->getLocale(),
            ],
        ]);
        $request = new Request();
        $request->setUri($url);

        foreach ($options['query'] as $param => $value) {
            $request->getQuery()->$param = $value;
        }

        $request->getHeaders()->addHeaders($options['headers']);
        $request->setMethod(Request::METHOD_GET);

        try {
            $response = $this->client->dispatch($request);
        } catch (ClientException $exception) {
            if ($exception->getCode() === 404) {
                return null;
            }

            throw new BattleNetException($exception->getResponse()->json()['detail'], $exception->getCode());
        }
        //return json_decode($response->getBody(), true);
        return $this->handleSuccessfulResponse($response, $key);
    }

}
