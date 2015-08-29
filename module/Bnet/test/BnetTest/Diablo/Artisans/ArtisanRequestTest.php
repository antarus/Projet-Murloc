<?php
namespace BnetTest\Diablo\Artisans;

use BnetTest\TestClient;
use Bnet\Diablo\Artisans\ArtisanRequest;

class ArtisanRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testFind()
    {
        $request  = new ArtisanRequest(new TestClient('d3'));
        $response = $request->find('mystic');

        $this->assertInstanceOf('\Bnet\Diablo\Artisans\ArtisanEntity', $response);
        $this->assertSame('mystic', $response->slug);
    }

    public function testFindInvalidId()
    {
        $request  = new ArtisanRequest(new TestClient('d3'));
        $response = $request->find('invalid');

        $this->assertNull($response);
    }
}
