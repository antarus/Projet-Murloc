<?php
namespace BnetTest\Core;

use Mockery;
use Bnet\Core\AbstractRequest;

class AbstractRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testAbstractRequest()
    {
        $client   = (new Mockery)->mock('\Bnet\Core\AbstractClient');
        $instance = (new Mockery)->mock('\Bnet\Core\AbstractRequest', [$client]);
        $this->assertInstanceOf('\Bnet\Core\AbstractRequest', $instance);
    }
}
