<?php

return [
    'name' => [
        'en' => 'Great Sword',
        'es' => 'Gran Espada',
    ],
    'description' => '',
    'image' => 'icon_weapon_01.png',
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Buster Sword',
                'es' => 'Espada Cazadora',
            ],
            'count_attack_1' => 7,
            'count_attack_2' => 4,
            'count_attack_3' => 1,
        ],
        [
            'parent' => 'Buster Sword',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => [
                'en' => 'Buster Blade',
                'es' => 'Hoja Cazadora',
            ],
            'count_attack_1' => 4,
            'count_attack_2' => 6,
            'count_attack_3' => 2,
            'items' => [
                'Dragonite Ore' => 1,
                'Machalite Ore' => 1,
                'Monster Bone Medium' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Jumping Slash' => 2,
                ],
                'add' => [
                    'Enhanced Jumping Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Buster Blade',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => [
                'en' => 'Chrome Razor',
                'es' => 'Cromocuchilla',
            ],
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 4,
            'items' => [
                'Fucium Ore' => 2,
                'Carbalite Ore' => 2,
                'Dragonite Ore' => 3,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Jumping Slash' => 2,
                    'Wide Slash' => 2,
                ],
                'add' => [
                    'Enhanced Jumping Slash' => 2,
                    'Heavy Slice' => 2,
                ],
            ],
        ],
        [
            'branch' => 'bone',
            'name' => [
                'en' => 'Bone Blade',
                'es' => 'Espadón Óseo',
            ],
            'count_attack_1' => 5,
            'count_attack_2' => 3,
            'count_attack_3' => 2,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        [
            'parent' => 'Bone Blade',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => [
                'en' => 'Bone Slasher',
                'es' => 'Decapitadora Ósea',
            ],
            'count_attack_1' => 2,
            'count_attack_2' => 5,
            'count_attack_3' => 3,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Any Card' => 1,
                ],
                'add' => [
                    'Greater Sword Block' => 1,
                ],
            ],
        ],
        [
            'parent' => 'Bone Slasher',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => [
                'en' => 'Giant Jawblade',
                'es' => 'Filo Mandibular',
            ],
            'count_attack_1' => 2,
            'count_attack_2' => 4,
            'count_attack_3' => 4,
            'items' => [
                'Monster Hardbone' => 2,
                'Monster Keenbone' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Any Card' => 1,
                    'Overhead Slam' => 4,
                ],
                'add' => [
                    'Greater Sword Block' => 1,
                    'Enhanced Overhead Slam' => 4,
                ],
            ],
        ],
        // ANCIENT FOREST
        [
            'parent' => 'Buster Sword',
            'branch' => 'Great Jagras',
            'rarity' => 3,
            'name' => [
                'en' => 'Jagras Blade',
                'es' => 'Espadón Jagras',
            ],
            'count_attack_2' => 6,
            'count_attack_3' => 5,
            'count_attack_4' => 1,
            'items' => [
                'Great Jagras Claw' => 2,
                'Great Jagras Hide' => 1,
                'Great Jagras Scale' => 2,
                'Sharp Claw' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash' => 3,
                ],
                'add' => [
                    'Strong Rising Slash' => 3,
                ],
            ],
        ],
        [
            'parent' => 'Jagras Blade',
            'branch' => 'Great Jagras',
            'rarity' => 4,
            'name' => [
                'en' => 'Jagras Hacker',
                'es' => 'Cortador Jagras',
            ],
            'count_attack_2' => 3,
            'count_attack_3' => 9,
            'count_attack_4' => 2,
            'items' => [
                'Great Jagras Scale' => 2,
                'Great Jagras Claw' => 2,
                'Great Jagras Mane' => 2,
                'Piercing Claw' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash' => 3,
                    'Any Card' => 2,
                ],
                'add' => [
                    'Strong Rising Slash' => 3,
                    'Strong Charge Up' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Buster Sword',
            'branch' => 'Rathalos',
            'rarity' => 3,
            'name' => [
                'en' => 'Flame Blade',
                'es' => 'Espadón Abrasador',
            ],
            'has_elemental_attacks' => true,
            'count_attack_2' => 5,
            'count_attack_3' => 5,
            'count_attack_4' => 2,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Webbing' => 2,
                'Inferno Sac' => 1,
                'Rathalos Marrow' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Overhead Slam' => 4,
                ],
                'add' => [
                    'Blazing Slam' => 4,
                ],
            ],
        ],
        [
            'parent' => 'Flame Blade',
            'branch' => 'Rathalos',
            'rarity' => 4,
            'name' => [
                'en' => 'Red Wing',
                'es' => 'Ala Roja',
            ],
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 5,
            'count_attack_3' => 6,
            'count_attack_4' => 3,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Carapace' => 2,
                'Rathalos Wing' => 2,
                'Rathalos Medulla' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Overhead Slam' => 4,
                    'Wide Slash' => 2,
                ],
                'add' => [
                    'Blazing Slam' => 4,
                    'Crushing Slash' => 2,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        [
            'parent' => 'Bone Blade',
            'branch' => 'Barroth',
            'rarity' => 3,
            'name' => [
                'en' => 'Carapace Buster',
                'es' => 'Partecarcasas',
            ],
            'count_attack_2' => 5,
            'count_attack_3' => 4,
            'count_attack_4' => 1,
            'items' => [
                'Barroth Claw' => 1,
                'Barroth Shell' => 3,
                'Barroth Ridge' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Great Sword Block' => 2,
                ],
                'add' => [
                    'Empowered Great Sword Block' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Carapace Buster',
            'branch' => 'Barroth',
            'rarity' => 4,
            'name' => [
                'en' => 'Barroth Shredder',
                'es' => 'Triturabarroth',
            ],
            'count_attack_2' => 6,
            'count_attack_3' => 4,
            'count_attack_4' => 2,
            'items' => [
                'Barroth Claw' => 2,
                'Barroth Carapace' => 3,
                'Barroth Ridge' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Great Sword Block' => 2,
                    'Any Card' => 2,
                ],
                'add' => [
                    'Empowered Great Sword Block' => 2,
                    'Paralysing Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Buster Sword',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
            'name' => [
                'en' => 'Blooming Blade',
                'es' => 'Espadón Floral',
            ],
            'count_attack_2' => 5,
            'count_attack_3' => 6,
            'count_attack_4' => 1,
            'items' => [
                'Pukei-Pukei Quill' => 2,
                'Pukei-Pukei Scale' => 2,
                'Poison Sac' => 1,
                'Pukei-Pukei Tail' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'True Charged Slash' => 2,
                ],
                'add' => [
                    'Toxic Charged Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Blooming Blade',
            'branch' => 'Pukei-Pukei',
            'rarity' => 4,
            'name' => [
                'en' => 'Datura Blaze',
                'es' => 'Ardor Datura',
            ],
            'defense' => 1,
            'count_attack_2' => 3,
            'count_attack_3' => 8,
            'count_attack_4' => 3,
            'items' => [
                'Pukei-Pukei Scale' => 2,
                'Pukei-Pukei Wing' => 2,
                'Toxic Sac' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'True Charged Slash' => 2,
                    'Charge Up' => 2,
                ],
                'add' => [
                    'Toxic Charged Slash' => 2,
                    'Poisoned Charge Up' => 2,
                ],
            ],
        ],
        // KULU YA KU EXPANSION
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Buster Sword',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Judicator',
                'es' => 'Sentencia Nergal',
            ],
            'defense' => 1,
            'count_attack_2' => 3,
            'count_attack_3' => 5,
            'count_attack_4' => 3,
            'count_attack_5' => 1,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash' => 3,
                ],
                'add' => [
                    'Dreaded Cleave' => 3,
                ],
            ],
        ],
        [
            'parent' => 'Nergal Judicator',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Purgation\'s Atrocity',
                'es' => 'Purgatorio Atroz',
            ],
            'defense' => 1,
            'count_attack_2' => 3,
            'count_attack_3' => 4,
            'count_attack_4' => 3,
            'count_attack_5' => 4,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash' => 3,
                    'True Charged Slash' => 2,
                ],
                'add' => [
                    'Dreaded Cleave' => 3,
                    'Dragon Charged Slash' => 2,
                ],
            ],
        ],
        // KUSHALA EXPANSION
    ],
];
