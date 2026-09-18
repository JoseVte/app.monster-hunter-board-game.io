<?php

return [
    'name' => [
        'en' => 'Dual Blades',
        'es' => 'Espadas Dobles',
    ],
    'description' => '',
    'image' => 'icon_weapon_04.png',
    'weapons' => [
        'Matched Slicers' => [
            'default' => true,
            'branch' => 'mineral',
            'name' => 'Rebanadoras Gemelas',
            'count_attack_1' => 10,
            'count_attack_2' => 2,
        ],
        'Dual Slicers' => [
            'parent' => 'Matched Slicers',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => 'Duorrebanadoras',
            'count_attack_1' => 8,
            'count_attack_2' => 3,
            'count_attack_3' => 1,
            'items' => [
                'Dragonite Ore' => 1,
                'Machalite Ore' => 1,
                'Monster Bone Medium' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Lunging Stab' => 2,
                ],
                'add' => [
                    'Enhanced Lunging Stab' => 2,
                ],
            ],
        ],
        'Chrome Slicers' => [
            'parent' => 'Dual Slicers',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => 'Cromorrebanadoras',
            'count_attack_1' => 5,
            'count_attack_2' => 5,
            'count_attack_3' => 2,
            'items' => [
                'Fucium Ore' => 2,
                'Carbalite Ore' => 2,
                'Dragonite Ore' => 3,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Lunging Stab' => 2,
                    'Blade Dance' => 4,
                ],
                'add' => [
                    'Enhanced Lunging Stab' => 2,
                    'Enhanced Blade Dance' => 4,
                ],
            ],
        ],
        'Bone Hatchets' => [
            'branch' => 'bone',
            'name' => 'Hachas Óseas',
            'count_attack_1' => 7,
            'count_attack_2' => 3,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        'Wild Hatchets' => [
            'parent' => 'Bone Hatchets',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => 'Hachas Salvajes',
            'count_attack_1' => 5,
            'count_attack_2' => 5,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Double Slash' => 2,
                ],
                'add' => [
                    'Impact Double Slash' => 2,
                ],
            ],
        ],
        'Strong Hatchets' => [
            'parent' => 'Wild Hatchets',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => 'Hachas Reforzadas',
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 2,
            'items' => [
                'Monster Hardbone' => 2,
                'Monster Keenbone' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Double Slash' => 2,
                    'Rapid Spin' => 2,
                ],
                'add' => [
                    'Impact Double Slash' => 2,
                    'Strong Rapid Spin' => 2,
                ],
            ],
        ],
        // ANCIENT FOREST
        'Pulsar Hatchets' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Bone Hatchets',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
            'name' => 'Hachas Púlsar',
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 3,
            'items' => [
                'Tobi-Kadachi Electrode' => 1,
                'Tobi-Kadachi Claw' => 2,
                'Electro Sac' => 2,
                'Coral Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Bladed Fangs' => 2,
                    'Rapid Spin' => 2,
                ],
                'add' => [
                    'Shocking Rush' => 4,
                ],
            ],
        ],
        'Kadachi Claws' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Pulsar Hatchets',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 4,
            'name' => 'Garras Kadachi',
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 5,
            'items' => [
                'Tobi-Kadachi Electrode' => 2,
                'Tobi-Kadachi Claw' => 2,
                'Thunder Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Bladed Fangs' => 2,
                    'Rapid Spin' => 2,
                    'Demon Mode' => 2,
                ],
                'add' => [
                    'Shocking Rush' => 4,
                    'Enhanced Demon Mode' => 2,
                ],
            ],
        ],
        'Blazing Hatchets' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Bone Hatchets',
            'branch' => 'Anjanath',
            'rarity' => 3,
            'name' => 'Hachas Flameantes',
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 3,
            'items' => [
                'Anjanath Scale' => 3,
                'Anjanath Fang' => 2,
                'Flame Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Six Fold Slash' => 1,
                    'Any Card' => 1,
                ],
                'add' => [
                    'Blazing Fold Slash' => 2,
                ],
            ],
        ],
        'Anja Cyclone' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Blazing Hatchets',
            'branch' => 'Anjanath',
            'rarity' => 4,
            'name' => 'Ciclón Anja',
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 5,
            'items' => [
                'Anjanath Fang' => 4,
                'Anjanath Pelt' => 4,
                'Firecell Stone' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Six Fold Slash' => 1,
                    'Any Card' => 1,
                    'Double Slash' => 2,
                ],
                'add' => [
                    'Blazing Fold Slash' => 2,
                    'Blazing Double Slash' => 2,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        'Madness Pangas' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Hatchets',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
            'name' => 'Machetes Maníacos',
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 5,
            'count_attack_3' => 3,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Shell' => 2,
                'Jyuratodus Scale' => 3,
                'Aqua Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Blade Dance' => 4,
                ],
                'add' => [
                    'Water Dance' => 4,
                ],
            ],
        ],
        'Jyura Hatchets' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Madness Pangas',
            'branch' => 'Jyuratodus',
            'rarity' => 4,
            'name' => 'Machetes Jyura',
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 4,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Carapace' => 2,
                'Jyuratodus Scale' => 2,
                'Aqua Sac' => 1,
                'Gajau Scale' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Blade Dance' => 4,
                    'Rapid Spin' => 2,
                ],
                'add' => [
                    'Water Dance' => 4,
                    'Flurry Rush' => 2,
                ],
            ],
        ],
        'Diablos Hatchets' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Hatchets',
            'branch' => 'Diablos',
            'rarity' => 3,
            'name' => 'Hachas Diablos',
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 4,
            'items' => [
                'Twisted Horn' => 1,
                'Diablos Fang' => 2,
                'Diablos Shell' => 4,
                'Monster Bone Large' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Double Slash' => 2,
                ],
                'add' => [
                    'Brutal Double Slash' => 2,
                ],
            ],
        ],
        'Diablos Clubs' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Diablos Hatchets',
            'branch' => 'Diablos',
            'rarity' => 4,
            'name' => 'Garrotes Diablos',
            'defense' => 1,
            'count_attack_1' => 2,
            'count_attack_2' => 7,
            'count_attack_3' => 5,
            'items' => [
                'Majestic Horn' => 2,
                'Diablos Carapace' => 2,
                'Diablos Ridge' => 2,
                'Blos Medulla' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Double Slash' => 2,
                    'Demon Mode' => 2,
                ],
                'add' => [
                    'Brutal Double Slash' => 2,
                    'Brutal Demon Mode' => 2,
                ],
            ],
        ],
        // KULU YA KU EXPANSION
        'Rending Beaks' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'Matched Slicers',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 3,
            'name' => 'Picos Desgarradores',
            'count_attack_1' => 2,
            'count_attack_2' => 10,
            'count_attack_3' => 2,
            'items' => [
                'Kulu-Ya-Ku Beak' => 1,
                'Kulu-Ya-Ku Hide' => 2,
                'Kulu-Ya-Ku Scale' => 4,
                'Earth Crystal' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Lunging Stab' => 2,
                ],
                'add' => [
                    'Evasive Stab' => 2,
                ],
            ],
        ],
        'Arcanaria' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'Rending Beaks',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 4,
            'name' => 'Arcanaria',
            'count_attack_1' => 2,
            'count_attack_2' => 10,
            'count_attack_3' => 4,
            'items' => [
                'Kulu-Ya-Ku Beak' => 2,
                'Kulu-Ya-Ku Hide' => 3,
                'Kulu-Ya-Ku Plume' => 3,
                'Boulder Bone' => 4,
            ],
            'attacks' => [
                'remove' => [
                    'Lunging Stab' => 2,
                    'Double Spin' => 2,
                ],
                'add' => [
                    'Evasive Stab' => 2,
                    'Dream Spin' => 2,
                ],
            ],
        ],
        // NERGIGANTE EXPANSION
        'Nergal Gouge' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Matched Slicers',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => 'Gubias Nergal',
            'has_elemental_attacks' => true,
            'count_attack_2' => 5,
            'count_attack_3' => 6,
            'count_attack_4' => 1,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Blade Dance' => 4,
                ],
                'add' => [
                    'Dragon Dance' => 4,
                ],
            ],
        ],
        'Decimation Claws' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Nergal Gouge',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => 'Garras Diezmadoras',
            'has_elemental_attacks' => true,
            'count_attack_2' => 5,
            'count_attack_3' => 7,
            'count_attack_4' => 2,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Blade Dance' => 4,
                    'Rapid Spin' => 2,
                ],
                'add' => [
                    'Dragon Dance' => 4,
                    'Mid Air Slash' => 2,
                ],
            ],
        ],
        // TEOSTRA EXPANSION
        'Twin Nails' => [
            'expansion' => [App\Enum\MonsterExpansion::TEOSTRA_EXPANSION, App\Enum\MonsterExpansion::KUSHALA_EXPANSION],
            'parent' => 'Matched Slicers',
            'branch' => ['Teostra', 'Kushala Daora'],
            'rarity' => 4,
            'name' => 'Clavos Gemelos',
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 5,
            'count_attack_4' => 1,
            'items' => [
                [
                    'Teostra Claw' => 1,
                    'Teostra Mane' => 1,
                    'Teostra Carapace' => 2,
                    'Teostra Powder' => 1,
                ],
                [
                    'Daora Claw' => 1,
                    'Daora Webbing' => 2,
                    'Nergigante Carapace' => 1,
                    'Daora Tail' => 1,
                ],
            ],
            'attacks' => [
                'remove' => [
                    'Any Card' => 2,
                ],
                'add' => [
                    'Blast Wrath' => 2,
                ],
            ],
        ],
        'Fire and Ice' => [
            'expansion' => [App\Enum\MonsterExpansion::TEOSTRA_EXPANSION, App\Enum\MonsterExpansion::KUSHALA_EXPANSION],
            'parent' => 'Twin Nails',
            'branch' => ['Teostra', 'Kushala Daora'],
            'rarity' => 5,
            'name' => 'Fuego y Hielo',
            'has_elemental_attacks' => true,
            'count_attack_2' => 9,
            'count_attack_3' => 4,
            'count_attack_4' => 3,
            'items' => [
                [
                    'Teostra Horn' => 3,
                    'Teostra Claw' => 2,
                    'Teostra Gem' => 1,
                ],
                [
                    'Daora Horn' => 4,
                    'Daora Claw' => 3,
                    'Daora Gem' => 1,
                ],
            ],
            'attacks' => [
                'remove' => [
                    'Any Card' => 2,
                    'Sixfold Slash' => 1,
                    'Double Slash' => 2,
                ],
                'add' => [
                    'Blast Wrath' => 2,
                    'Rending Slice' => 3,
                ],
            ],
        ],
        // KUSHALA EXPANSION <TEOSTRA>
        // KIRIN EXPANSION
        'Kirin Bolts' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Bone Hatchets',
            'branch' => 'Kirin',
            'rarity' => 4,
            'name' => 'Cuernos de Kirin',
            'has_elemental_attacks' => true,
            'count_attack_2' => 7,
            'count_attack_3' => 4,
            'count_attack_4' => 1,
            'items' => [
                'Kirin Thunderhorn' => 3,
                'Kirin Hide' => 3,
                'Kirin Tail' => 1,
                'Lightcrystal' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Rapid Spin' => 2,
                    'Double Slash' => 2,
                ],
                'add' => [
                    'Charged Slash' => 4,
                ],
            ],
        ],
        'Monarch' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Kirin Bolts',
            'branch' => 'Kirin',
            'rarity' => 5,
            'name' => 'Monarcas',
            'has_elemental_attacks' => true,
            'count_attack_2' => 6,
            'count_attack_3' => 6,
            'count_attack_4' => 2,
            'items' => [
                'Kirin Azure Horn' => 2,
                'Kirin Hide' => 2,
                'Kirin Mane' => 2,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Rapid Spin' => 2,
                    'Double Slash' => 2,
                    'Bladed Fangs' => 2,
                ],
                'add' => [
                    'Charged Slash' => 4,
                    'Thunder Fangs' => 2,
                ],
            ],
        ],
    ],
];
