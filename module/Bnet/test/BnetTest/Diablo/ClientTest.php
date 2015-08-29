<?php
namespace BnetTest\Diablo;

use Mockery;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testArtisans()
    {
        $client = (new Mockery)->mock('Bnet\Diablo\Client')->shouldDeferMissing();
        $this->assertInstanceOf('Bnet\Diablo\Artisans\ArtisanRequest', $client->artisans());
    }

    public function testFollowers()
    {
        $client = (new Mockery)->mock('Bnet\Diablo\Client')->shouldDeferMissing();
        $this->assertInstanceOf('Bnet\Diablo\Followers\FollowerRequest', $client->followers());
    }

    public function testItems()
    {
        $client = (new Mockery)->mock('Bnet\Diablo\Client')->shouldDeferMissing();
        $this->assertInstanceOf('Bnet\Diablo\Items\ItemRequest', $client->items());
    }
}
