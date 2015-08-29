<?php
namespace Bnet\Diablo\Items;

use Bnet\Core\AbstractRequest;

class ItemRequest extends AbstractRequest
{
    public function find($data)
    {
        $data = $this->client->get('data/item/'.$data);

        if ($data === null) {
            return null;
        }

        return new ItemEntity($data);
    }
}
