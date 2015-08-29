<?php
namespace BnetTest\Warcraft;

use BnetTest\TestClient;
use Bnet\Warcraft\Recipes\RecipeRequest;

class RecipeRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testFind()
    {
        $request  = new RecipeRequest(new TestClient('wow'));
        $response = $request->find(33994);

        $this->assertInstanceOf('\Bnet\Warcraft\Recipes\RecipeEntity', $response);
        $this->assertSame(33994, $response->id);
    }

    public function testFindInvalidId()
    {
        $request  = new RecipeRequest(new TestClient('wow'));
        $response = $request->find('invalid');

        $this->assertNull($response);
    }
}
