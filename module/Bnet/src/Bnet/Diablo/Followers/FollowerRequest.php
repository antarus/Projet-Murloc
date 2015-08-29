<?php
namespace Bnet\Diablo\Followers;

use Bnet\Core\AbstractRequest;

class FollowerRequest extends AbstractRequest
{
    public function find($follower)
    {
        $data = $this->client->get('data/follower/'.$follower);

        if ($data === null) {
            return null;
        }

        return new FollowerEntity($data);
    }
}
