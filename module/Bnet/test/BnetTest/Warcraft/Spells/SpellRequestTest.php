<?php
namespace BnetTest\Warcraft;

use BnetTest\TestClient;
use Bnet\Warcraft\Spells\SpellRequest;

class SpellRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testFind()
    {
        $request  = new SpellRequest(new TestClient('wow'));
        $response = $request->find(8056);

        $this->assertInstanceOf('\Bnet\Warcraft\Spells\SpellEntity', $response);
        $this->assertSame(8056, $response->id);
    }

    public function testFindInvalidId()
    {
        $request  = new SpellRequest(new TestClient('wow'));
        $response = $request->find('invalid');

        $this->assertNull($response);
    }
}
