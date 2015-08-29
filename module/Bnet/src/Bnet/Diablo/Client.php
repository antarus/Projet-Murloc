<?php
namespace Bnet\Diablo;

use Bnet\Core\AbstractClient;
use Bnet\Diablo\Artisans\ArtisanRequest;
use Bnet\Diablo\Followers\FollowerRequest;
use Bnet\Diablo\Items\ItemRequest;

class Client extends AbstractClient
{
    const API = 'd3';

    public function artisans()
    {
        return new ArtisanRequest($this);
    }

    public function followers()
    {
        return new FollowerRequest($this);
    }

    public function items()
    {
        return new ItemRequest($this);
    }
}
