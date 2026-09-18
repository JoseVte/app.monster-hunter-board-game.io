<?php

return [
    'name' => [
        'en' => 'Gunlance',
        'es' => 'Lanza Pistola',
    ],
    'description' => [
        'en' => 'During setup, place the 5 shelling cards face up in a row above your stamina board.<br>When you play an attack card with one or more :shelling_up_icon:, flip a number of shelling cards face down equal to the number of :shelling_up_icon: on the attack card. If there aren\'t enough face up shelling cards for the attack, flip as many as you can.<br>Draw +1 :damage_card_icon: for each shelling card flipped face down while resolving the attack card.<br>When you sharpen your weapon, fill all your shelling cards face up.',
        'es' => 'Durante la configuración, coloca las 5 cartas de bombardeo boca arriba en una fila sobre tu tablero de resistencia.<br>Cuando juegues una carta de ataque con uno o más :shelling_up_icon:, voltea una cantidad de cartas de bombardeo boca abajo igual a la cantidad de :shelling_up_icon: en la carta de ataque. Si no hay suficientes cartas de bombardeo boca arriba para el ataque, voltee todas las que pueda.<br>Obtenga +1 :damage_card_icon: por cada carta de bombardeo volteada boca abajo mientras resuelve la carta de ataque.<br>Cuando afile su arma, rellene todas tus cartas de bombardeo boca arriba.',
    ],
    'image' => 'weapon-types/gunlance.svg',
    'weapons' => [
        'Iron Gunlance' => [
            'default' => true,
            'branch' => 'mineral',
            'name' => 'Lanza Pistola Férrea',
            'defense' => 1,
            'count_attack_1' => 8,
            'count_attack_2' => 2,
        ],
        'Steel Gunlance' => [
            'parent' => 'Iron Gunlance',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => 'Lanza Pistola Acerada',
            'defense' => 1,
            'count_attack_1' => 7,
            'count_attack_2' => 4,
            'count_attack_3' => 1,
            'items' => [
                'Dragonite Ore' => 1,
                'Machalite Ore' => 1,
                'Monster Bone Medium' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Full Burst' => 2,
                ],
                'add' => [
                    'Improved Full Burst' => 2,
                ],
            ],
        ],
        'Chrome Gunlance' => [
            'parent' => 'Steel Gunlance',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => 'Cromolanza Pistola',
            'defense' => 1,
            'count_attack_1' => 5,
            'count_attack_2' => 4,
            'count_attack_3' => 3,
            'items' => [
                'Fucium Ore' => 2,
                'Carbalite Ore' => 2,
                'Dragonite Ore' => 3,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Full Burst' => 2,
                    'Lunging Upthrust' => 2,
                ],
                'add' => [
                    'Improved Full Burst' => 2,
                    'Improved Lunging Upthrust' => 2,
                ],
            ],
        ],
        'Bone Gunlance' => [
            'branch' => 'bone',
            'name' => 'Lanza Pistola Ósea',
            'defense' => 1,
            'count_attack_1' => 5,
            'count_attack_2' => 5,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        'Bone Cannon' => [
            'parent' => 'Bone Gunlance',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => 'Cañón Óseo',
            'defense' => 1,
            'count_attack_1' => 3,
            'count_attack_2' => 6,
            'count_attack_3' => 1,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Charged Shell' => 2,
                ],
                'add' => [
                    'Improved Charged Shell' => 2,
                ],
            ],
        ],
        'Great Bone Gunlance' => [
            'parent' => 'Bone Cannon',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => 'Lanza Pistola Megaósea',
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
                    'Charged Shell' => 2,
                    'Overhead Smash' => 2,
                ],
                'add' => [
                    'Improved Charged Shell' => 2,
                    'Improved Overhead Smash' => 2,
                ],
            ],
        ],
        // ANCIENT FOREST
        'Jagras Gunlance' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Bone Gunlance',
            'branch' => 'Great Jagras',
            'rarity' => 3,
            'name' => 'Lanza Pistola Jagras',
            'defense' => 1,
            'count_attack_1' => 2,
            'count_attack_2' => 5,
            'count_attack_3' => 3,
            'items' => [
                'Great Jagras Claw' => 1,
                'Great Jagras Hide' => 1,
                'Great Jagras Scale' => 3,
                'Sharp Claw' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash' => 2,
                ],
                'add' => [
                    'Gluttonous Rising Slash' => 2,
                ],
            ],
        ],
        'Glutton Gunlance' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Jagras Gunlance',
            'branch' => 'Great Jagras',
            'rarity' => 4,
            'name' => 'Lanza Pistola Glotona',
            'defense' => 1,
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 4,
            'items' => [
                'Great Jagras Scale' => 2,
                'Great Jagras Claw' => 2,
                'Great Jagras Mane' => 2,
                'Piercing Claw' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash' => 2,
                    'Full Burst' => 2,
                ],
                'add' => [
                    'Gluttonous Rising Slash' => 2,
                    'Knock Out Full Burst' => 2,
                ],
            ],
        ],
        'Rath Gunlance' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Iron Gunlance',
            'branch' => 'Rathalos',
            'rarity' => 3,
            'name' => 'Lanza Pistola Rath',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 4,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Webbing' => 1,
                'Inferno Sac' => 1,
                'Rathalos Marrow' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Charged Shell' => 2,
                ],
                'add' => [
                    'Flaming Charged Shell' => 2,
                ],
            ],
        ],
        'Red Rook' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Rath Gunlance',
            'branch' => 'Rathalos',
            'rarity' => 4,
            'name' => 'Grajo Rojo',
            'has_elemental_attacks' => true,
            'defense' => 1,
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 5,
            'count_attack_4' => 1,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Carapace' => 1,
                'Rathalos Wing' => 1,
                'Rathalos Medulla' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Charged Shell' => 2,
                    'Lateral Thrust' => 2,
                ],
                'add' => [
                    'Flaming Charged Shell' => 2,
                    'Blazing Lateral Thrust' => 2,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        'Carapace Cannon' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Gunlance',
            'branch' => 'Barroth',
            'rarity' => 3,
            'name' => 'Cañón Acorazado',
            'defense' => 1,
            'count_attack_1' => 3,
            'count_attack_2' => 3,
            'count_attack_3' => 4,
            'items' => [
                'Barroth Claw' => 1,
                'Barroth Shell' => 3,
                'Barroth Ridge' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Wyrmstake Cannon' => 2,
                ],
                'add' => [
                    'Brutal Wyrmstake Cannon' => 2,
                ],
            ],
        ],
        'Barroth Blaster' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Carapace Cannon',
            'branch' => 'Barroth',
            'rarity' => 4,
            'name' => 'Bláster Barroth',
            'defense' => 1,
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 3,
            'count_attack_4' => 1,
            'items' => [
                'Barroth Claw' => 2,
                'Barroth Carapace' => 3,
                'Barroth Ridge' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Wyrmstake Cannon' => 2,
                    'Rising Slash' => 2,
                ],
                'add' => [
                    'Brutal Wyrmstake Cannon' => 2,
                    'Crippling Rising Slash' => 2,
                ],
            ],
        ],
        'Madness Gunlance' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Iron Gunlance',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
            'name' => 'Lanza Pistola Maníaca',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 7,
            'count_attack_3' => 3,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Shell' => 2,
                'Jyuratodus Scale' => 3,
                'Aqua Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Burst' => 2,
                ],
                'add' => [
                    'Water Burst' => 2,
                ],
            ],
        ],
        'Jyura Buster' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Madness Gunlance',
            'branch' => 'Jyuratodus',
            'rarity' => 4,
            'name' => 'Cañón Jyura',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 7,
            'count_attack_3' => 5,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Carapace' => 2,
                'Jyuratodus Scale' => 2,
                'Aqua Sac' => 1,
                'Gajau Scale' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Burst' => 2,
                    'Wyrmstake Cannon' => 2,
                ],
                'add' => [
                    'Water Burst' => 2,
                    'Tidal Wyrmstake Cannon' => 2,
                ],
            ],
        ],
        // KULU YA KU EXPANSION <NONE>
        // NERGIGANTE EXPANSION
        'Nergal Ram' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Iron Gunlance',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => 'Ariete Nergal',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 6,
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
                    'Burst' => 2,
                ],
                'add' => [
                    'Dragon Burst' => 2,
                ],
            ],
        ],
        'Eradication Flame' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Nergal Ram',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => 'Llama de Aniquilación',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 6,
            'count_attack_3' => 3,
            'count_attack_4' => 3,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Burst' => 2,
                    'Wyrmstake Cannon' => 2,
                ],
                'add' => [
                    'Dragon Burst' => 3,
                    'Dragon Wyrmstake Cannon' => 2,
                ],
            ],
        ],
        // TEOSTRA EXPANSION <NONE>
        // KUSHALA EXPANSION
        'Icesteel Gunlance' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Iron Gunlance',
            'branch' => 'Kushala Daora',
            'rarity' => 4,
            'name' => 'Lanza Pistola Acero Helado',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 7,
            'count_attack_3' => 6,
            'count_attack_4' => 1,
            'items' => [
                'Daora Claw' => 1,
                'Daora Webbing' => 2,
                'Nergigante Carapace' => 1,
                'Daora Tail' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash' => 2,
                ],
                'add' => [
                    'Freezing Rising Slash' => 2,
                ],
            ],
        ],
        'Daora\'s Brigia' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Icesteel Gunlance',
            'branch' => 'Kushala Daora',
            'rarity' => 5,
            'name' => 'Brillo Daora',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 8,
            'count_attack_3' => 5,
            'count_attack_4' => 3,
            'items' => [
                'Daora Horn' => 4,
                'Daora Claw' => 3,
                'Daora Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash' => 2,
                    'Charged Shell' => 2,
                ],
                'add' => [
                    'Freezing Rising Slash' => 2,
                    'Frozen Charged Shell' => 2,
                ],
            ],
        ],
    ],
];
