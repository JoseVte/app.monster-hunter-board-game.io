<?php

return [
    'name' => [
        'en' => 'Longsword',
        'es' => 'Espada Larga',
    ],
    'description' => [
        'en' => 'During setup, place the spirit card next to your stamina board with the white-only side at the top. Your attack cards have a spirit symbol with colours matching sides of the spirit card.<br>
Attack cards will instruct you when to rotate the spirit card, and in which direction. The spirit card is always rotated 90 degrees at a time.<br>
You may only play attack cards wit a spirit symbol if all the colours in the symbol are currently at the rop of the spirit card.<br>
When the white-only spirit symbol is at the top, the spirit card can\'t be rotated anti-clockwise. When the red spirit symbol is at the top, the spirit card can\'t be rotated clockwise.',
        'es' => 'Durante la configuración, coloca la carta de espíritu al lado de tu tablero de resistencia con el lado blanco en la parte superior. Tus cartas de ataque tienen un símbolo de espíritu con colores que coinciden con los lados de la carta de espíritu.<br>
Las cartas de ataque te indicarán cuándo rotar la carta espiritual y en qué dirección. La carta espiritual siempre se gira 90 grados a la vez.<br>
Solo puedes jugar cartas de ataque con un símbolo de espíritu si todos los colores del símbolo están actualmente en la posición de la carta de espíritu.<br>
Cuando el símbolo del espíritu solo blanco está en la parte superior, la carta del espíritu no se puede girar en el sentido contrario a las agujas del reloj. Cuando el símbolo del espíritu rojo está en la parte superior, la carta del espíritu no se puede girar en el sentido de las agujas del reloj.',
    ],
    'image' => 'icon_weapon_02.png',
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Iron Katana',
                'es' => 'Katana Férrea',
            ],
            'count_attack_1' => 9,
            'count_attack_2' => 3,
        ],
        // ANCIENT FOREST
        // WILDSPIRE WASTE
        // KULU YA KU EXPANSION
        // TEOSTRA EXPANSION
        [
            'parent' => 'Iron Katana',
            'branch' => 'Teostra',
            'rarity' => 4,
            'name' => [
                'en' => 'Imperial Saber',
                'es' => 'Sable Imperial',
            ],
            'count_attack_2' => 9,
            'count_attack_3' => 5,
            'items' => [
                'Teostra Claw' => 1,
                'Teostra Mane' => 1,
                'Teostra Carapace' => 2,
                'Teostra Powder' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Fade Slash' => 2,
                ],
                'add' => [
                    'Fading Blast Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Imperial Saber',
            'branch' => 'Teostra',
            'rarity' => 5,
            'name' => [
                'en' => 'Imperial Shimmer',
                'es' => 'Destello Imperial',
            ],
            'count_attack_2' => 9,
            'count_attack_3' => 6,
            'count_attack_4' => 1,
            'items' => [
                'Teostra Horn' => 3,
                'Teostra Claw' => 2,
                'Teostra Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Fade Slash' => 2,
                    'Spirit Thrust' => 2,
                ],
                'add' => [
                    'Fading Blast Slash' => 2,
                    'Blasting Spirit Thrust' => 2,
                ],
            ],
        ],
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Iron Katana',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Reaver',
                'es' => 'Segadora Nergal',
            ],
            'has_elemental_attacks' => true,
            'count_attack_2' => 7,
            'count_attack_3' => 3,
            'count_attack_4' => 2,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Foresight Slash' => 2,
                ],
                'add' => [
                    'Dragon Foresight Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Nergal Reaver',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Extermination\'s Edge',
                'es' => 'Filo Exterminador',
            ],
            'has_elemental_attacks' => true,
            'count_attack_2' => 7,
            'count_attack_3' => 4,
            'count_attack_4' => 3,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Foresight Slash' => 2,
                    'Spirit Helm Breaker' => 2,
                ],
                'add' => [
                    'Dragon Foresight Slash' => 2,
                    'Dragon Helm Breaker' => 2,
                ],
            ],
        ],
        // KUSHALA EXPANSION
    ],
];
