<?php

return [
    'name' => [
        'en' => 'Insect Glaive',
        'es' => 'Glaive Insecto',
    ],
    'description' => [
        'en' => 'During set up, shuffle the three Kinsect: Harvest Extract cards and place them face down in a row above your stamina board.<br>
At the start of your turn, flip the leftmost face down Kinsect: Harvest Extract card face up. When you play an attack card with a :kinsect_icon_1: :kinsect_icon_2: :kinsect_icon_3: matching a face up Kinsect: Harvest Extract card, it gains the bonus effect from the matching Kinsect: Harvest Extract card.<br>
If you have three face up Kinsect: Harvest Extract cards at the end of your turn, pick them all up, shuffle them, and place them face down in a row above your stamina board.',
        'es' => 'Durante la configuración, baraja las tres cartas de Kinsect: Harvest Extract y colócalas boca abajo en una fila sobre tu tablero de resistencia.<br>
Al comienzo de tu turno, voltea la carta Kinsect: Harvest Extract boca abajo boca arriba. Cuando juegas una carta de ataque con una :kinsect_icon_1: :kinsect_icon_2: :kinsect_icon_3: que coincide con una carta de Kinsect: Harvest Extract boca arriba, obtiene el efecto de bonificación de la carta de Kinsect: Harvest Extract correspondiente.<br>
Si tienes tres cartas boca arriba de Kinsect: Harvest Extract al final de tu turno, recógelas todas, barájalas y colócalas boca abajo en una fila sobre tu tablero de resistencia.',
    ],
    'image' => 'icon_weapon_11.png',
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Iron Blade',
                'es' => 'Vara Férrea',
            ],
            'count_attack_1' => 10,
            'count_attack_2' => 2,
        ],
        // ANCIENT FOREST
        // WILDSPIRE WASTE
        // KULU YA KU EXPANSION
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Iron Blade',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Reaper',
                'es' => 'Choque Nergal',
            ],
            'count_attack_1' => 2,
            'count_attack_2' => 4,
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
                    'White Kinsect: Harvest Extract' => 1,
                ],
                'add' => [
                    'Nergigante Kinsect: Harvest Extract' => 1,
                ],
            ],
        ],
        [
            'parent' => 'Nergal Reaper',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Catastrophe\'s Light',
                'es' => 'Catástrofe Regia',
            ],
            'count_attack_2' => 6,
            'count_attack_3' => 5,
            'count_attack_4' => 3,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'White Kinsect: Harvest Extract' => 1,
                    'Wide Sweep' => 3,
                ],
                'add' => [
                    'Nergigante Kinsect: Harvest Extract' => 1,
                    'Crushing Sweep' => 3,
                ],
            ],
        ],
        // KUSHALA EXPANSION
    ],
];
