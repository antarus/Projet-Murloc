<?php
namespace BnetTest\Diablo\Items;

use BnetTest\TestClient;
use Bnet\Diablo\Items\ItemRequest;

class ItemRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testFind()
    {
        $request  = new ItemRequest(new TestClient('d3'));
        $response = $request->find('VoodooMask_206');

        $this->assertInstanceOf('\Bnet\Diablo\Items\ItemEntity', $response);
        $this->assertSame('VoodooMask_206', $response->id);
    }

    public function testFindInvalidId()
    {
        $request  = new ItemRequest(new TestClient('d3'));
        $response = $request->find('invalid');

        $this->assertNull($response);
    }
}
