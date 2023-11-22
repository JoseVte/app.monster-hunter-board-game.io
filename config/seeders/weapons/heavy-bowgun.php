<?php

return [
    'name' => [
        'en' => 'Heavy Bowgun',
        'es' => 'Ballesta Pesada',
    ],
    'description' => [
        'en' => 'During setup, create a deviation :deviation_icon: deck using the table below and the deviation rating shown on the weapon card. Shuffle the deviation cards and place the deck face down to the side of your stamina board.<br>
<table><thead><tr><th>Deviation Rating</th><th>Deck Composition</th></tr></thead>
<tbody>
<tr><td>:deviation_icon_none: None</td><td><strong>12 Deviation Cards</strong><br>(2 Front, 2 Sides, 2 Rear, 4 Your Choice, 2 Miss)</td></tr>
<tr><td>:deviation_icon_low: Low</td><td><strong>10 Deviation Cards</strong><br>(2 Front, 2 Sides, 2 Rear, 2 Your Choice, 2 Miss)</td></tr>
<tr><td>:deviation_icon_average: Average</td><td><strong>12 Deviation Cards</strong><br>(2 Front, 2 Sides, 2 Rear, 2 Your Choice, 4 Miss)</td></tr>
<tr><td>:deviation_icon_high: High</td><td><strong>14 Deviation Cards</strong><br>(2 Front, 2 Sides, 2 Rear, 2 Your Choice, 6 Miss)</td></tr>
</tbody></table><br>
When you play attack cards, you ignore monster arcs. When you play each attack card, also draw 2 deviation cards and choose 1 deviation card to resolve. Then select one of the monster arcs shown on the deviation card. Resolve your attack as if your hunter were in the selected monster arc.<br>
If the deviation card you choose is a miss, don\'t resolve your attack card. However, still place the attack card face up on your stamina board.<br>
After placing the attack card face up on your stamina board, discard both deviation cards. When the deviation deck is empty, shuffle its discard pile to create a new deviation deck.',
        'es' => 'Durante la configuración, crea un mazo de desviación :deviation_icon: usando la siguiente tabla y el índice de desviación que se muestra en la tarjeta de arma. Baraja las cartas de desviación y coloca el mazo boca abajo al lado de tu tablero de resistencia.<br>
<table><thead><tr><th>Clasificación de desviación</th><th>Composición del mazo</th></tr></thead>
<tcuerpo>
<tr><td>:deviation_icon_none: Ninguno</td><td><strong>12 cartas de desviación</strong><br>(2 frontales, 2 laterales, 2 traseras, 4 a tu elección, 2 fallidas)</td></tr>
<tr><td>:deviation_icon_low: Bajo</td><td><strong>10 cartas de desviación</strong><br>(2 delanteras, 2 laterales, 2 traseras, 2 a tu elección, 2 señoritas)</td></tr>
<tr><td>:deviation_icon_average: Medio</td><td><strong>12 tarjetas de desviación</strong><br>(2 frontales, 2 laterales, 2 traseras, 2 a tu elección, 4 fallidas)</td></tr>
<tr><td>:deviation_icon_high: Alto</td><td><strong>14 cartas de desviación</strong><br>(2 delanteras, 2 laterales, 2 traseras, 2 a tu elección, 6 señoritas)</td></tr>
</tbody></table><br>
Cuando juegas cartas de ataque, ignoras los arcos de monstruos. Cuando juegues cada carta de ataque, roba también 2 cartas de desviación y elige 1 carta de desviación para resolver. Luego selecciona uno de los arcos de monstruos que se muestran en la tarjeta de desviación. Resuelve tu ataque como si tu cazador estuviera en el arco del monstruo seleccionado.<br>
Si la carta de desviación que eliges falla, no resuelvas tu carta de ataque. Sin embargo, aún coloca la carta de ataque boca arriba en tu tablero de resistencia.<br>
Después de colocar la carta de ataque boca arriba en tu tablero de resistencia, descarta ambas cartas de desviación. Cuando el mazo de desviación esté vacío, baraja su pila de descarte para crear un nuevo mazo de desviación.',
    ],
    'image' => 'icon_weapon_14.png',
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Iron Assault',
                'es' => 'Asalto Férreo',
            ],
            'deviation' => \App\Enum\DeviationWeapon::LOW,
            'count_attack_1' => 8,
            'count_attack_2' => 4,
        ],
        // ANCIENT FOREST
        // WILDSPIRE WASTE
        // KULU YA KU EXPANSION
        // TEOSTRA EXPANSION
        [
            'parent' => 'Iron Assault',
            'branch' => 'Teostra',
            'rarity' => 4,
            'name' => [
                'en' => 'Teostra\'s Artillery',
                'es' => 'Artillería Teostra',
            ],
            'deviation' => \App\Enum\DeviationWeapon::LOW,
            'count_attack_2' => 8,
            'count_attack_3' => 4,
            'count_attack_4' => 2,
            'items' => [
                'Teostra Claw' => 1,
                'Teostra Mane' => 1,
                'Teostra Carapace' => 2,
                'Teostra Powder' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Cluster Bomb 1' => 2,
                ],
                'add' => [
                    'Carpet Bomb' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Teostra\'s Artillery',
            'branch' => 'Teostra',
            'rarity' => 5,
            'name' => [
                'en' => 'Teostra\'s Flames',
                'es' => 'Llamarada Teostra',
            ],
            'deviation' => \App\Enum\DeviationWeapon::LOW,
            'count_attack_2' => 10,
            'count_attack_3' => 3,
            'count_attack_4' => 2,
            'count_attack_5' => 1,
            'items' => [
                'Teostra Horn' => 3,
                'Teostra Claw' => 2,
                'Teostra Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Cluster Bomb 1' => 2,
                    'Any Card' => 1,
                    'Wyvernsnape' => 1,
                ],
                'add' => [
                    'Carpet Bomb' => 2,
                    'Teostra Wyvernheart' => 2,
                ],
            ],
        ],
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Iron Assault',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Roar',
                'es' => 'Rúgido Nergal',
            ],
            'deviation' => \App\Enum\DeviationWeapon::AVERAGE,
            'count_attack_2' => 6,
            'count_attack_3' => 2,
            'count_attack_4' => 4,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Any Card' => 2,
                ],
                'add' => [
                    'Shield Mod' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Nergal Roar',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Destruction\'s Fusillade',
                'es' => 'Fusiladora',
            ],
            'deviation' => \App\Enum\DeviationWeapon::AVERAGE,
            'count_attack_2' => 6,
            'count_attack_3' => 5,
            'count_attack_4' => 2,
            'count_attack_5' => 1,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Any Card' => 3,
                    'Wyvernsnipe' => 1,
                ],
                'add' => [
                    'Shield Mod' => 2,
                    'Nergal Wyvernsnipe' => 2,
                ],
            ],
        ],
        // KUSHALA EXPANSION
    ],
];
