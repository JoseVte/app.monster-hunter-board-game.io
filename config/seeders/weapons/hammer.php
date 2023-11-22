<?php

return [
    'name' => [
        'en' => 'Hammer',
        'es' => 'Martillo',
    ],
    'description' => [
        'en' => 'When you play an attack card that inflicts damage, if you select a head body part to attack, the attack card gains +1 :break_icon:.<br>
You have attack cards with :charge_hummer_icon_1: or :charge_hummer_icon_2: in your deck. Some of your attacks cards have special rules that draw additional damage cards for these symbols.',
        'es' => 'Cuando juegas una carta de ataque que inflige daño, si seleccionas una parte del cuerpo de la cabeza para atacar, la carta de ataque gana +1 :break_icon:.<br>
Tienes cartas de ataque con :charge_hummer_icon_1: o :charge_hummer_icon_2: en tu mazo. Algunas de tus cartas de ataque tienen reglas especiales que atraen cartas de daño adicionales para estos símbolos.',
    ],
    'image' => 'icon_weapon_05.png',
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Iron Hammer',
                'es' => 'Martillo de Hierro',
            ],
            'count_attack_1' => 10,
            'count_attack_2' => 1,
            'count_attack_4' => 1,
        ],
        [
            'parent' => 'Iron Hammer',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => [
                'en' => 'Iron Demon',
                'es' => 'Demonio Férreo',
            ],
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
        [
            'parent' => 'Iron Demon',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => [
                'en' => 'Iron Archdemon',
                'es' => 'Archidemonio Férreo',
            ],
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
        [
            'branch' => 'bone',
            'name' => [
                'en' => 'Bone Bludgeon',
                'es' => 'Porra Ósea',
            ],
            'count_attack_1' => 7,
            'count_attack_2' => 2,
            'count_attack_4' => 1,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        [
            'parent' => 'Bone Bludgeon',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => [
                'en' => 'Fossil Bludgeon',
                'es' => 'Maza Fósil',
            ],
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
        [
            'parent' => 'Fossil Bludgeon',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => [
                'en' => 'Grand Rock',
                'es' => 'Gran Roca',
            ],
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
        [
            'parent' => 'Bone Bludgeon',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => [
                'en' => 'Blazing Hammer',
                'es' => 'Martillo Flameante',
            ],
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
        [
            'parent' => 'Blazing Hammer',
            'branch' => 'bone',
            'rarity' => 4,
            'name' => [
                'en' => 'Anja Striker',
                'es' => 'Maza Anja',
            ],
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
        [
            'parent' => 'Bone Bludgeon',
            'branch' => 'Barroth',
            'rarity' => 3,
            'name' => [
                'en' => 'Carapace Sledge',
                'es' => 'Lucerna Acorazada',
            ],
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
        [
            'parent' => 'Carapace Sledge',
            'branch' => 'Barroth',
            'rarity' => 4,
            'name' => [
                'en' => 'Barroth Shredder',
                'es' => 'Rompedor Barroth',
            ],
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
        [
            'parent' => 'Iron Hammer',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
            'name' => [
                'en' => 'Blooming Hammer',
                'es' => 'Martillo Floral',
            ],
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
        [
            'parent' => 'Blooming Hammer',
            'branch' => 'Pukei-Pukei',
            'rarity' => 4,
            'name' => [
                'en' => 'Buon Fiore',
                'es' => 'Buon Fiore',
            ],
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
        [
            'parent' => 'Bone Bludgeon',
            'branch' => 'Diablos',
            'rarity' => 3,
            'name' => [
                'en' => 'Diablos Sledge',
                'es' => 'Trineo Diablos',
            ],
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
        [
            'parent' => 'Diablos Sledge',
            'branch' => 'Diablos',
            'rarity' => 4,
            'name' => [
                'en' => 'Diablos Shatterer',
                'es' => 'Despedazador Diablos',
            ],
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
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Iron Hammer',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Crusher',
                'es' => 'Crujidora Nergal',
            ],
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
        [
            'parent' => 'Nergal Crusher',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Obliteration\'s Footfall',
                'es' => 'Pisadas de Obliteración',
            ],
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
        // KUSHALA EXPANSION
    ],
];
