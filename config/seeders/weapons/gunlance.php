<?php

return [
    'name' => [
        'en' => 'Gunlance',
        'es' => 'Lanza Pistola',
    ],
    'description' => [
        'en' => 'During setup, place the 5 shelling cards face up in a row above your stamina board.\nWhen you play an attack card with one or more [shelling_up_icon], flip a number of shelling cards face down equal to the number of [shelling_up_icon] on the attack card. If there aren\'t enough face up shelling cards for the attack, flip as many as you can.\nDraw +1 [damage_card_icon] for each shelling card flipped face down while resolving the attack card.\nWhen you sharpen your weapon, fill all your shelling cards face up.',
        'es' => 'Durante la configuración, coloca las 5 cartas de bombardeo boca arriba en una fila sobre tu tablero de resistencia.\nCuando juegues una carta de ataque con uno o más [shelling_up_icon], voltea una cantidad de cartas de bombardeo boca abajo igual a la cantidad de [shelling_up_icon] en la carta de ataque. Si no hay suficientes cartas de bombardeo boca arriba para el ataque, voltee todas las que pueda.\nObtenga +1 [damage_card_icon] por cada carta de bombardeo volteada boca abajo mientras resuelve la carta de ataque.\nCuando afile su arma, rellene todas tus cartas de bombardeo boca arriba.',
    ],
    'image' => 'icon_weapon_08.png',
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Iron Gunlance',
                'es' => 'Lanza Pistola Férrea',
            ],
            'defense' => 1,
            'count_attack_1' => 8,
            'count_attack_2' => 2,
        ],
        [
            'parent' => 'Iron Gunlance',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => [
                'en' => 'Steel Gunlance',
                'es' => 'Lanza Pistola Acerada',
            ],
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
        [
            'parent' => 'Steel Gunlance',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => [
                'en' => 'Chrome Gunlance',
                'es' => 'Cromolanza Pistola',
            ],
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
        [
            'branch' => 'bone',
            'name' => [
                'en' => 'Bone Gunlance',
                'es' => 'Lanza Pistola Ósea',
            ],
            'defense' => 1,
            'count_attack_1' => 5,
            'count_attack_2' => 5,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        [
            'parent' => 'Bone Gunlance',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => [
                'en' => 'Bone Cannon',
                'es' => 'Cañón Óseo',
            ],
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
        [
            'parent' => 'Bone Cannon',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => [
                'en' => 'Great Bone Gunlance',
                'es' => 'Lanza Pistola Megaósea',
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
        // WILDSPIRE WASTE
        [
            'parent' => 'Bone Gunlance',
            'branch' => 'Barroth',
            'rarity' => 3,
            'name' => [
                'en' => 'Carapace Cannon',
                'es' => 'Cañón Acorazado',
            ],
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
        [
            'parent' => 'Carapace Cannon',
            'branch' => 'Barroth',
            'rarity' => 4,
            'name' => [
                'en' => 'Barroth Blaster',
                'es' => 'Bláster Barroth',
            ],
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
        [
            'parent' => 'Iron Gunlance',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
            'name' => [
                'en' => 'Madness Gunlance',
                'es' => 'Lanza Pistola Maníaca',
            ],
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
        [
            'parent' => 'Madness Gunlance',
            'branch' => 'Jyuratodus',
            'rarity' => 4,
            'name' => [
                'en' => 'Jyura Buster',
                'es' => 'Cañón Jyura',
            ],
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
        // KULU YA KU EXPANSION
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Iron Gunlance',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Ram',
                'es' => 'Ariete Nergal',
            ],
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
        [
            'parent' => 'Nergal Ram',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Eradication Flame',
                'es' => 'Llama de Aniquilación',
            ],
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
        // KUSHALA EXPANSION
    ],
];
