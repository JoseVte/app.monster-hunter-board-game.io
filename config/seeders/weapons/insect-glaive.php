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
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Iron Blade',
                'es' => 'Vara Férrea',
            ],
            'count_attack_1' => 10,
            'count_attack_2' => 2,
        ],
        [
            'parent' => 'Iron Blade',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => [
                'en' => 'Steel Blade',
                'es' => 'Hoja Acerada',
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
                    'Wide Sweep' => 3,
                ],
                'add' => [
                    'Arced Sweep' => 3,
                ],
            ],
        ],
        [
            'parent' => 'Steel Blade',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => [
                'en' => 'Chrome Blade',
                'es' => 'Cromoespada',
            ],
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
        [
            'branch' => 'bone',
            'name' => [
                'en' => 'Bone Rod',
                'es' => 'Vara Ósea',
            ],
            'count_attack_1' => 3,
            'count_attack_2' => 3,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        [
            'parent' => 'Bone Rod',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => [
                'en' => 'Hard Bone Rod',
                'es' => 'Vara Hueso Pétreo',
            ],
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
        [
            'parent' => 'Hard Bone Rod',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => [
                'en' => 'Aerial Rod',
                'es' => 'Vara Aérea',
            ],
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
        [
            'parent' => 'Bone Rod',
            'branch' => 'Anjanath',
            'rarity' => 3,
            'name' => [
                'en' => 'Flammenkaefer',
                'es' => 'Flammenkaefer',
            ],
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
        [
            'parent' => 'Flammenkaefer',
            'branch' => 'Anjanath',
            'rarity' => 4,
            'name' => [
                'en' => 'Gnashing Flammenkaefer',
                'es' => 'Flammenkaefer Mordiente',
            ],
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
        [
            'parent' => 'Iron Blade',
            'branch' => 'Rathalos',
            'rarity' => 3,
            'name' => [
                'en' => 'Flame Glaive',
                'es' => 'Glaive Abrasador',
            ],
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
        [
            'parent' => 'Flame Glaive',
            'branch' => 'Rathalos',
            'rarity' => 4,
            'name' => [
                'en' => 'Rathmaul',
                'es' => 'Rathmaul',
            ],
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
        [
            'parent' => 'Iron Blade',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
            'name' => [
                'en' => 'Blooming Glaive',
                'es' => 'Glaive Floral',
            ],
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
        [
            'parent' => 'Blooming Glaive',
            'branch' => 'Pukei-Pukei',
            'rarity' => 4,
            'name' => [
                'en' => 'Datura Blade',
                'es' => 'Filo Datura',
            ],
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
        [
            'parent' => 'Bone Rod',
            'branch' => 'Diablos',
            'rarity' => 3,
            'name' => [
                'en' => 'Diablos Rod',
                'es' => 'Vara Diablos',
            ],
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
        [
            'parent' => 'Diablos Rod',
            'branch' => 'Diablos',
            'rarity' => 4,
            'name' => [
                'en' => 'Tyrannis Glaive',
                'es' => 'Glaive Tirana',
            ],
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
        [
            'parent' => 'Iron Blade',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 3,
            'name' => [
                'en' => 'Kulu Blade',
                'es' => 'Hoja Kulu',
            ],
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
        [
            'parent' => 'Kulu Blade',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 4,
            'name' => [
                'en' => 'Ya-Ku Wrath',
                'es' => 'Ira Ya-Ku',
            ],
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
        [
            'parent' => 'Iron Blade',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Reaper',
                'es' => 'Choque Nergal',
            ],
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
        [
            'parent' => 'Nergal Reaper',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Catastrophe\'s Light',
                'es' => 'Catástrofe Regia',
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
                    'White Kinsect: Harvest Extract' => 1,
                    'Wide Sweep' => 3,
                ],
                'add' => [
                    'Nergigante Kinsect: Harvest Extract' => 1,
                    'Crushing Sweep' => 3,
                ],
            ],
        ],
        // KUSHALA EXPANSION
    ],
];
