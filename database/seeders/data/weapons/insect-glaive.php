<?php

return [
    'name' => [
        'en' => 'Insect Glaive',
        'es' => 'Glaive Insecto',
    ],
    'description' => [
        'en' => 'During set up, shuffle the three Kinsect: Harvest Extract cards and place them face down in a row above your stamina board.<br>
At the start of your turn, flip the leftmost face down Kinsect: Harvest Extract card face up. When you play an attack card with a :kinsect_icon_1: :kinsect_icon_2: :kinsect_icon_3: matching a face up Kinsect: Harvest Extract card, it gains the bonus effect from the matching Kinsect: Harvest Extract card.<br>
If you have three face up Kinsect: Harvest Extract cards at the end of your turn, pick them all up, shuffle them, and place them face down in a row above your stamina board.',
        'es' => 'Durante la configuración, baraja las tres cartas de Kinsect: Harvest Extract y colócalas boca abajo en una fila sobre tu tablero de resistencia.<br>
Al comienzo de tu turno, voltea la carta Kinsect: Harvest Extract boca abajo boca arriba. Cuando juegas una carta de ataque con una :kinsect_icon_1: :kinsect_icon_2: :kinsect_icon_3: que coincide con una carta de Kinsect: Harvest Extract boca arriba, obtiene el efecto de bonificación de la carta de Kinsect: Harvest Extract correspondiente.<br>
Si tienes tres cartas boca arriba de Kinsect: Harvest Extract al final de tu turno, recógelas todas, barájalas y colócalas boca abajo en una fila sobre tu tablero de resistencia.',
    ],
    'image' => 'icon_weapon_11.png',
    'weapons' => [
        'Iron Blade' => [
            'default' => true,
            'branch' => 'mineral',
            'name' => 'Vara Férrea',
            'count_attack_1' => 10,
            'count_attack_2' => 2,
        ],
        'Steel Blade' => [
            'parent' => 'Iron Blade',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => 'Hoja Acerada',
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
                    'Wide Sweep' => 3,
                ],
                'add' => [
                    'Arced Sweep' => 3,
                ],
            ],
        ],
        'Chrome Blade' => [
            'parent' => 'Steel Blade',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => 'Cromoespada',
            'defense' => 1,
            'count_attack_1' => 6,
            'count_attack_2' => 4,
            'count_attack_3' => 2,
            'items' => [
                'Fucium Ore' => 2,
                'Carbalite Ore' => 2,
                'Dragonite Ore' => 3,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Wide Sweep' => 3,
                    'Thrust' => 2,
                ],
                'add' => [
                    'Arced Sweep' => 3,
                    'Vicious Thrust' => 3,
                ],
            ],
        ],
        'Bone Rod' => [
            'branch' => 'bone',
            'name' => 'Vara Ósea',
            'count_attack_1' => 3,
            'count_attack_2' => 3,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        'Hard Bone Rod' => [
            'parent' => 'Bone Rod',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => 'Vara Hueso Pétreo',
            'count_attack_1' => 5,
            'count_attack_2' => 4,
            'count_attack_3' => 1,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Jumping Slash' => 2,
                ],
                'add' => [
                    'Bounding Slash' => 2,
                ],
            ],
        ],
        'Aerial Rod' => [
            'parent' => 'Hard Bone Rod',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => 'Vara Aérea',
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
                    'Jumping Slash' => 2,
                    'Reaping Slash' => 2,
                ],
                'add' => [
                    'Bounding Slash' => 2,
                    'Deadly Slash' => 2,
                ],
            ],
        ],
        // ANCIENT FOREST
        'Flammenkaefer' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Bone Rod',
            'branch' => 'Anjanath',
            'rarity' => 3,
            'name' => 'Flammenkaefer',
            'count_attack_1' => 2,
            'count_attack_2' => 7,
            'count_attack_3' => 3,
            'items' => [
                'Anjanath Fang' => 2,
                'Anjanath Scale' => 1,
                'Anjanath Pelt' => 2,
                'Flame Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Vault' => 3,
                ],
                'add' => [
                    'Charged Vault' => 3,
                ],
            ],
        ],
        'Gnashing Flammenkaefer' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Flammenkaefer',
            'branch' => 'Anjanath',
            'rarity' => 4,
            'name' => 'Flammenkaefer Mordiente',
            'has_elemental_attacks' => true,
            'count_attack_1' => 5,
            'count_attack_2' => 2,
            'count_attack_3' => 7,
            'items' => [
                'Anjanath Pelt' => 4,
                'Anjanath Nosebone' => 4,
                'Firecell Stone' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Vault' => 3,
                    'Jump Advancing Slash' => 2,
                ],
                'add' => [
                    'Charged Vault' => 3,
                    'Blaze Advancing Slash' => 2,
                ],
            ],
        ],
        'Flame Glaive' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Iron Blade',
            'branch' => 'Rathalos',
            'rarity' => 3,
            'name' => 'Glaive Abrasador',
            'has_elemental_attacks' => true,
            'count_attack_1' => 5,
            'count_attack_2' => 2,
            'count_attack_3' => 5,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Webbing' => 2,
                'Inferno Sac' => 1,
                'Rathalos Marrow' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Jumping Slash' => 2,
                ],
                'add' => [
                    'Burning Slash' => 2,
                ],
            ],
        ],
        'Rathmaul' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Flame Glaive',
            'branch' => 'Rathalos',
            'rarity' => 4,
            'name' => 'Rathmaul',
            'has_elemental_attacks' => true,
            'count_attack_1' => 4,
            'count_attack_2' => 3,
            'count_attack_3' => 7,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Carapace' => 1,
                'Rathalos Wing' => 1,
                'Rathalos Medulla' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Jumping Slash' => 2,
                    'Thrust' => 2,
                ],
                'add' => [
                    'Burning Slash' => 2,
                    'Molten Slash' => 2,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        'Blooming Glaive' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Iron Blade',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
            'name' => 'Glaive Floral',
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 4,
            'items' => [
                'Pukei-Pukei Quill' => 2,
                'Pukei-Pukei Scale' => 2,
                'Poison Sac' => 1,
                'Pukei-Pukei Tail' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash Combo' => 2,
                ],
                'add' => [
                    'Poisoned Slash Combo' => 2,
                ],
            ],
        ],
        'Datura Blade' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Blooming Glaive',
            'branch' => 'Pukei-Pukei',
            'rarity' => 4,
            'name' => 'Filo Datura',
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 7,
            'items' => [
                'Pukei-Pukei Scale' => 2,
                'Pukei-Pukei Wing' => 2,
                'Toxic Sac' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash Combo' => 2,
                    'Descending Slash' => 2,
                ],
                'add' => [
                    'Poisoned Slash Combo' => 2,
                    'Poisoned Slash' => 2,
                ],
            ],
        ],
        'Diablos Rod' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Rod',
            'branch' => 'Diablos',
            'rarity' => 3,
            'name' => 'Vara Diablos',
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
                    'Wide Sweep' => 3,
                ],
                'add' => [
                    'Brutal Sweep' => 3,
                ],
            ],
        ],
        'Tyrannis Glaive' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Diablos Rod',
            'branch' => 'Diablos',
            'rarity' => 4,
            'name' => 'Glaive Tirana',
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 6,
            'items' => [
                'Majestic Horn' => 2,
                'Diablos Carapace' => 3,
                'Diablos Ridge' => 2,
                'Blos Medulla' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Wide Sweep' => 3,
                    'Tornado Slash' => 2,
                ],
                'add' => [
                    'Brutal Sweep' => 3,
                    'Annihilating Tornado Slash' => 2,
                ],
            ],
        ],
        // KULU YA KU EXPANSION
        'Kulu Blade' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'Iron Blade',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 3,
            'name' => 'Hoja Kulu',
            'count_attack_1' => 4,
            'count_attack_2' => 5,
            'count_attack_3' => 5,
            'items' => [
                'Kulu-Ya-Ku Beak' => 1,
                'Kulu-Ya-Ku Hide' => 2,
                'Kulu-Ya-Ku Scale' => 4,
                'Earth Crystal' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Reaping Slash' => 2,
                ],
                'add' => [
                    'Reaching Slash' => 2,
                ],
            ],
        ],
        'Ya-Ku Wrath' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'Kulu Blade',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 4,
            'name' => 'Ira Ya-Ku',
            'count_attack_1' => 5,
            'count_attack_2' => 3,
            'count_attack_3' => 8,
            'items' => [
                'Kulu-Ya-Ku Beak' => 2,
                'Kulu-Ya-Ku Hide' => 3,
                'Kulu-Ya-Ku Plume' => 3,
                'Boulder Bone' => 4,
            ],
            'attacks' => [
                'remove' => [
                    'Reaping Slash' => 2,
                    'Wide Sweep' => 3,
                ],
                'add' => [
                    'Reaching Slash' => 2,
                    'Random Sweep' => 3,
                ],
            ],
        ],
        // NERGIGANTE EXPANSION
        'Nergal Reaper' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Iron Blade',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => 'Choque Nergal',
            'count_attack_1' => 2,
            'count_attack_2' => 4,
            'count_attack_3' => 5,
            'count_attack_4' => 1,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'White Kinsect: Harvest Extract' => 1,
                ],
                'add' => [
                    'Nergigante Kinsect: Harvest Extract' => 1,
                ],
            ],
        ],
        'Catastrophe\'s Light' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Nergal Reaper',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => 'Catástrofe Regia',
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
                    'White Kinsect: Harvest Extract' => 1,
                    'Wide Sweep' => 3,
                ],
                'add' => [
                    'Nergigante Kinsect: Harvest Extract' => 1,
                    'Crushing Sweep' => 3,
                ],
            ],
        ],
        // TEOSTRA EXPANSION <NONE>
        // KUSHALA EXPANSION
        'Daora\'s Entom' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Iron Blade',
            'branch' => 'Kushala Daora',
            'rarity' => 4,
            'name' => 'Éntomo Daora',
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 7,
            'count_attack_3' => 3,
            'count_attack_4' => 2,
            'items' => [
                'Daora Claw' => 1,
                'Daora Webbing' => 2,
                'Nergigante Carapace' => 1,
                'Daora Tail' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'White Kinsect: Harvest Extract' => 1,
                ],
                'add' => [
                    'Kushala Daora Kinsect: Harvest Extract' => 1,
                ],
            ],
        ],
        'Daora\'s Tethidine' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Daora\'s Entom',
            'branch' => 'Kushala Daora',
            'rarity' => 5,
            'name' => 'Tetidina Daora',
            'has_elemental_attacks' => true,
            'count_attack_2' => 8,
            'count_attack_3' => 4,
            'count_attack_4' => 4,
            'items' => [
                'Daora Horn' => 4,
                'Daora Claw' => 3,
                'Daora Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'White Kinsect: Harvest Extract' => 1,
                    'Reaping Slash' => 2,
                ],
                'add' => [
                    'Kushala Daora Kinsect: Harvest Extract' => 1,
                    'Brittle Slash' => 2,
                ],
            ],
        ],
        // KIRIN EXPANSION
        'Azure Rod' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Bone Rod',
            'branch' => 'Kirin',
            'rarity' => 4,
            'name' => 'Relámpago Cerúleo',
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 3,
            'count_attack_4' => 1,
            'items' => [
                'Kirin Thunderhorn' => 3,
                'Kirin Hide' => 3,
                'Kirin Tail' => 1,
                'Lightcrystal' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Wide Sweep' => 3,
                ],
                'add' => [
                    'Thunder Sweep' => 3,
                ],
            ],
        ],
        'Verdant Levin' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Azure Rod',
            'branch' => 'Kirin',
            'rarity' => 5,
            'name' => 'Levin Verdeante',
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 3,
            'count_attack_4' => 2,
            'items' => [
                'Kirin Azure Horn' => 2,
                'Kirin Hide' => 2,
                'Kirin Mane' => 2,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Wide Sweep' => 3,
                    'Vault' => 3,
                ],
                'add' => [
                    'Thunder Sweep' => 3,
                    'Lightning Step' => 3,
                ],
            ],
        ],
    ],
];
