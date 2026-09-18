<?php

return [
    'name' => [
        'en' => 'Charge Blade',
        'es' => 'Hacha Cargada',
    ],
    'description' => [
        'en' => 'When you play an attack card with :charged_blade_vial_plus:, draw +1 :damage_attack_icon: for every :charged_blade_vial: on face up attack cards on your stamina board. Then discard the rightmost face up attack card with :charged_blade_vial: on your stamina board.',
        'es' => 'Cuando juegas una carta de ataque con :charged_blade_vial_plus:, roba +1 :damage_attack_icon: por cada :charged_blade_vial: en cartas de ataque boca arriba en tu tablero de resistencia. Luego descarta la carta de ataque boca arriba situada más a la derecha con :charged_blade_vial: en tu tablero de resistencia.',
    ],
    'image' => 'icon_weapon_10.png',
    'weapons' => [
        'Proto Commission Axe' => [
            'default' => true,
            'branch' => 'mineral',
            'name' => 'Protohacha Comitiva',
            'count_attack_1' => 8,
            'count_attack_2' => 4,
        ],
        'Elite Commission Axe' => [
            'parent' => 'Proto Commission Axe',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => 'Hacha Élite Comitiva',
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
                    'Return Stroke' => 3,
                ],
                'add' => [
                    'Powered Stroke' => 3,
                ],
            ],
        ],
        'Chrome Guardian' => [
            'parent' => 'Elite Commission Axe',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => 'Cromoguardián',
            'defense' => 1,
            'count_attack_1' => 5,
            'count_attack_2' => 4,
            'count_attack_3' => 3,
            'items' => [
                'Fucium Ore' => 2,
                'Carbalite Ore' => 2,
                'Dragonite Ore' => 3,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Return Stroke' => 2,
                    'Shield Block' => 3,
                ],
                'add' => [
                    'Powered Stroke' => 2,
                    'Solid Block' => 3,
                ],
            ],
        ],
        'Bone Strongarm' => [
            'branch' => 'bone',
            'name' => 'Aspa Ósea',
            'count_attack_1' => 5,
            'count_attack_3' => 5,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        'Hard Bone Strongarm' => [
            'parent' => 'Bone Strongarm',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => 'Aspa Hueso Pétreo',
            'count_attack_1' => 4,
            'count_attack_2' => 5,
            'count_attack_3' => 1,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Charged Rising Slash' => 2,
                ],
                'add' => [
                    'Quick Rising Slash' => 2,
                ],
            ],
        ],
        'Mighty Strongarm' => [
            'parent' => 'Hard Bone Strongarm',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => 'Aspa Recia',
            'defense' => 1,
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 3,
            'items' => [
                'Monster Hardbone' => 2,
                'Monster Keenbone' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Charged Rising Slash' => 2,
                    'Forward Slash' => 2,
                ],
                'add' => [
                    'Quick Rising Slash' => 2,
                    'Lunging Slash' => 2,
                ],
            ],
        ],
        // ANCIENT FOREST
        'Jagras Strongarm' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Bone Strongarm',
            'branch' => 'Great Jagras',
            'rarity' => 3,
            'name' => 'Aspa Jagras',
            'defense' => 1,
            'count_attack_1' => 3,
            'count_attack_2' => 3,
            'count_attack_3' => 4,
            'items' => [
                'Great Jagras Claw' => 1,
                'Great Jagras Hide' => 1,
                'Great Jagras Scale' => 3,
                'Sharp Claw' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Charged Rising Slash' => 2,
                ],
                'add' => [
                    'Gluttonous Slash' => 2,
                ],
            ],
        ],
        'Jagras Escudo' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Jagras Strongarm',
            'branch' => 'Great Jagras',
            'rarity' => 4,
            'name' => 'Escudo Jagras',
            'defense' => 1,
            'count_attack_1' => 2,
            'count_attack_2' => 4,
            'count_attack_3' => 5,
            'count_attack_4' => 1,
            'items' => [
                'Great Jagras Scale' => 2,
                'Great Jagras Claw' => 2,
                'Great Jagras Mane' => 2,
                'Piercing Claw' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Charged Rising Slash' => 2,
                    'Forward Slash' => 1,
                ],
                'add' => [
                    'Gluttonous Slash' => 2,
                    'Ravenous Slash' => 2,
                ],
            ],
        ],
        'Pulsar Strongarm' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Bone Strongarm',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
            'name' => 'Aspa Púlsar',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_1' => 2,
            'count_attack_2' => 5,
            'count_attack_3' => 2,
            'count_attack_4' => 1,
            'items' => [
                'Tobi-Kadachi Claw' => 1,
                'Tobi-Kadachi Scale' => 3,
                'Tobi-Kadachi Pelt' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Shield Block' => 3,
                ],
                'add' => [
                    'Lightning Reflex Block' => 3,
                ],
            ],
        ],
        'Kadachi Kaina' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Pulsar Strongarm',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 4,
            'name' => 'Kaina Kadachi',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_1' => 1,
            'count_attack_2' => 6,
            'count_attack_3' => 3,
            'count_attack_4' => 2,
            'items' => [
                'Tobi-Kadachi Claw' => 2,
                'Tobi-Kadachi Scale' => 2,
                'Tobi-Kadachi Pelt' => 2,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Shield Block' => 3,
                    'Return Stroke' => 3,
                ],
                'add' => [
                    'Lightning Reflex Block' => 3,
                    'Thunder Stroke' => 3,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        'Mudslide Blade' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Proto Commission Axe',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
            'name' => 'Hoja Enfangada',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 5,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Shell' => 2,
                'Jyuratodus Scale' => 3,
                'Aqua Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Elemental Round Slash' => 2,
                ],
                'add' => [
                    'Slippery Round Slash' => 2,
                ],
            ],
        ],
        'Jyura Depth' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Mudslide Blade',
            'branch' => 'Jyuratodus',
            'rarity' => 4,
            'name' => 'Profundidad Jyura',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_1' => 1,
            'count_attack_2' => 6,
            'count_attack_3' => 5,
            'count_attack_4' => 2,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Carapace' => 2,
                'Jyuratodus Scale' => 2,
                'Aqua Sac' => 1,
                'Gajau Scale' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Elemental Round Slash' => 2,
                    'Amped Element Discharge' => 2,
                ],
                'add' => [
                    'Slippery Round Slash' => 2,
                    'Water Element Discharge' => 2,
                ],
            ],
        ],
        'Diablos Wall' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Strongarm',
            'branch' => 'Diablos',
            'rarity' => 3,
            'name' => 'Muro Diablos',
            'defense' => 1,
            'count_attack_1' => 1,
            'count_attack_2' => 7,
            'count_attack_3' => 1,
            'count_attack_4' => 1,
            'items' => [
                'Twisted Horn' => 1,
                'Diablos Fang' => 2,
                'Diablos Shell' => 4,
                'Monster Bone Large' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Weak Slash' => 2,
                ],
                'add' => [
                    'Deft Slash' => 2,
                ],
            ],
        ],
        'Diablos Tyrannis' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Diablos Wall',
            'branch' => 'Diablos',
            'rarity' => 4,
            'name' => 'Tyrannis Diablos',
            'defense' => 1,
            'count_attack_1' => 2,
            'count_attack_2' => 5,
            'count_attack_3' => 2,
            'count_attack_4' => 3,
            'items' => [
                'Majestic Horn' => 2,
                'Diablos Carapace' => 2,
                'Diablos Ridge' => 2,
                'Blos Medulla' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Weak Slash' => 2,
                    'Element Discharge' => 2,
                ],
                'add' => [
                    'Deft Slash' => 2,
                    'Crippling Element Discharge' => 2,
                ],
            ],
        ],
        // KULU YA KU EXPANSION <NONE>
        // NERGIGANTE EXPANSION
        'Nergal Lacerator' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Proto Commission Axe',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => 'Azote Nergal',
            'defense' => 1,
            'count_attack_1' => 2,
            'count_attack_2' => 5,
            'count_attack_3' => 2,
            'count_attack_4' => 2,
            'count_attack_5' => 1,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Elemental Round Slash' => 2,
                ],
                'add' => [
                    'Savage Round Slash' => 2,
                ],
            ],
        ],
        'Devastation\'s Thorns' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Nergal Lacerator',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => 'Espinas de Devastación',
            'count_attack_2' => 6,
            'count_attack_3' => 5,
            'count_attack_4' => 3,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Elemental Round Slash' => 2,
                    'Shield Block' => 3,
                ],
                'add' => [
                    'Savage Round Slash' => 2,
                    'Dragon Block' => 3,
                ],
            ],
        ],
        // TEOSTRA EXPANSION <NONE>
        // KUSHALA EXPANSION
        'Daora\'s Casca' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Proto Commission Axe',
            'branch' => 'Kushala Daora',
            'rarity' => 4,
            'name' => 'Casca Daora',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 8,
            'count_attack_3' => 2,
            'count_attack_4' => 3,
            'count_attack_5' => 1,
            'items' => [
                'Daora Claw' => 1,
                'Daora Webbing' => 2,
                'Nergigante Carapace' => 1,
                'Daora Tail' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Return Stroke' => 3,
                ],
                'add' => [
                    'Freezing Stroke' => 3,
                ],
            ],
        ],
        'Daora\'s Thwartoise' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Daora\'s Casca',
            'branch' => 'Kushala Daora',
            'rarity' => 5,
            'name' => 'Tortuga Daora',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 8,
            'count_attack_3' => 2,
            'count_attack_4' => 4,
            'count_attack_5' => 2,
            'items' => [
                'Daora Horn' => 4,
                'Daora Claw' => 3,
                'Daora Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Return Stroke' => 3,
                    'Weak Slash' => 2,
                ],
                'add' => [
                    'Freezing Stroke' => 3,
                    'Gliding Slash' => 3,
                ],
            ],
        ],
    ],
];
