<?php

return [
    'name' => [
        'en' => 'Light Bowgun',
        'es' => 'Ballesta Ligera',
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
<tr><td>:deviation_icon_average: Promedio</td><td><strong>12 tarjetas de desviación</strong><br>(2 frontales, 2 laterales, 2 traseras, 2 a tu elección, 4 fallidas)</td></tr>
<tr><td>:deviation_icon_high: Alto</td><td><strong>14 cartas de desviación</strong><br>(2 delanteras, 2 laterales, 2 traseras, 2 a tu elección, 6 señoritas)</td></tr>
</tbody></table><br>
Cuando juegas cartas de ataque, ignoras los arcos de monstruos. Cuando juegues cada carta de ataque, roba también 2 cartas de desviación y elige 1 carta de desviación para resolver. Luego selecciona uno de los arcos de monstruos que se muestran en la tarjeta de desviación. Resuelve tu ataque como si tu cazador estuviera en el arco del monstruo seleccionado.<br>
Si la carta de desviación que eliges falla, no resuelvas tu carta de ataque. Sin embargo, aún coloca la carta de ataque boca arriba en tu tablero de resistencia.<br>
Después de colocar la carta de ataque boca arriba en tu tablero de resistencia, descarta ambas cartas de desviación. Cuando el mazo de desviación esté vacío, baraja su pila de descarte para crear un nuevo mazo de desviación.',
    ],
    'image' => 'icon_weapon_13.png',
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Chain Blitz',
                'es' => 'Saeta Cadena',
            ],
            'deviation' => \App\Enum\DeviationWeapon::LOW,
            'count_attack_1' => 10,
            'count_attack_2' => 2,
        ],
        // ANCIENT FOREST
        // WILDSPIRE WASTE
        // KULU YA KU EXPANSION
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Chain Blitz',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Spitter',
                'es' => 'Escupidora Nergal',
            ],
            'deviation' => \App\Enum\DeviationWeapon::AVERAGE,
            'has_elemental_attacks' => true,
            'count_attack_1' => 1,
            'count_attack_2' => 7,
            'count_attack_3' => 2,
            'count_attack_4' => 2,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 1' => 5,
                ],
                'add' => [
                    'Dragon Ammo' => 5,
                ],
            ],
        ],
        [
            'parent' => 'Nergal Spitter',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Cataclysm\'s Trigger',
                'es' => 'Gatillo Catastrófico',
            ],
            'deviation' => \App\Enum\DeviationWeapon::AVERAGE,
            'has_elemental_attacks' => true,
            'count_attack_2' => 2,
            'count_attack_3' => 7,
            'count_attack_4' => 5,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 1' => 5,
                    'Poison Ammo 1' => 2,
                ],
                'add' => [
                    'Dragon Ammo' => 5,
                    'Armour Ammo 2' => 5,
                ],
            ],
        ],
        // KUSHALA EXPANSION
    ],
];
