<?php

return [
    'name' => [
        'en' => 'Lance',
        'es' => 'Lanza',
    ],
    'description' => [
        'en' => 'After you resolve an attack card, if there are at least 3 face up attack cards with :lance_icon: on your stamina board you may discard 3 face up attack cards with lance_icon: from your stamina board.',
        'es' => 'Después de resolver una carta de ataque, si hay al menos 3 cartas de ataque boca arriba con :lance_icon: en tu tablero de resistencia, puedes descartar 3 cartas de ataque boca arriba con :lance_icon: de tu tablero de resistencia.',
    ],
    'image' => 'icon_weapon_07.png',
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Iron Lance',
                'es' => 'Lanza Férrea',
            ],
            'defense' => 1,
            'count_attack_1' => 8,
            'count_attack_2' => 2,
        ],
        [
            'parent' => 'Iron Lance',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => [
                'en' => 'Steel Lance',
                'es' => 'Lanza Acerada',
            ],
            'defense' => 1,
            'count_attack_1' => 6,
            'count_attack_2' => 6,
            'items' => [
                'Dragonite Ore' => 1,
                'Machalite Ore' => 1,
                'Monster Bone Medium' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Mid Thrust' => 3,
                ],
                'add' => [
                    'Long Thrust' => 3,
                ],
            ],
        ],
        [
            'parent' => 'Steel Lance',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => [
                'en' => 'Chrome Lance',
                'es' => 'Cromolanza',
            ],
            'defense' => 1,
            'count_attack_1' => 4,
            'count_attack_2' => 6,
            'count_attack_3' => 2,
            'items' => [
                'Fucium Ore' => 2,
                'Carbalite Ore' => 2,
                'Dragonite Ore' => 3,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Mid Thrust' => 3,
                    'Guard Thrust' => 2,
                ],
                'add' => [
                    'Long Thrust' => 3,
                    'Long Guard' => 2,
                ],
            ],
        ],
        [
            'branch' => 'bone',
            'name' => [
                'en' => 'Bone Lance',
                'es' => 'Lanza Ósea',
            ],
            'defense' => 1,
            'count_attack_1' => 6,
            'count_attack_2' => 4,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        [
            'parent' => 'Bone Lance',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => [
                'en' => 'Hard Bone Lance',
                'es' => 'Lanza Hueso Pétreo',
            ],
            'defense' => 1,
            'count_attack_1' => 4,
            'count_attack_2' => 6,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'High Thrust' => 3,
                ],
                'add' => [
                    'High Lunge' => 3,
                ],
            ],
        ],
        [
            'parent' => 'Hard Bone Lance',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => [
                'en' => 'Heavy Bone Lance',
                'es' => 'Lanza Hueso Pesado',
            ],
            'defense' => 1,
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
                    'High Thrust' => 3,
                    'Guard Dash' => 2,
                ],
                'add' => [
                    'High Lunge' => 3,
                    'Guard Sprint' => 2,
                ],
            ],
        ],
        // ANCIENT FOREST
        // WILDSPIRE WASTE
        [
            'parent' => 'Bone Lance',
            'branch' => 'Barroth',
            'rarity' => 3,
            'name' => [
                'en' => 'Carapace Lance',
                'es' => 'Lanza Acorazada',
            ],
            'defense' => 1,
            'count_attack_1' => 2,
            'count_attack_2' => 5,
            'count_attack_3' => 3,
            'items' => [
                'Barroth Claw' => 1,
                'Barroth Shell' => 3,
                'Barroth Ridge' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Counter Thrust' => 2,
                ],
                'add' => [
                    'Armoured Thrust' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Carapace Lance',
            'branch' => 'Barroth',
            'rarity' => 4,
            'name' => [
                'en' => 'Barroth Stinger',
                'es' => 'Aguijón Barroth',
            ],
            'defense' => 1,
            'count_attack_2' => 9,
            'count_attack_3' => 3,
            'items' => [
                'Barroth Claw' => 2,
                'Barroth Carapace' => 3,
                'Barroth Ridge' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Counter Thrust' => 2,
                    'Guard Thrust' => 2,
                ],
                'add' => [
                    'Armoured Thrust' => 2,
                    'Armoured Guard' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Bone Lance',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
            'name' => [
                'en' => 'Aqua Lance',
                'es' => 'Lanza Aqua',
            ],
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 4,
            'count_attack_3' => 4,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Shell' => 2,
                'Jyuratodus Scale' => 3,
                'Aqua Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'High Thrust' => 3,
                ],
                'add' => [
                    'Aqua Thrust' => 3,
                ],
            ],
        ],
        [
            'parent' => 'Aqua Lance',
            'branch' => 'Jyuratodus',
            'rarity' => 4,
            'name' => [
                'en' => 'Water Spike',
                'es' => 'Punzada Acuática',
            ],
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_1' => 6,
            'count_attack_3' => 6,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Carapace' => 2,
                'Jyuratodus Scale' => 2,
                'Aqua Sac' => 1,
                'Gajau Scale' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'High Thrust' => 3,
                    'Guard Bash' => 2,
                ],
                'add' => [
                    'Aqua Thrust' => 3,
                    'Aqua Bash' => 2,
                ],
            ],
        ],
        // KULU YA KU EXPANSION
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Iron Lance',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Impaler',
                'es' => 'Empaladora Nergal',
            ],
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 5,
            'count_attack_3' => 4,
            'count_attack_4' => 3,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'High Thrust' => 3,
                ],
                'add' => [
                    'Dragon Thrust' => 3,
                ],
            ],
        ],
        [
            'parent' => 'Nergal Judicator',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Perdition\'s Hand',
                'es' => 'Mano de la Perdición',
            ],
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 6,
            'count_attack_3' => 4,
            'count_attack_4' => 2,
            'count_attack_5' => 2,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'High Thrust' => 3,
                    'Guard Bash' => 2,
                ],
                'add' => [
                    'Dragon Thrust' => 3,
                    'Dragon Guard' => 2,
                ],
            ],
        ],
        // KUSHALA EXPANSION
    ],
];
