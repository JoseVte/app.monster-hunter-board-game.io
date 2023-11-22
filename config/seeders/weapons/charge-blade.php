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
        // ANCIENT FOREST
        // WILDSPIRE WASTE
        // KULU YA KU EXPANSION
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
