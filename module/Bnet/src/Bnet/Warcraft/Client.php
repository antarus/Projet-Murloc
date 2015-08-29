<?php
namespace Bnet\Warcraft;

use Bnet\Core\AbstractClient;
use Bnet\Warcraft\Auctions\AuctionRequest;
use Bnet\Warcraft\BattlePets\BattlePetRequest;
use Bnet\Warcraft\Characters\CharacterRequest;
use Bnet\Warcraft\Guilds\GuildRequest;
use Bnet\Warcraft\Items\ItemRequest;
use Bnet\Warcraft\Leaderboards\LeaderboardRequest;
use Bnet\Warcraft\Quests\QuestRequest;
use Bnet\Warcraft\Realms\RealmRequest;
use Bnet\Warcraft\Recipes\RecipeRequest;
use Bnet\Warcraft\Spells\SpellRequest;

class Client extends AbstractClient
{
    const API = 'wow';

    public function auctions()
    {
        return new AuctionRequest($this);
    }

    public function battlePets()
    {
        return new BattlePetRequest($this);
    }

    public function characters()
    {
        return new CharacterRequest($this);
    }

    public function guilds()
    {
        return new GuildRequest($this);
    }

    public function items()
    {
        return new ItemRequest($this);
    }

    public function leaderboards()
    {
        return new LeaderboardRequest($this);
    }

    public function quests()
    {
        return new QuestRequest($this);
    }

    public function realms()
    {
        return new RealmRequest($this);
    }

    public function recipes()
    {
        return new RecipeRequest($this);
    }

    public function spells()
    {
        return new SpellRequest($this);
    }
}
