<?php

return [
    'name' => [
        'en' => 'Bow',
        'es' => 'Arco',
    ],
    'description' => '',
    'image' => 'icon_weapon_12.png',
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Iron Bow',
                'es' => 'Arco Férreo',
            ],
            'count_attack_1' => 8,
            'count_attack_2' => 4,
        ],
        [
            'parent' => 'Iron Bow',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => [
                'en' => 'Steel Bow',
                'es' => 'Arco Acerado',
            ],
            'count_attack_1' => 6,
            'count_attack_2' => 6,
            'items' => [
                'Dragonite Ore' => 1,
                'Machalite Ore' => 1,
                'Monster Bone Medium' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Feint' => 2,
                ],
                'add' => [
                    'Skilled Feint' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Steel Bow',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => [
                'en' => 'Alloy Bow',
                'es' => 'Arco de Aleación',
            ],
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
                    'Feint' => 2,
                    'Charge Shot' => 3,
                ],
                'add' => [
                    'Skilled Feint' => 2,
                    'Enhanced Charge Shot' => 3,
                ],
            ],
        ],
        [
            'branch' => 'bone',
            'name' => [
                'en' => 'Hunter\'s Bow',
                'es' => 'Arco de Cazador',
            ],
            'count_attack_1' => 6,
            'count_attack_2' => 4,
            'items' => [
                'Monster Bone Small' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 4,
                ],
                'add' => [
                    'Poison Coating' => 2,
                    'Paralysis Coating' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Hunter\'s Bow',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => [
                'en' => 'Hunter\'s Stoutbow',
                'es' => 'Arco Recio de Cazador',
            ],
            'count_attack_1' => 4,
            'count_attack_2' => 6,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 4,
                    'Shot' => 2,
                ],
                'add' => [
                    'Poison Coating' => 2,
                    'Paralysis Coating' => 2,
                    'Enhanced Shot' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Hunter\'s Stoutbow',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => [
                'en' => 'Hunter\'s Proudbow',
                'es' => 'Arco Honra de Cazador',
            ],
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
                    'Power Coating' => 4,
                    'Shot' => 2,
                    'Arc Shot' => 2,
                ],
                'add' => [
                    'Poison Coating' => 2,
                    'Paralysis Coating' => 2,
                    'Enhanced Shot' => 2,
                    'Strong Arc Shot' => 2,
                ],
            ],
        ],
        // ANCIENT FOREST
        [
            'parent' => 'Hunter\'s Bow',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
            'name' => [
                'en' => 'Pulsar Bow',
                'es' => 'Arco Púlsar',
            ],
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 5,
            'count_attack_3' => 3,
            'items' => [
                'Tobi-Kadachi Electrode' => 2,
                'Tobi-Kadachi Claw' => 2,
                'Electro Sac' => 1,
                'Coral Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 4,
                ],
                'add' => [
                    'High Power Coating' => 3,
                    'Paralysis Coating' => 1,
                ],
            ],
        ],
        [
            'parent' => 'Pulsar Bow',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 4,
            'name' => [
                'en' => 'Kadachi Strikebow',
                'es' => 'Arco de ataque Kadachi',
            ],
            'has_elemental_attacks' => true,
            'count_attack_2' => 9,
            'count_attack_3' => 3,
            'items' => [
                'Tobi-Kadachi Claw' => 2,
                'Tobi-Kadachi Scale' => 2,
                'Tobi-Kadachi Pelt' => 2,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 4,
                    'Dragon Piercer' => 1,
                    'Any Card' => 1,
                ],
                'add' => [
                    'High Power Coating' => 3,
                    'Paralysis Coating' => 1,
                    'Striking Dragon Piercer' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Hunter\'s Bow',
            'branch' => 'Anjanath',
            'rarity' => 3,
            'name' => [
                'en' => 'Blazing Bow',
                'es' => 'Arco Flameante',
            ],
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 4,
            'items' => [
                'Anjanath Scale' => 3,
                'Anjanath Fang' => 2,
                'Flame Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 4,
                ],
                'add' => [
                    'Blast Coating' => 2,
                    'Paralysis Coating' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Blazing Bow',
            'branch' => 'Anjanath',
            'rarity' => 4,
            'name' => [
                'en' => 'Anja Arch',
                'es' => 'Arco Anja',
            ],
            'has_elemental_attacks' => true,
            'count_attack_2' => 6,
            'count_attack_3' => 8,
            'items' => [
                'Anjanath Fang' => 4,
                'Anjanath Pelt' => 4,
                'Firecell Stone' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 4,
                    'Charge Shot' => 3,
                ],
                'add' => [
                    'Blast Coating' => 2,
                    'Paralysis Coating' => 2,
                    'Blazing Charge Shot' => 3,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        [
            'parent' => 'Hunter\'s Bow',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
            'name' => [
                'en' => 'Blooming Arch',
                'es' => 'Arco Floral',
            ],
            'count_attack_1' => 1,
            'count_attack_2' => 7,
            'count_attack_3' => 2,
            'items' => [
                'Pukei-Pukei Quill' => 2,
                'Pukei-Pukei Scale' => 3,
                'Poison Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 4,
                    'Shot' => 2,
                ],
                'add' => [
                    'Poison Coating' => 2,
                    'Paralysis Coating' => 2,
                    'Poisoned Shot' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Blooming Arch',
            'branch' => 'Pukei-Pukei',
            'rarity' => 4,
            'name' => [
                'en' => 'Datura String',
                'es' => 'Cordel Datura',
            ],
            'count_attack_1' => 1,
            'count_attack_2' => 7,
            'count_attack_3' => 4,
            'items' => [
                'Pukei-Pukei Scale' => 3,
                'Pukei-Pukei Wing' => 2,
                'Toxic Sac' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 4,
                    'Shot' => 6,
                ],
                'add' => [
                    'Poison Coating' => 2,
                    'Paralysis Coating' => 2,
                    'Poisoned Shot' => 2,
                    'Flared' => 4,
                ],
            ],
        ],
        [
            'parent' => 'Hunter\'s Bow',
            'branch' => 'Diablos',
            'rarity' => 3,
            'name' => [
                'en' => 'Diablos Bow',
                'es' => 'Arco Diablos',
            ],
            'count_attack_1' => 4,
            'count_attack_2' => 4,
            'count_attack_3' => 4,
            'items' => [
                'Twisted Horn' => 1,
                'Diablos Fang' => 2,
                'Diablos Shell' => 4,
                'Monster Bone Large' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 2,
                    'Shot' => 2,
                ],
                'add' => [
                    'Paralysis Coating' => 2,
                    'Rending Arrows' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Diablos Bow',
            'branch' => 'Diablos',
            'rarity' => 4,
            'name' => [
                'en' => 'Diablos Coilbender',
                'es' => 'Doblamallas Diablos',
            ],
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
                    'Power Coating' => 2,
                    'Shot' => 2,
                    'Charge Sidestep' => 2,
                ],
                'add' => [
                    'Paralysis Coating' => 2,
                    'Rending Arrows' => 2,
                    'Rapid Dash' => 2,
                ],
            ],
        ],
        // KULU YA KU EXPANSION
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Iron Bow',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Whisper',
                'es' => 'Susurro Nergal',
            ],
            'has_elemental_attacks' => true,
            'count_attack_2' => 3,
            'count_attack_3' => 7,
            'count_attack_4' => 2,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 4,
                ],
                'add' => [
                    'Dragon Coating' => 4,
                ],
            ],
        ],
        [
            'parent' => 'Nergal Whisper',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Doom\'s Shaft',
                'es' => 'Mástil de Condenación',
            ],
            'has_elemental_attacks' => true,
            'count_attack_2' => 5,
            'count_attack_3' => 6,
            'count_attack_4' => 3,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 4,
                    'Charged Shot' => 3,
                ],
                'add' => [
                    'Dragon Coating' => 4,
                    'Razor Shot' => 3,
                ],
            ],
        ],
        // KUSHALA EXPANSION
    ],
];
