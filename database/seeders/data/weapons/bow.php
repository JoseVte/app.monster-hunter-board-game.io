<?php

return [
    'name' => [
        'en' => 'Bow',
        'es' => 'Arco',
    ],
    'description' => '',
    'image' => 'icon_weapon_12.png',
    'weapons' => [
        'Iron Bow' => [
            'default' => true,
            'branch' => 'mineral',
            'name' => 'Arco Férreo',
            'count_attack_1' => 8,
            'count_attack_2' => 4,
        ],
        'Steel Bow' => [
            'parent' => 'Iron Bow',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => 'Arco Acerado',
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
        'Alloy Bow' => [
            'parent' => 'Steel Bow',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => 'Arco de Aleación',
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
        'Hunter\'s Bow' => [
            'branch' => 'bone',
            'name' => 'Arco de Cazador',
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
        'Hunter\'s Stoutbow' => [
            'parent' => 'Hunter\'s Bow',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => 'Arco Recio de Cazador',
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
        'Hunter\'s Proudbow' => [
            'parent' => 'Hunter\'s Stoutbow',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => 'Arco Honra de Cazador',
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
        'Pulsar Bow' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Hunter\'s Bow',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
            'name' => 'Arco Púlsar',
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
        'Kadachi Strikebow' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Pulsar Bow',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 4,
            'name' => 'Arco de ataque Kadachi',
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
        'Blazing Bow' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Hunter\'s Bow',
            'branch' => 'Anjanath',
            'rarity' => 3,
            'name' => 'Arco Flameante',
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
        'Anja Arch' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Blazing Bow',
            'branch' => 'Anjanath',
            'rarity' => 4,
            'name' => 'Arco Anja',
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
        'Blooming Arch' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Hunter\'s Bow',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
            'name' => 'Arco Floral',
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
        'Datura String' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Blooming Arch',
            'branch' => 'Pukei-Pukei',
            'rarity' => 4,
            'name' => 'Cordel Datura',
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
        'Diablos Bow' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Hunter\'s Bow',
            'branch' => 'Diablos',
            'rarity' => 3,
            'name' => 'Arco Diablos',
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
        'Diablos Coilbender' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Diablos Bow',
            'branch' => 'Diablos',
            'rarity' => 4,
            'name' => 'Doblamallas Diablos',
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
        'Kulu Arrow' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'Iron Bow',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 3,
            'name' => 'Flecha Kulu',
            'count_attack_1' => 3,
            'count_attack_2' => 7,
            'count_attack_3' => 4,
            'items' => [
                'Kulu-Ya-Ku Beak' => 1,
                'Kulu-Ya-Ku Hide' => 2,
                'Kulu-Ya-Ku Scale' => 4,
                'Earth Crystal' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 2,
                ],
                'add' => [
                    'Sleep Coating' => 2,
                ],
            ],
        ],
        'Archer\'s Dance' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'Kulu Arrow',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 4,
            'name' => 'Danza del Arquero',
            'count_attack_1' => 2,
            'count_attack_2' => 5,
            'count_attack_3' => 9,
            'items' => [
                'Kulu-Ya-Ku Beak' => 2,
                'Kulu-Ya-Ku Hide' => 3,
                'Kulu-Ya-Ku Plume' => 3,
                'Boulder Bone' => 4,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 2,
                    'Charged Shot' => 3,
                ],
                'add' => [
                    'Sleep Coating' => 2,
                    'Blast Charged Shot' => 3,
                ],
            ],
        ],
        // NERGIGANTE EXPANSION
        'Nergal Whisper' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Iron Bow',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => 'Susurro Nergal',
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
        'Doom\'s Shaft' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Nergal Whisper',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => 'Mástil de Condenación',
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
        // TEOSTRA EXPANSION <NONE>
        // KUSHALA EXPANSION
        'Icesteel Bow' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Iron Bow',
            'branch' => 'Kushala Daora',
            'rarity' => 4,
            'name' => 'Arco Acero Helado',
            'has_elemental_attacks' => true,
            'count_attack_2' => 4,
            'count_attack_3' => 8,
            'count_attack_4' => 2,
            'items' => [
                'Daora Claw' => 1,
                'Daora Webbing' => 2,
                'Nergigante Carapace' => 1,
                'Daora Tail' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 4,
                ],
                'add' => [
                    'Frost Coating' => 4,
                ],
            ],
        ],
        'Daora\'s Sagittarii' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Icesteel Bow',
            'branch' => 'Kushala Daora',
            'rarity' => 5,
            'name' => 'Sagitario Daora',
            'has_elemental_attacks' => true,
            'count_attack_2' => 5,
            'count_attack_3' => 7,
            'count_attack_4' => 4,
            'items' => [
                'Daora Horn' => 4,
                'Daora Claw' => 3,
                'Daora Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Power Coating' => 4,
                    'Dragon Piercer' => 1,
                    'Any Card' => 1,
                ],
                'add' => [
                    'Frost Coating' => 4,
                    'Ice Piercer' => 2,
                ],
            ],
        ],
    ],
];
