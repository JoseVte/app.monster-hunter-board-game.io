<?php

return [
    'name' => [
        'en' => 'Lance',
        'es' => 'Lanza',
    ],
    'description' => [
        'en' => 'After you resolve an attack card, if there are at least 3 face up attack cards with :lance_icon: on your stamina board you may discard 3 face up attack cards with :lance_icon: from your stamina board.',
        'es' => 'Después de resolver una carta de ataque, si hay al menos 3 cartas de ataque boca arriba con :lance_icon: en tu tablero de resistencia, puedes descartar 3 cartas de ataque boca arriba con :lance_icon: de tu tablero de resistencia.',
    ],
    'image' => 'weapon-types/lance.svg',
    'weapons' => [
        'Iron Lance' => [
            'default' => true,
            'branch' => 'mineral',
            'name' => 'Lanza Férrea',
            'defense' => 1,
            'count_attack_1' => 8,
            'count_attack_2' => 2,
        ],
        'Steel Lance' => [
            'parent' => 'Iron Lance',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => 'Lanza Acerada',
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
        'Chrome Lance' => [
            'parent' => 'Steel Lance',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => 'Cromolanza',
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
        'Bone Lance' => [
            'branch' => 'bone',
            'name' => 'Lanza Ósea',
            'defense' => 1,
            'count_attack_1' => 6,
            'count_attack_2' => 4,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        'Hard Bone Lance' => [
            'parent' => 'Bone Lance',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => 'Lanza Hueso Pétreo',
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
        'Heavy Bone Lance' => [
            'parent' => 'Hard Bone Lance',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => 'Lanza Hueso Pesado',
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
        'Thunder Lance' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Bone Lance',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
            'name' => 'Lanza Trueno',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_1' => 3,
            'count_attack_2' => 6,
            'count_attack_3' => 3,
            'items' => [
                'Dragonite Ore' => 2,
                'Tobi-Kadachi Electrode' => 1,
                'Tobi-Kadachi Claw' => 2,
                'Electro Sac' => 1,
                'Coral Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Mid Thrust' => 3,
                ],
                'add' => [
                    'Static Thrust' => 3,
                ],
            ],
        ],
        'Lightning Spire' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Thunder Lance',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 4,
            'name' => 'Aguja Relámpago',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_1' => 2,
            'count_attack_2' => 7,
            'count_attack_3' => 5,
            'items' => [
                'Fucium Ore' => 2,
                'Tobi-Kadachi Electrode' => 2,
                'Tobi-Kadachi Claw' => 2,
                'Thunder Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Mid Thrust' => 3,
                    'Guard Thrust' => 2,
                ],
                'add' => [
                    'Static Thrust' => 3,
                    'Static Guard' => 2,
                ],
            ],
        ],
        'Flame Lance' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Iron Lance',
            'branch' => 'Rathalos',
            'rarity' => 3,
            'name' => 'Lanza Abrasadora',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_1' => 4,
            'count_attack_2' => 4,
            'count_attack_3' => 4,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Webbing' => 2,
                'Inferno Sac' => 1,
                'Rathalos Marrow' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Counter Thrust' => 2,
                ],
                'add' => [
                    'Flaming Thrust' => 2,
                ],
            ],
        ],
        'Red Tail' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Flame Lance',
            'branch' => 'Rathalos',
            'rarity' => 4,
            'name' => 'Cola Roja',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_2' => 7,
            'count_attack_3' => 7,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Carapace' => 1,
                'Rathalos Wing' => 1,
                'Rathalos Medulla' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Counter Thrust' => 2,
                    'Guard Dash' => 2,
                ],
                'add' => [
                    'Flaming Thrust' => 2,
                    'Flaming Dash' => 2,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        'Carapace Lance' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Lance',
            'branch' => 'Barroth',
            'rarity' => 3,
            'name' => 'Lanza Acorazada',
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
        'Barroth Stinger' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Carapace Lance',
            'branch' => 'Barroth',
            'rarity' => 4,
            'name' => 'Aguijón Barroth',
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
        'Aqua Lance' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Lance',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
            'name' => 'Lanza Aqua',
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
        'Water Spike' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Aqua Lance',
            'branch' => 'Jyuratodus',
            'rarity' => 4,
            'name' => 'Punzada Acuática',
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
        'Kulu Lance' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'Iron Lance',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 3,
            'name' => 'Lanza Kulu',
            'defense' => 1,
            'count_attack_1' => 6,
            'count_attack_3' => 2,
            'count_attack_4' => 2,
            'items' => [
                'Kulu-Ya-Ku Beak' => 1,
                'Kulu-Ya-Ku Hide' => 2,
                'Kulu-Ya-Ku Scale' => 4,
                'Earth Crystal' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'High Thrust' => 3,
                ],
                'add' => [
                    'Diving Thrust' => 3,
                ],
            ],
        ],
        'Kulu Hasta' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'Kulu Lance',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 4,
            'name' => 'Pilum Kulu',
            'defense' => 1,
            'count_attack_1' => 6,
            'count_attack_3' => 4,
            'count_attack_4' => 2,
            'items' => [
                'Kulu-Ya-Ku Beak' => 2,
                'Kulu-Ya-Ku Hide' => 3,
                'Kulu-Ya-Ku Plume' => 3,
                'Boulder Bone' => 4,
            ],
            'attacks' => [
                'remove' => [
                    'High Thrust' => 3,
                    'Mid Thrust' => 2,
                ],
                'add' => [
                    'Diving Thrust' => 3,
                    'Dream Thrust' => 2,
                ],
            ],
        ],
        // NERGIGANTE EXPANSION
        'Nergal Impaler' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Iron Lance',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => 'Empaladora Nergal',
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
        'Perdition\'s Hand' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Nergal Impaler',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => 'Mano de la Perdición',
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
        // TEOSTRA EXPANSION <NONE>
        // KUSHALA EXPANSION
        'Icesteel Spear' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Iron Lance',
            'branch' => 'Kushala Daora',
            'rarity' => 4,
            'name' => 'Lanza Acero Helado',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 6,
            'count_attack_3' => 5,
            'count_attack_4' => 3,
            'items' => [
                'Daora Claw' => 1,
                'Daora Webbing' => 2,
                'Nergigante Carapace' => 1,
                'Daora Tail' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Mid Thrust' => 3,
                ],
                'add' => [
                    'Blizzard Thrust' => 3,
                ],
            ],
        ],
        'Daora\'s Fang' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Icesteel Spear',
            'branch' => 'Kushala Daora',
            'rarity' => 5,
            'name' => 'Colmillo Daora',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 5,
            'count_attack_3' => 8,
            'count_attack_4' => 2,
            'count_attack_5' => 1,
            'items' => [
                'Daora Horn' => 4,
                'Daora Claw' => 3,
                'Daora Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Mid Thrust' => 3,
                    'Guard Dash' => 2,
                ],
                'add' => [
                    'Blizzard Thrust' => 3,
                    'Frozen Dash' => 2,
                ],
            ],
        ],
        // KIRIN EXPANSION
        'Thunderspear' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Bone Lance',
            'branch' => 'Kirin',
            'rarity' => 4,
            'name' => 'Jabalina Trueno',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_2' => 5,
            'count_attack_3' => 5,
            'count_attack_4' => 2,
            'items' => [
                'Kirin Thunderhorn' => 3,
                'Kirin Hide' => 3,
                'Kirin Tail' => 1,
                'Lightcrystal' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Mid Thrust' => 4,
                ],
                'add' => [
                    'Thunder Thrust' => 4,
                ],
            ],
        ],
        'Thunderpiercer' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Thunderspear',
            'branch' => 'Kirin',
            'rarity' => 5,
            'name' => 'Venablo Trueno',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_2' => 5,
            'count_attack_3' => 5,
            'count_attack_4' => 2,
            'count_attack_5' => 2,
            'items' => [
                'Kirin Azure Horn' => 2,
                'Kirin Hide' => 2,
                'Kirin Mane' => 2,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Mid Thrust' => 4,
                    'Guard Thrust' => 2,
                ],
                'add' => [
                    'Thunder Thrust' => 4,
                    'Charged Guard' => 2,
                ],
            ],
        ],
    ],
];
