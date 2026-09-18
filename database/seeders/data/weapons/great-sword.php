<?php

return [
    'name' => [
        'en' => 'Great Sword',
        'es' => 'Gran Espada',
    ],
    'description' => '',
    'image' => 'weapon-types/great-sword.svg',
    'weapons' => [
        'Buster Sword' => [
            'default' => true,
            'branch' => 'mineral',
            'name' => 'Espada Cazadora',
            'count_attack_1' => 7,
            'count_attack_2' => 4,
            'count_attack_3' => 1,
        ],
        'Buster Blade' => [
            'parent' => 'Buster Sword',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => 'Hoja Cazadora',
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
        'Chrome Razor' => [
            'parent' => 'Buster Blade',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => 'Cromocuchilla',
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
        'Bone Blade' => [
            'branch' => 'bone',
            'name' => 'Espadón Óseo',
            'count_attack_1' => 5,
            'count_attack_2' => 3,
            'count_attack_3' => 2,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        'Bone Slasher' => [
            'parent' => 'Bone Blade',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => 'Decapitadora Ósea',
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
        'Giant Jawblade' => [
            'parent' => 'Bone Slasher',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => 'Filo Mandibular',
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
        'Jagras Blade' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Buster Sword',
            'branch' => 'Great Jagras',
            'rarity' => 3,
            'name' => 'Espadón Jagras',
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
        'Jagras Hacker' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Jagras Blade',
            'branch' => 'Great Jagras',
            'rarity' => 4,
            'name' => 'Cortador Jagras',
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
        'Flame Blade' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Buster Sword',
            'branch' => 'Rathalos',
            'rarity' => 3,
            'name' => 'Espadón Abrasador',
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
        'Red Wing' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Flame Blade',
            'branch' => 'Rathalos',
            'rarity' => 4,
            'name' => 'Ala Roja',
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
        'Carapace Buster' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Blade',
            'branch' => 'Barroth',
            'rarity' => 3,
            'name' => 'Partecarcasas',
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
        'Barroth Shredder' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Carapace Buster',
            'branch' => 'Barroth',
            'rarity' => 4,
            'name' => 'Triturabarroth',
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
        'Blooming Blade' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Buster Sword',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
            'name' => 'Espadón Floral',
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
        'Datura Blaze' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Blooming Blade',
            'branch' => 'Pukei-Pukei',
            'rarity' => 4,
            'name' => 'Ardor Datura',
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
        // KULU YA KU EXPANSION <NONE>
        // NERGIGANTE EXPANSION
        'Nergal Judicator' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Buster Sword',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => 'Sentencia Nergal',
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
        'Purgation\'s Atrocity' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Nergal Judicator',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => 'Purgatorio Atroz',
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
        // TEOSTRA EXPANSION <NONE>
        // KUSHALA EXPANSION
        'Icesteel Edge' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Buster Sword',
            'branch' => 'Kushala Daora',
            'rarity' => 4,
            'name' => 'Hoja Acero Helado',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_2' => 4,
            'count_attack_3' => 4,
            'count_attack_4' => 5,
            'count_attack_5' => 1,
            'items' => [
                'Daora Claw' => 1,
                'Daora Webbing' => 2,
                'Nergigante Carapace' => 1,
                'Daora Tail' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Charge Up' => 2,
                ],
                'add' => [
                    'Frozen Charge Up' => 3,
                ],
            ],
        ],
        'Daora\'s Decimator' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Icesteel Edge',
            'branch' => 'Kushala Daora',
            'rarity' => 5,
            'name' => 'Diezmador Daora',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_2' => 5,
            'count_attack_3' => 6,
            'count_attack_4' => 3,
            'count_attack_5' => 2,
            'items' => [
                'Daora Horn' => 4,
                'Daora Claw' => 3,
                'Daora Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Charge Up' => 2,
                    'Overhead Slam' => 4,
                ],
                'add' => [
                    'Frozen Charge Up' => 3,
                    'Frostbite Slam' => 4,
                ],
            ],
        ],
        // KIRIN EXPANSION
        'Kirin Thundersword' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Bone Blade',
            'branch' => 'Kirin',
            'rarity' => 4,
            'name' => 'Espada Eléctrica Kirin',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_2' => 6,
            'count_attack_3' => 3,
            'count_attack_4' => 4,
            'count_attack_5' => 1,
            'items' => [
                'Kirin Thunderhorn' => 3,
                'Kirin Hide' => 3,
                'Kirin Tail' => 1,
                'Lightcrystal' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash' => 3,
                ],
                'add' => [
                    'Thunder Slash' => 3,
                ],
            ],
        ],
        'King Thundersword' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Kirin Thundersword',
            'branch' => 'Kirin',
            'rarity' => 5,
            'name' => 'Espada Eléctrica Rey',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_2' => 4,
            'count_attack_3' => 6,
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
                    'Rising Slash' => 3,
                    'Jumping Slash' => 2,
                ],
                'add' => [
                    'Thunder Slash' => 3,
                    'Overcharged Slash' => 2,
                ],
            ],
        ],
    ],
];
