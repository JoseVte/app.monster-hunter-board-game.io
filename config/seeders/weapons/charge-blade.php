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
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Proto Commission Axe',
                'es' => 'Protohacha Comitiva',
            ],
            'count_attack_1' => 8,
            'count_attack_2' => 4,
        ],
        [
            'parent' => 'Proto Commission Axe',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => [
                'en' => 'Elite Commission Axe',
                'es' => 'Hacha Élite Comitiva',
            ],
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
        [
            'parent' => 'Elite Commission Axe',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => [
                'en' => 'Chrome Guardian',
                'es' => 'Cromoguardián',
            ],
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
        [
            'branch' => 'bone',
            'name' => [
                'en' => 'Bone Strongarm',
                'es' => 'Aspa Ósea',
            ],
            'count_attack_1' => 5,
            'count_attack_3' => 5,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        [
            'parent' => 'Bone Strongarm',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => [
                'en' => 'Hard Bone Strongarm',
                'es' => 'Aspa Hueso Pétreo',
            ],
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
        [
            'parent' => 'Hard Bone Strongarm',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => [
                'en' => 'Mighty Strongarm',
                'es' => 'Aspa Recia',
            ],
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
        [
            'parent' => 'Bone Strongarm',
            'branch' => 'Great Jagras',
            'rarity' => 3,
            'name' => [
                'en' => 'Jagras Strongarm',
                'es' => 'Aspa Jagras',
            ],
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
        [
            'parent' => 'Jagras Strongarm',
            'branch' => 'Great Jagras',
            'rarity' => 4,
            'name' => [
                'en' => 'Jagras Escudo',
                'es' => 'Escudo Jagras',
            ],
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
        [
            'parent' => 'Bone Strongarm',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
            'name' => [
                'en' => 'Pulsar Strongarm',
                'es' => 'Aspa Púlsar',
            ],
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
        [
            'parent' => 'Pulsar Strongarm',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 4,
            'name' => [
                'en' => 'Kadachi Kaina',
                'es' => 'Kaina Kadachi',
            ],
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
        [
            'parent' => 'Proto Commission Axe',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
            'name' => [
                'en' => 'Mudslide Blade',
                'es' => 'Hoja Enfangada',
            ],
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
        [
            'parent' => 'Mudslide Blade',
            'branch' => 'Jyuratodus',
            'rarity' => 4,
            'name' => [
                'en' => 'Jyura Depth',
                'es' => 'Profundidad Jyura',
            ],
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
        [
            'parent' => 'Bone Strongarm',
            'branch' => 'Diablos',
            'rarity' => 3,
            'name' => [
                'en' => 'Diablos Wall',
                'es' => 'Muro Diablos',
            ],
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
        [
            'parent' => 'Diablos Wall',
            'branch' => 'Diablos',
            'rarity' => 4,
            'name' => [
                'en' => 'Diablos Tyrannis',
                'es' => 'Tyrannis Diablos',
            ],
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
        [
            'parent' => 'Proto Commission Axe',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Lacerator',
                'es' => 'Azote Nergal',
            ],
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
        [
            'parent' => 'Nergal Lacerator',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Devastation\'s Thorns',
                'es' => 'Espinas de Devastación',
            ],
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
        // KUSHALA EXPANSION
    ],
];
