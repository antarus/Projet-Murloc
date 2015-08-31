<?php

/**
 * Autoload classmap permet de liée un namespace a un fichier.
 * Permet l'optimisation du temps de chargement.
 *
 * @autor: Antarus
 * @version: 1.0
 * @date: 27/08/2015
 */
return array(
// base
    'Bnet\Utils' => __DIR__ . '/src/Bnet/Utils.php',
    'Bnet\Region' => __DIR__ . '/src/Bnet/Region.php',
    'Bnet\ClientFactory' => __DIR__ . '/src/Bnet/ClientFactory.php',
    // core
    'Bnet\Core\AbstractClient' => __DIR__ . '/src/Bnet/Core/AbstractClient.php',
    'Bnet\Core\AbstractEntity' => __DIR__ . '/src/Bnet/Core/AbstractEntity.php',
    'Bnet\Core\AbstractRequest' => __DIR__ . '/src/Bnet/Core/AbstractRequest.php',
    // warcraft
    'Bnet\Warcraft\Client' => __DIR__ . '/src/Bnet/Warcraft/Client.php',
    // warcraft guilde
    'Bnet\Warcraft\Guilds\GuildEntity' => __DIR__ . '/src/Bnet/Warcraft/Guilds/GuildEntity.php',
    'Bnet\Warcraft\Guilds\GuildRequest' => __DIR__ . '/src/Bnet/Warcraft/Guilds/GuildRequest.php',
    'Bnet\Warcraft\Guilds\AchievementEntity' => __DIR__ . '/src/Bnet/Warcraft/Guilds/AchievementEntity.php',
    'Bnet\Warcraft\Guilds\PerkEntity' => __DIR__ . '/src/Bnet/Warcraft/Guilds/PerkEntity.php',
    'Bnet\Warcraft\Guilds\RewardEntity' => __DIR__ . '/src/Bnet/Warcraft/Guilds/RewardEntity.php',
    // warcraft character
    'Bnet\Warcraft\Characters\AchievementCategoryEntity' => __DIR__ . '/src/Bnet/Warcraft/Characters/AchievementCategoryEntity.php',
    'Bnet\Warcraft\Characters\AchievementEntity' => __DIR__ . '/src/Bnet/Warcraft/Characters/AchievementEntity.php',
    'Bnet\Warcraft\Characters\CharacterEntity' => __DIR__ . '/src/Bnet/Warcraft/Characters/CharacterEntity.php',
    'Bnet\Warcraft\Characters\CharacterRequest' => __DIR__ . '/src/Bnet/Warcraft/Characters/CharacterRequest.php',
    'Bnet\Warcraft\Characters\ClassEntity' => __DIR__ . '/src/Bnet/Warcraft/Characters/ClassEntity.php',
    'Bnet\Warcraft\Characters\GlyphEntity' => __DIR__ . '/src/Bnet/Warcraft/Characters/GlyphEntity.php',
    'Bnet\Warcraft\Characters\RaceEntity' => __DIR__ . '/src/Bnet/Warcraft/Characters/RaceEntity.php',
    'Bnet\Warcraft\Characters\TalentEntity' => __DIR__ . '/src/Bnet/Warcraft/Characters/TalentEntity.php',
    // TODO finir pour les autres catégorie dans waracraft
    // TODO a finir pour les autre jeux/
    'Bnet\Diablo\Client' => __DIR__ . '/src/Bnet/Diablo/Client.php',
    'Bnet\Starcraft\Client' => __DIR__ . '/src/Bnet/Starcraft/Client.php',
);
