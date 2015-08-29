<?php
namespace BnetTest\Warcraft;

use BnetTest\TestClient;
use Bnet\Warcraft\Quests\QuestRequest;

class QuestRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testFind()
    {
        $request  = new QuestRequest(new TestClient('wow'));
        $response = $request->find(13146);

        $this->assertInstanceOf('\Bnet\Warcraft\Quests\QuestEntity', $response);
        $this->assertSame(13146, $response->id);
    }

    public function testFindInvalidId()
    {
        $request  = new QuestRequest(new TestClient('wow'));
        $response = $request->find('invalid');

        $this->assertNull($response);
    }
}
