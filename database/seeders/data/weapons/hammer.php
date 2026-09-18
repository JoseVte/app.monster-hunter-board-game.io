<?php

return [
    'name' => [
        'en' => 'Hammer',
        'es' => 'Martillo',
    ],
    'description' => [
        'en' => 'When you play an attack card that inflicts damage, if you select a head body part to attack, the attack card gains +1 :break_icon:.<br>
You have attack cards with :charge_hammer_icon_1: or :charge_hammer_icon_2: in your deck. Some of your attacks cards have special rules that draw additional damage cards for these symbols.',
        'es' => 'Cuando juegas una carta de ataque que inflige daño, si seleccionas una parte del cuerpo de la cabeza para atacar, la carta de ataque gana +1 :break_icon:.<br>
Tienes cartas de ataque con :charge_hammer_icon_1: o :charge_hammer_icon_2: en tu mazo. Algunas de tus cartas de ataque tienen reglas especiales que atraen cartas de daño adicionales para estos símbolos.',
    ],
    'image' => 'icon_weapon_05.png',
    'weapons' => [
        'Iron Hammer' => [
            'default' => true,
            'branch' => 'mineral',
            'name' => 'Martillo de Hierro',
            'count_attack_1' => 10,
            'count_attack_2' => 1,
            'count_attack_4' => 1,
        ],
        'Iron Demon' => [
            'parent' => 'Iron Hammer',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => 'Demonio Férreo',
            'count_attack_1' => 8,
            'count_attack_2' => 2,
            'count_attack_4' => 2,
            'items' => [
                'Dragonite Ore' => 1,
                'Machalite Ore' => 1,
                'Monster Bone Medium' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Rare Steak' => 2,
                ],
                'add' => [
                    'Well-Done Steak' => 2,
                ],
            ],
        ],
        'Iron Archdemon' => [
            'parent' => 'Iron Demon',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => 'Archidemonio Férreo',
            'count_attack_1' => 5,
            'count_attack_2' => 3,
            'count_attack_4' => 3,
            'items' => [
                'Fucium Ore' => 2,
                'Carbalite Ore' => 2,
                'Dragonite Ore' => 3,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Rare Steak' => 2,
                    'Upswing' => 2,
                ],
                'add' => [
                    'Well-Done Steak' => 2,
                    'Improved Upswing' => 2,
                ],
            ],
        ],
        'Bone Bludgeon' => [
            'branch' => 'bone',
            'name' => 'Porra Ósea',
            'count_attack_1' => 7,
            'count_attack_2' => 2,
            'count_attack_4' => 1,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        'Fossil Bludgeon' => [
            'parent' => 'Bone Bludgeon',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => 'Maza Fósil',
            'count_attack_1' => 5,
            'count_attack_2' => 3,
            'count_attack_4' => 2,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Charge' => 3,
                ],
                'add' => [
                    'Improved Charge' => 3,
                ],
            ],
        ],
        'Grand Rock' => [
            'parent' => 'Fossil Bludgeon',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => 'Gran Roca',
            'count_attack_1' => 4,
            'count_attack_2' => 3,
            'count_attack_4' => 3,
            'items' => [
                'Monster Hardbone' => 2,
                'Monster Keenbone' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Charge' => 3,
                    'Spinning Bludgeon' => 2,
                ],
                'add' => [
                    'Improved Charge' => 3,
                    'Improved Spinning Bludgeon' => 2,
                ],
            ],
        ],
        // ANCIENT FOREST
        'Blazing Hammer' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Bone Bludgeon',
            'branch' => 'Anjanath',
            'rarity' => 3,
            'name' => 'Martillo Flameante',
            'has_elemental_attacks' => true,
            'count_attack_2' => 8,
            'count_attack_4' => 2,
            'items' => [
                'Anjanath Fang' => 2,
                'Anjanath Scale' => 3,
                'Flame Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Big Bang' => 4,
                ],
                'add' => [
                    'Blazing Big Bang' => 4,
                ],
            ],
        ],
        'Anja Striker' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Blazing Hammer',
            'branch' => 'Anjanath',
            'rarity' => 4,
            'name' => 'Maza Anja',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 9,
            'count_attack_4' => 3,
            'items' => [
                'Anjanath Fang' => 4,
                'Anjanath Scale' => 2,
                'Inferno Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Big Bang' => 4,
                    'Charged Upswing' => 2,
                ],
                'add' => [
                    'Blazing Big Bang' => 4,
                    'Blazing Charged Upswing' => 2,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        'Carapace Sledge' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Bludgeon',
            'branch' => 'Barroth',
            'rarity' => 3,
            'name' => 'Lucerna Acorazada',
            'count_attack_1' => 4,
            'count_attack_2' => 2,
            'count_attack_4' => 4,
            'items' => [
                'Barroth Claw' => 1,
                'Barroth Shell' => 4,
                'Barroth Ridge' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Spinning Bludgeon' => 2,
                ],
                'add' => [
                    'Brutal Bludgeon' => 2,
                ],
            ],
        ],
        'Barroth Breaker' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Carapace Sledge',
            'branch' => 'Barroth',
            'rarity' => 4,
            'name' => 'Rompedor Barroth',
            'count_attack_1' => 2,
            'count_attack_2' => 5,
            'count_attack_4' => 5,
            'items' => [
                'Barroth Claw' => 2,
                'Barroth Carapace' => 3,
                'Barroth Ridge' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Spinning Bludgeon' => 2,
                    'Charged Brutal Big Bang' => 2,
                ],
                'add' => [
                    'Brutal Bludgeon' => 2,
                    'Pulverising Brutal Big Bang' => 2,
                ],
            ],
        ],
        'Blooming Hammer' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Iron Hammer',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
            'name' => 'Martillo Floral',
            'count_attack_1' => 1,
            'count_attack_2' => 8,
            'count_attack_4' => 3,
            'items' => [
                'Pukei-Pukei Quill' => 2,
                'Pukei-Pukei Scale' => 3,
                'Poison Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Slide Smash' => 2,
                ],
                'add' => [
                    'Poisoned Slide Smash' => 2,
                ],
            ],
        ],
        'Buon Fiore' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Blooming Hammer',
            'branch' => 'Pukei-Pukei',
            'rarity' => 4,
            'name' => 'Buon Fiore',
            'count_attack_1' => 1,
            'count_attack_2' => 9,
            'count_attack_4' => 4,
            'items' => [
                'Pukei-Pukei Scale' => 3,
                'Pukei-Pukei Wing' => 2,
                'Toxic Sac' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Slide Smash' => 2,
                    'Charged Upswing' => 2,
                ],
                'add' => [
                    'Poisoned Slide Smash' => 2,
                    'Poisoned Charged Upswing' => 2,
                ],
            ],
        ],
        'Diablos Sledge' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Bludgeon',
            'branch' => 'Diablos',
            'rarity' => 3,
            'name' => 'Trineo Diablos',
            'count_attack_1' => 4,
            'count_attack_2' => 3,
            'count_attack_4' => 5,
            'items' => [
                'Twisted Horn' => 1,
                'Diablos Fang' => 2,
                'Diablos Shell' => 4,
                'Monster Bone Large' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Big Bang' => 4,
                ],
                'add' => [
                    'Crippling Big Bang' => 4,
                ],
            ],
        ],
        'Diablos Shatterer' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Diablos Sledge',
            'branch' => 'Diablos',
            'rarity' => 4,
            'name' => 'Despedazador Diablos',
            'defense' => 1,
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_4' => 6,
            'items' => [
                'Majestic Horn' => 2,
                'Diablos Carapace' => 2,
                'Diablos Ridge' => 2,
                'Blos Medulla' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Big Bang' => 4,
                    'Upswing' => 2,
                ],
                'add' => [
                    'Crippling Big Bang' => 4,
                    'Brutal Upswing' => 2,
                ],
            ],
        ],
        // KULU YA KU EXPANSION
        'Kulu Beak' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'Bone Bludgeon',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 3,
            'name' => 'Pico Kulu',
            'count_attack_1' => 5,
            'count_attack_2' => 2,
            'count_attack_3' => 5,
            'items' => [
                'Kulu-Ya-Ku Beak' => 1,
                'Kulu-Ya-Ku Hide' => 2,
                'Kulu-Ya-Ku Scale' => 4,
                'Earth Crystal' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Spinning Bludgeon' => 2,
                ],
                'add' => [
                    'Divine Spiral Bludgeon' => 2,
                ],
            ],
        ],
        'Crushing Beak' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'Kulu Beak',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 4,
            'name' => 'Pico Aplastador',
            'count_attack_1' => 5,
            'count_attack_2' => 3,
            'count_attack_3' => 6,
            'items' => [
                'Kulu-Ya-Ku Beak' => 2,
                'Kulu-Ya-Ku Hide' => 3,
                'Kulu-Ya-Ku Plume' => 3,
                'Boulder Bone' => 4,
            ],
            'attacks' => [
                'remove' => [
                    'Spinning Bludgeon' => 2,
                    'Side Smash' => 2,
                ],
                'add' => [
                    'Divine Spiral Bludgeon' => 2,
                    'Knock Out Side Smash' => 2,
                ],
            ],
        ],
        // NERGIGANTE EXPANSION
        'Nergal Crusher' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Iron Hammer',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => 'Crujidora Nergal',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 7,
            'count_attack_4' => 3,
            'count_attack_5' => 2,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Big Bang' => 4,
                ],
                'add' => [
                    'Dragon Big Bang' => 4,
                ],
            ],
        ],
        'Obliteration\'s Footfall' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Nergal Crusher',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => 'Pisadas de Obliteración',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 8,
            'count_attack_4' => 3,
            'count_attack_5' => 3,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Big Bang' => 4,
                    'Charged Upswing' => 2,
                ],
                'add' => [
                    'Dragon Big Bang' => 4,
                    'Dragon Charged Upswing' => 2,
                ],
            ],
        ],
        // TEOSTRA EXPANSION <NONE>
        // KUSHALA EXPANSION
        'Icesteel Hammer' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Iron Hammer',
            'branch' => 'Kushala Daora',
            'rarity' => 4,
            'name' => 'Martillo Acero Helado',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 10,
            'count_attack_4' => 2,
            'count_attack_5' => 2,
            'items' => [
                'Daora Claw' => 1,
                'Daora Webbing' => 2,
                'Nergigante Carapace' => 1,
                'Daora Tail' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Side Smash' => 2,
                ],
                'add' => [
                    'Icy Slide Smash' => 2,
                ],
            ],
        ],
        'Daora\'s Colossus' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Icesteel Hammer',
            'branch' => 'Kushala Daora',
            'rarity' => 5,
            'name' => 'Coloso Daora',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 11,
            'count_attack_4' => 2,
            'count_attack_5' => 3,
            'items' => [
                'Daora Horn' => 4,
                'Daora Claw' => 3,
                'Daora Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Side Smash' => 2,
                    'Upswing' => 2,
                ],
                'add' => [
                    'Icy Slide Smash' => 2,
                    'Frozen Upswing' => 2,
                ],
            ],
        ],
    ],
];
