<?php

namespace App\Enum;

enum AchievementType: string
{
    case LEVEL = 'level';
    case MONSTER = 'monster';
    case WEAPON = 'weapon';
    case ARMOR = 'armor';
}
