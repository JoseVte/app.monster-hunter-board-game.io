<?php

return [
    'name' => [
        'en' => 'Dual Blades',
        'es' => 'Espadas Dobles',
    ],
    'description' => '',
    'image' => 'icon_weapon_04.png',
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Matched Slicers',
                'es' => 'Rebanadoras Gemelas',
            ],
            'count_attack_1' => 10,
            'count_attack_2' => 2,
        ],
        [
            'parent' => 'Matched Slicers',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => [
                'en' => 'Dual Slicers',
                'es' => 'Duorrebanadoras',
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
                    'Lunging Stab' => 2,
                ],
                'add' => [
                    'Enhanced Lunging Stab' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Dual Slicers',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => [
                'en' => 'Chrome Slicers',
                'es' => 'Cromorrebanadoras',
            ],
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
                    'Lunging Stab' => 2,
                    'Blade Dance' => 4,
                ],
                'add' => [
                    'Enhanced Lunging Stab' => 2,
                    'Enhanced Blade Dance' => 4,
                ],
            ],
        ],
        [
            'branch' => 'bone',
            'name' => [
                'en' => 'Bone Hatchets',
                'es' => 'Hachas Óseas',
            ],
            'count_attack_1' => 7,
            'count_attack_2' => 3,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        [
            'parent' => 'Bone Hatchets',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => [
                'en' => 'Wild Hatchets',
                'es' => 'Hachas Salvajes',
            ],
            'count_attack_1' => 5,
            'count_attack_2' => 5,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Double Slash' => 2,
                ],
                'add' => [
                    'Impact Double Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Wild Hatchets',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => [
                'en' => 'Strong Hatchets',
                'es' => 'Hachas Reforzadas',
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
                    'Double Slash' => 2,
                    'Rapid Spin' => 2,
                ],
                'add' => [
                    'Impact Double Slash' => 2,
                    'Strong Rapid Spin' => 2,
                ],
            ],
        ],
        // ANCIENT FOREST
        [
            'parent' => 'Bone Hatchets',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
            'name' => [
                'en' => 'Pulsar Hatchets',
                'es' => 'Hachas Púlsar',
            ],
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 3,
            'items' => [
                'Tobi-Kadachi Electrode' => 1,
                'Tobi-Kadachi Claw' => 2,
                'Electro Sac' => 2,
                'Coral Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Bladed Fangs' => 2,
                    'Rapid Spin' => 2,
                ],
                'add' => [
                    'Shocking Rush' => 4,
                ],
            ],
        ],
        [
            'parent' => 'Pulsar Hatchets',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 4,
            'name' => [
                'en' => 'Kadachi Claws',
                'es' => 'Garras Kadachi',
            ],
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 5,
            'items' => [
                'Tobi-Kadachi Electrode' => 2,
                'Tobi-Kadachi Claw' => 2,
                'Thunder Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Bladed Fangs' => 2,
                    'Rapid Spin' => 2,
                    'Demon Mode' => 2,
                ],
                'add' => [
                    'Shocking Rush' => 4,
                    'Enhanced Demon Mode' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Bone Hatchets',
            'branch' => 'Anjanath',
            'rarity' => 3,
            'name' => [
                'en' => 'Blazing Hatchets',
                'es' => 'Hachas Flameantes',
            ],
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 3,
            'items' => [
                'Anjanath Scale' => 3,
                'Anjanath Fang' => 2,
                'Flame Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Six Fold Slash' => 1,
                    'Any Card' => 1,
                ],
                'add' => [
                    'Blazing Fold Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Blazing Hatchets',
            'branch' => 'Anjanath',
            'rarity' => 4,
            'name' => [
                'en' => 'Anja Cyclone',
                'es' => 'Ciclón Anja',
            ],
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 5,
            'items' => [
                'Anjanath Fang' => 4,
                'Anjanath Pelt' => 4,
                'Firecell Stone' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Six Fold Slash' => 1,
                    'Any Card' => 1,
                    'Double Slash' => 2,
                ],
                'add' => [
                    'Blazing Fold Slash' => 2,
                    'Blazing Double Slash' => 2,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        [
            'parent' => 'Bone Hatchets',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
            'name' => [
                'en' => 'Madness Pangas',
                'es' => 'Machetes Maníacos',
            ],
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 5,
            'count_attack_3' => 3,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Shell' => 2,
                'Jyuratodus Scale' => 3,
                'Aqua Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Blade Dance' => 4,
                ],
                'add' => [
                    'Water Dance' => 4,
                ],
            ],
        ],
        [
            'parent' => 'Madness Pangas',
            'branch' => 'Jyuratodus',
            'rarity' => 4,
            'name' => [
                'en' => 'Jyura Hatchets',
                'es' => 'Machetes Jyura',
            ],
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 4,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Carapace' => 2,
                'Jyuratodus Scale' => 2,
                'Aqua Sac' => 1,
                'Gajau Scale' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Blade Dance' => 4,
                    'Rapid Spin' => 2,
                ],
                'add' => [
                    'Water Dance' => 4,
                    'Flurry Rush' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Bone Hatchets',
            'branch' => 'Diablos',
            'rarity' => 3,
            'name' => [
                'en' => 'Diablos Hatchets',
                'es' => 'Hachas Diablos',
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
                    'Double Slash' => 2,
                ],
                'add' => [
                    'Brutal Double Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Diablos Hatchets',
            'branch' => 'Diablos',
            'rarity' => 4,
            'name' => [
                'en' => 'Diablos Clubs',
                'es' => 'Garrotes Diablos',
            ],
            'defense' => 1,
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
                    'Double Slash' => 2,
                    'Demon Mode' => 2,
                ],
                'add' => [
                    'Brutal Double Slash' => 2,
                    'Brutal Demon Mode' => 2,
                ],
            ],
        ],
        // KULU YA KU EXPANSION
        // TEOSTRA EXPANSION
        [
            'parent' => 'Matched Slicers',
            'branch' => 'Teostra',
            'rarity' => 4,
            'name' => [
                'en' => 'Twin Nails',
                'es' => 'Clavos Gemelos',
            ],
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 5,
            'count_attack_4' => 1,
            'items' => [
                'Teostra Claw' => 1,
                'Teostra Mane' => 1,
                'Teostra Carapace' => 2,
                'Teostra Powder' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Any Card' => 2,
                ],
                'add' => [
                    'Blast Wrath' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Twin Nails',
            'branch' => 'Teostra',
            'rarity' => 5,
            'name' => [
                'en' => 'Fire and Ice',
                'es' => 'Fuego y Hielo',
            ],
            'count_attack_2' => 9,
            'count_attack_3' => 4,
            'count_attack_4' => 3,
            'items' => [
                'Teostra Horn' => 3,
                'Teostra Claw' => 2,
                'Teostra Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Any Card' => 2,
                    'Sixfold Slash' => 1,
                    'Double Slash' => 2,
                ],
                'add' => [
                    'Blast Wrath' => 2,
                    'Rending Slice' => 3,
                ],
            ],
        ],
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Matched Slicers',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Gouge',
                'es' => 'Gubias Nergal',
            ],
            'has_elemental_attacks' => true,
            'count_attack_2' => 5,
            'count_attack_3' => 6,
            'count_attack_4' => 1,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Blade Dance' => 4,
                ],
                'add' => [
                    'Dragon Dance' => 4,
                ],
            ],
        ],
        [
            'parent' => 'Nergal Gouge',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Decimation Claws',
                'es' => 'Garras Diezmadoras',
            ],
            'has_elemental_attacks' => true,
            'count_attack_2' => 5,
            'count_attack_3' => 7,
            'count_attack_4' => 2,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Blade Dance' => 4,
                    'Rapid Spin' => 2,
                ],
                'add' => [
                    'Dragon Dance' => 4,
                    'Mid Air Slash' => 2,
                ],
            ],
        ],
        // KUSHALA EXPANSION
    ],
];
