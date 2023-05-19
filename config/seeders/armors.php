<?php

use App\Enum\ArmorType;

return [
    'abilities' => [
        [
            'name' => 'Poison Resistance',
            'description' => '',
        ],
        [
            'name' => 'Speed Eating',
            'description' => '',
        ],
        [
            'name' => 'Slugger',
            'description' => '',
        ],
        [
            'name' => 'Palico Rally',
            'description' => '',
        ],
        [
            'name' => 'Constitution',
            'description' => '',
        ],
        [
            'name' => 'Evade Extender',
            'description' => '',
        ],
        [
            'name' => 'Thunder Attack',
            'description' => '',
        ],
        [
            'name' => 'Fire Attack',
            'description' => '',
        ],
        [
            'name' => 'Marathon Runner',
            'description' => '',
        ],
        [
            'name' => 'Weakness Exploit',
            'description' => '',
        ],
        [
            'name' => 'Sleep Resistance',
            'description' => '',
        ],
        [
            'name' => 'Intimidator',
            'description' => '',
        ],
        [
            'name' => 'Focus',
            'description' => '',
        ],
        [
            'bonus-set' => ['Rathalos Helm', 'Rathalos Mail', 'Rathalos Greaves'],
            'name' => 'Rathalos Mastery',
            'description' => '',
        ],
        [
            'bonus-set' => ['Rath Soul Helm', 'Rath Soul Mail', 'Rath Soul Greaves'],
            'name' => 'Azure Rathalos Mastery',
            'description' => '',
        ],
        [
            'name' => 'Guard',
            'description' => '',
        ],
        [
            'name' => 'Stun Resistance',
            'description' => '',
        ],
        [
            'name' => 'Sporepuff Expert',
            'description' => '',
        ],
        [
            'name' => 'Botanist',
            'description' => '',
        ],
        [
            'name' => 'Aquatic Expert',
            'description' => '',
        ],
        [
            'name' => 'Water Attack',
            'description' => '',
        ],
        [
            'name' => 'Heroics',
            'description' => '',
        ],
        [
            'name' => 'Resentment',
            'description' => '',
        ],
        [
            'name' => 'Part Breaker',
            'description' => '',
        ],
        [
            'bonus-set' => ['Diablos Helm', 'Diablos Mail', 'Diablos Greaves'],
            'name' => 'Diablos Mastery',
            'description' => '',
        ],
        [
            'bonus-set' => ['Diablos Nero Helm', 'Diablos Nero Mail', 'Diablos Nero Greaves'],
            'name' => 'Black Diablos Mastery',
            'description' => '',
        ],
        [
            'name' => 'Weakness Exploit',
            'description' => '',
        ],
        [
            'name' => 'Critical Eye',
            'description' => '',
        ],
        [
            'name' => 'Maximun Might',
            'description' => '',
        ],
        [
            'name' => 'Agitator',
            'description' => '',
        ],
        [
            'bonus-set' => ['Nergigante Helm', 'Nergigante Mail', 'Nergigante Greaves'],
            'name' => 'Nergigante Hunger',
            'description' => '',
        ],
        [
            'name' => 'Latent Power',
            'description' => '',
        ],
        [
            'bonus-set' => ['Kaiser Crown', 'Kaiser Mail', 'Kaiser Greaves'],
            'name' => 'Teostra Technique',
            'description' => '',
        ],
        [
            'name' => 'Ice Attack',
            'description' => '',
        ],
        [
            'bonus-set' => ['Kushala Glare', 'Kushala Cista', 'Kushala Crus'],
            'name' => 'Kushala Daora Flight',
            'description' => '',
        ],
        [
            'name' => 'Handicraft',
            'description' => '',
        ],
    ],

    ArmorType::HEAD->name => [
        'Alloy Helm' => [
            'items' => [
                'Machalite Ore' => 2,
                'Carbalite Ore' => 1,
                'Dragonite Ore' => 1,
            ],
            'defense' => 1,
        ],
        'Bone Helm' => [
            'items' => [
                'Monster Bone Small' => 2,
                'Ancient Bone' => 2,
            ],
            'defense' => 1,
        ],
        'Jagras Helm' => [
            'items' => [
                'Great Jagras Hide' => 1,
                'Great Jagras Mane' => 1,
                'Great Jagras Claw' => 1,
                'Ancient Bone' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'ability' => 'Speed Eating',
        ],
        'Kadachi Helm' => [
            'items' => [
                'Tobi-Kadachi Pelt' => 1,
                'Tobi-Kadachi Claw' => 1,
                'Electro Sac' => 1,
            ],
            'defense_thunder' => 2,
            'ability' => 'Constitution',
        ],
        'Anja Helm' => [
            'items' => [
                'Anjanath Pelt' => 1,
                'Anjanath Scale' => 1,
                'Anjanath Tail' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'ability' => 'Fire Attack',
        ],
        'Rathalos Helm' => [
            'items' => [
                'Rathalos Scale' => 1,
                'Rathalos Shell' => 1,
                'Rathalos Marrow' => 1,
            ],
            'defense' => 2,
            'defense_fire' => 1,
            'ability' => 'Rathalos Mastery',
        ],
        'Rath Soul Helm' => [
            'items' => [
                'Azure Rathalos Scale' => 1,
                'Azure Rathalos Carapace' => 1,
                'Azure Rathalos Marrow' => 1,
            ],
            'defense' => 2,
            'defense_fire' => 1,
            'ability' => 'Intimidator',
        ],
        'Barroth Helm' => [
            'items' => [
                'Barroth Ridge' => 1,
                'Barroth Claw' => 1,
                'Fertile Mud' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'ability' => 'Guard',
        ],
        'Pukei Hood' => [
            'items' => [
                'Pukei-Pukei Carapace' => 1,
                'Pukei-Pukei Tail' => 1,
                'Pukei-Pukei Wing' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'ability' => 'Sporepuff Expert',
        ],
        'Jyura Helm' => [
            'items' => [
                'Jyuratodus Scale' => 1,
                'Jyuratodus Carapace' => 1,
                'Jyuratodus Fin' => 1,
                'Gajau Scale' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'ability' => 'Aquatic Expert',
        ],
        'Diablos Helm' => [
            'items' => [
                'Diablos Ridge' => 1,
                'Diablos Fang' => 2,
                'Majestic Horn' => 1,
                'Wyvern Gem' => 2,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'ability' => 'Heroics',
        ],
        'Diablos Nero Helm' => [
            'items' => [
                'Black Diablos Ridge' => 2,
                'Majestic Horn' => 1,
                'Black Spiral Horn' => 1,
                'Novacrystal' => 2,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'ability' => 'Black Diablos Mastery',
        ],
        'Kulu Headpiece' => [
            'items' => [
                'Kulu-Ya-Ku Scale' => 1,
                'Kulu-Ya-Ku Hide' => 1,
                'Kulu-Ya-Ku Plume' => 1,
            ],
            'defense' => 1,
            'defense_ice' => 1,
            'ability' => 'Weakness Exploit',
        ],
        'Nergigante Helm' => [
            'items' => [
                'Nergigante Horn' => 1,
                'Nergigante Carapace' => 1,
                'Immortal Dragonscale' => 2,
                'Nergigante Gem' => 1,
            ],
            'defense' => 2,
            'defense_fire' => 2,
            'ability' => 'Maximun Might',
        ],
        'Kaiser Helm' => [
            'items' => [
                'Teostra Carapace' => 1,
                'Teostra Horn' => 1,
                'Teostra Tail' => 1,
                'Firecell Stone' => 2,
            ],
            'defense' => 2,
            'defense_fire' => 1,
            'ability' => 'Latent Power',
        ],
        'Kushala Glare' => [
            'items' => [
                'Daora Dragon Scale' => 2,
                'Daora Carapace' => 1,
                'Daora Webbing' => 1,
                'Elder Dragon Bone' => 2,
            ],
            'defense' => 1,
            'defense_ice' => 2,
            'ability' => 'Ice Attack',
        ],
    ],

    ArmorType::BODY->name => [
        'Alloy Mail' => [
            'items' => [
                'Machalite Ore' => 1,
                'Carbalite Ore' => 2,
                'Dragonite Ore' => 1,
            ],
            'defense' => 1,
        ],
        'Bone Mail' => [
            'items' => [
                'Monster Bone Small' => 1,
                'Ancient Bone' => 1,
            ],
            'ability' => 'Slugger',
        ],
        'Jagras Mail' => [
            'items' => [
                'Great Jagras Hide' => 1,
                'Great Jagras Claw' => 1,
                'Great Jagras Scale' => 1,
                'Monster Bone Small' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'ability' => 'Palico Rally',
        ],
        'Kadachi Mail' => [
            'items' => [
                'Tobi-Kadachi Pelt' => 1,
                'Tobi-Kadachi Electrode' => 1,
                'Tobi-Kadachi Membrane' => 2,
                'Wingdrake Hide' => 1,
            ],
            'defense' => 1,
            'defense_thunder' => 1,
            'ability' => 'Evade Extender',
        ],
        'Anja Mail' => [
            'items' => [
                'Anjanath Pelt' => 1,
                'Anjanath Fang' => 1,
                'Anjanath Nosebone' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'ability' => 'Marathon Runner',
        ],
        'Rathalos Mail' => [
            'items' => [
                'Rathalos Scale' => 1,
                'Rathalos Webbing' => 1,
                'Rathalos Plate' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'ability' => 'Weakness Exploit',
        ],
        'Rath Soul Mail' => [
            'items' => [
                'Azure Rathalos Scale' => 1,
                'Azure Rathalos Wing' => 1,
                'Azure Rathalos Plate' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'ability' => 'Azure Rathalos Mastery',
        ],
        'Barroth Mail' => [
            'items' => [
                'Barroth Carapace' => 1,
                'Barroth Ridge' => 2,
                'Barroth Claw' => 1,
                'Quality Bone' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
        ],
        'Pukei Mail' => [
            'items' => [
                'Pukei-Pukei Scale' => 2,
                'Pukei-Pukei Carapace' => 1,
                'Carbalite Ore' => 3,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'ability' => 'Botanist',
        ],
        'Jyura Mail' => [
            'items' => [
                'Jyuratodus Scale' => 1,
                'Jyuratodus Fin' => 1,
                'Jyuratodus Fang' => 1,
                'Torrent Sac' => 2,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'ability' => 'Water Attack',
        ],
        'Diablos Mail' => [
            'items' => [
                'Diablos Carapace' => 2,
                'Diablos Ridge' => 1,
                'Majestic Horn' => 1,
                'Lightcrystal' => 2,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'ability' => 'Slugger',
        ],
        'Diablos Nero Mail' => [
            'items' => [
                'Black Diablos Carapace' => 2,
                'Black Spiral Horn' => 2,
                'Blos Medulla' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'ability' => 'Resentment',
        ],
        'Kulu Mail' => [
            'items' => [
                'Kulu-Ya-Ku Hide' => 2,
                'Kulu-Ya-Ku Plume' => 1,
                'Kulu-Ya-Ku Beak' => 1,
                'Bird Wyvern Gem' => 1,
            ],
            'defense' => 1,
            'defense_ice' => 1,
            'ability' => 'Critical Eye',
        ],
        'Nergigante Mail' => [
            'items' => [
                'Immortal Dragonscale' => 2,
                'Nergigante Talon' => 2,
                'Elder Dragon Bone' => 2,
            ],
            'defense' => 2,
            'defense_ice' => 2,
            'ability' => 'Agitator',
        ],
        'Kaiser Mail' => [
            'items' => [
                'Teostra Webbing' => 2,
                'Teostra Powder' => 2,
                'Rathalos Plate' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 2,
            'ability' => 'Teostra Technique',
        ],
        'Kushala Cista' => [
            'items' => [
                'Daora Carapace' => 1,
                'Daora Horn' => 1,
                'Daora Claw' => 1,
                'Daora Gem' => 1,
            ],
            'defense' => 2,
            'defense_ice' => 1,
            'ability' => 'Kushala Daora Flight',
        ],
    ],

    ArmorType::LEG->name => [
        'Alloy Greaves' => [
            'items' => [
                'Machalite Ore' => 1,
                'Carbalite Ore' => 2,
                'Dragonite Ore' => 1,
            ],
            'ability' => 'Poison Resistance',
        ],
        'Bone Greaves' => [
            'items' => [
                'Monster Bone Small' => 1,
                'Ancient Bone' => 1,
            ],
            'defense' => 1,
        ],
        'Jagras Greaves' => [
            'items' => [
                'Great Jagras Scale' => 1,
                'Great Jagras Hide' => 1,
                'Great Jagras Mane' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
        ],
        'Kadachi Greaves' => [
            'items' => [
                'Tobi-Kadachi Scale' => 2,
                'Tobi-Kadachi Pelt' => 1,
                'Warm Pelt' => 1,
            ],
            'defense_thunder' => 1,
            'ability' => 'Thunder Attack',
        ],
        'Anja Greaves' => [
            'items' => [
                'Anjanath Scale' => 1,
                'Anjanath Pelt' => 1,
                'Flame Sac' => 1,
                'Machalite Ore' => 2,
            ],
            'defense' => 1,
            'defense_fire' => 2,
        ],
        'Rathalos Greaves' => [
            'items' => [
                'Rathalos Shell' => 1,
                'Rathalos Wingtalon' => 1,
                'Rathalos Tail' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'ability' => 'Sleep Resistance',
        ],
        'Rath Soul Greaves' => [
            'items' => [
                'Azure Rathalos Carapace' => 1,
                'Azure Rathalos Wingtalon' => 1,
                'Azure Rathalos Tail' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'ability' => 'Focus',
        ],
        'Barroth Greaves' => [
            'items' => [
                'Barroth Ridge' => 1,
                'Barroth Carapace' => 2,
                'Fertile Mud' => 1,
                'Monster Keenbone' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'ability' => 'Stun Resistance',
        ],
        'Pukei Greaves' => [
            'items' => [
                'Pukei-Pukei Carapace' => 2,
                'Pukei-Pukei Sac' => 2,
                'Pukei-Pukei Scale' => 1,
                'Monster Keenbone' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'ability' => 'Poison Resistance',
        ],
        'Jyura Greaves' => [
            'items' => [
                'Jyuratodus Carapace' => 1,
                'Jyuratodus Fang' => 1,
                'Jyuratodus Fin' => 1,
                'Wyvern Gem' => 1,
            ],
            'defense' => 1,
            'defense_water' => 2,
        ],
        'Diablos Greaves' => [
            'items' => [
                'Diablos Ridge' => 1,
                'Diablos Carapace' => 2,
                'Blos Medulla' => 1,
            ],
            'defense' => 2,
            'defense_fire' => 1,
            'ability' => 'Diablos Mastery',
        ],
        'Diablos Nero Greaves' => [
            'items' => [
                'Black Diablos Ridge' => 1,
                'Black Diablos Carapace' => 2,
                'Black Spiral Horn' => 1,
                'Wyvern Gem' => 1,
            ],
            'defense' => 2,
            'defense_fire' => 1,
            'ability' => 'Part Breaker',
        ],
        'Kulu Greaves' => [
            'items' => [
                'Kulu-Ya-Ku Hide' => 1,
                'Kulu-Ya-Ku Scale' => 2,
                'Wingdrake Hide' => 3,
                'Earth Crystal' => 1,
            ],
            'defense' => 1,
            'defense_ice' => 2,
        ],
        'Nergigante Greaves' => [
            'items' => [
                'Nergigante Carapace' => 1,
                'Immortal Dragonscale' => 1,
                'Nergigante Regrowth Plate' => 2,
                'Elder Dragon Blood' => 2,
            ],
            'defense' => 2,
            'defense_water' => 2,
            'ability' => 'Nergigante Hunger',
        ],
        'Teostra Greaves' => [
            'items' => [
                'Fire Dragon Scale' => 2,
                'Teostra Mane' => 1,
            ],
            'defense' => 2,
            'defense_fire' => 1,
            'ability' => 'Weakness Exploit',
        ],
        'Kushala Crus' => [
            'items' => [
                'Daora Carapace' => 1,
                'Daora Dragon Scale' => 1,
                'Daora Webbing' => 2,
                'Elder Dragon Blood' => 2,
            ],
            'defense' => 2,
            'defense_ice' => 1,
            'ability' => 'Handicraft',
        ],
    ],
];
