<?php

return [
    'name' => [
        'en' => 'Sword & Shield',
        'es' => 'Espada y Escudo',
    ],
    'image' => 'icon_weapon_03.png',
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Hunter\'s Knife',
                'es' => 'Cuchillo de cazador',
            ],
            'count_attack_1' => 8,
            'count_attack_2' => 2,
        ],
        [
            'parent' => 'Hunter\'s Knife',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => [
                'en' => 'Steel Knife',
                'es' => 'Cuchillo Acerado',
            ],
            'count_attack_1' => 6,
            'count_attack_2' => 5,
            'count_attack_3' => 1,
            'items' => [
                'Dragonite Ore' => 1,
                'Machalite Ore' => 1,
                'Monster Bone Medium' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Advancing Slash' => 2,
                ],
                'add' => [
                    'Enhanced Advancing Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Steel Knife',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => [
                'en' => 'Chrome Slicer',
                'es' => 'Cromorebanadora',
            ],
            'defense' => 1,
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
                    'Advancing Slash' => 2,
                    'Any Card' => 2,
                ],
                'add' => [
                    'Enhanced Advancing Slash' => 2,
                    'Helm Splitter' => 2,
                ],
            ],
        ],
        [
            'branch' => 'bone',
            'name' => [
                'en' => 'Bone Kukri',
                'es' => 'Kukri Óseo',
            ],
            'count_attack_1' => 5,
            'count_attack_2' => 4,
            'count_attack_3' => 1,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        [
            'parent' => 'Bone Kukri',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => [
                'en' => 'Chief Kukri',
                'es' => 'Kukri Jefe',
            ],
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 2,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Shield Bash' => 2,
                ],
                'add' => [
                    'Strong Shield Bash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Chief Kukri',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => [
                'en' => 'Grand Barong',
                'es' => 'Grand Barong',
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
                    'Shield Bash' => 2,
                    'Chop' => 2,
                ],
                'add' => [
                    'Strong Shield Bash' => 2,
                    'Chop Reversal' => 2,
                ],
            ],
        ],
        // ANCIENT FOREST
        [
            'parent' => 'Bone Kukri',
            'branch' => 'Great Jagras',
            'rarity' => 3,
            'name' => [
                'en' => 'Jagras Edge',
                'es' => 'Filo Jagras',
            ],
            'defense' => 1,
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 2,
            'items' => [
                'Great Jagras Claw' => 2,
                'Great Jagras Hide' => 1,
                'Great Jagras Scale' => 2,
                'Sharp Claw' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Lateral Slash' => 2,
                ],
                'add' => [
                    'Glutton Lateral Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Jagras Edge',
            'branch' => 'Great Jagras',
            'rarity' => 4,
            'name' => [
                'en' => 'Jagras Garotte',
                'es' => 'Garrote Jagras',
            ],
            'defense' => 1,
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 3,
            'count_attack_4' => 1,
            'items' => [
                'Great Jagras Scale' => 3,
                'Great Jagras Claw' => 1,
                'Great Jagras Mane' => 2,
                'Piercing Claw' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Lateral Slash' => 2,
                    'Rising Slash' => 1,
                    'Any Card' => 1,
                ],
                'add' => [
                    'Glutton Lateral Slash' => 2,
                    'Jump Rising Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Hunter\'s Knife',
            'branch' => 'Rathalos',
            'rarity' => 3,
            'name' => [
                'en' => 'Flame Knife',
                'es' => 'Cuchillo Abrasador',
            ],
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 4,
            'items' => [
                'Rathalos Scale' => 1,
                'Rathalos Tail' => 2,
                'Rathalos Plate' => 1,
                'Inferno Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Advancing Slash' => 2,
                ],
                'add' => [
                    'Advancing Double Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Flame Knife',
            'branch' => 'Rathalos',
            'rarity' => 4,
            'name' => [
                'en' => 'Heat Edge',
                'es' => 'Filo Cálido',
            ],
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_1' => 1,
            'count_attack_2' => 7,
            'count_attack_3' => 5,
            'count_attack_4' => 1,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Carapace' => 2,
                'Rathalos Wing' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Advancing Slash' => 2,
                    'Sword & Shield Combo' => 2,
                ],
                'add' => [
                    'Advancing Double Slash' => 2,
                    'Blazing Combo' => 2,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        [
            'parent' => 'Bone Kukri',
            'branch' => 'Barroth',
            'rarity' => 3,
            'name' => [
                'en' => 'Carapace Edge',
                'es' => 'Filo Acorazado',
            ],
            'defense' => 1,
            'count_attack_2' => 8,
            'count_attack_3' => 2,
            'items' => [
                'Barroth Claw' => 1,
                'Barroth Shell' => 3,
                'Barroth Ridge' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Advancing Slash' => 2,
                ],
                'add' => [
                    'Powerful Double Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Carapace Edge',
            'branch' => 'Barroth',
            'rarity' => 4,
            'name' => [
                'en' => 'Barroth Club',
                'es' => 'Garrote Barroth',
            ],
            'defense' => 1,
            'count_attack_2' => 8,
            'count_attack_3' => 4,
            'items' => [
                'Barroth Claw' => 2,
                'Barroth Carapace' => 3,
                'Barroth Ridge' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Advancing Slash' => 2,
                    'Chop' => 2,
                ],
                'add' => [
                    'Powerful Double Slash' => 2,
                    'Steadfast Chop' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Hunter\'s Knife',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
            'name' => [
                'en' => 'Blooming Knife',
                'es' => 'Cuchillo Floral',
            ],
            'defense' => 1,
            'count_attack_1' => 1,
            'count_attack_2' => 8,
            'count_attack_3' => 3,
            'items' => [
                'Pukei-Pukei Quill' => 2,
                'Pukei-Pukei Scale' => 2,
                'Poison Sac' => 1,
                'Pukei-Pukei Tail' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Round Slash' => 1,
                    'Rising Slash' => 1,
                ],
                'add' => [
                    'Poison Spin Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Blooming Knife',
            'branch' => 'Pukei-Pukei',
            'rarity' => 4,
            'name' => [
                'en' => 'Datura Blossom',
                'es' => 'Flor Datura',
            ],
            'defense' => 1,
            'count_attack_1' => 1,
            'count_attack_2' => 9,
            'count_attack_3' => 4,
            'items' => [
                'Pukei-Pukei Scale' => 2,
                'Pukei-Pukei Wing' => 2,
                'Toxic Sac' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Round Slash' => 1,
                    'Rising Slash' => 1,
                    'Any Card' => 3,
                ],
                'add' => [
                    'Poison Spin Slash' => 2,
                    'Toxicity' => 3,
                ],
            ],
        ],
        // KULU YA KU EXPANSION <NONE>
        // TEOSTRA EXPANSION
        [
            'parent' => 'Hunter\'s Knife',
            'branch' => 'Teostra',
            'rarity' => 4,
            'name' => [
                'en' => 'Teostra\'s Spada',
                'es' => 'Spada Teostra',
            ],
            'defense' => 1,
            'count_attack_2' => 4,
            'count_attack_3' => 7,
            'count_attack_4' => 3,
            'items' => [
                'Teostra Claw' => 1,
                'Teostra Mane' => 1,
                'Teostra Carapace' => 2,
                'Teostra Powder' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Guard Up' => 2,
                    'Any Card' => 1,
                ],
                'add' => [
                    'Teostra\'s Guard' => 3,
                ],
            ],
        ],
        [
            'parent' => 'Teostra\'s Spada',
            'branch' => 'Teostra',
            'rarity' => 5,
            'name' => [
                'en' => 'Teostra\'s Emblem',
                'es' => 'Emblema Teostra',
            ],
            'defense' => 1,
            'count_attack_2' => 7,
            'count_attack_3' => 5,
            'count_attack_4' => 3,
            'count_attack_5' => 1,
            'items' => [
                'Teostra Horn' => 3,
                'Teostra Claw' => 2,
                'Teostra Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Guard Up' => 2,
                    'Any Card' => 4,
                ],
                'add' => [
                    'Teostra\'s Guard' => 3,
                    'Fearsome Slice' => 3,
                ],
            ],
        ],
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Hunter\'s Knife',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Jack',
                'es' => 'Jack Nergal',
            ],
            'defense' => 1,
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
                    'Guard Up' => 2,
                ],
                'add' => [
                    'Scaled Guard' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Nergal Jack',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Eradication Vanguard',
                'es' => 'Vanguardia Erradicadora',
            ],
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 5,
            'count_attack_3' => 5,
            'count_attack_4' => 3,
            'count_attack_5' => 1,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Guard Up' => 2,
                    'Chop' => 2,
                ],
                'add' => [
                    'Scaled Guard' => 2,
                    'Draconic Slash' => 2,
                ],
            ],
        ],
        // KUSHALA EXPANSION
    ],
];
