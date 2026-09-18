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
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'count_attack_1' => 9,
            'count_attack_2' => 3,
        ],
        [
            'parent' => 'Iron Assault',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => [
                'en' => 'Steel Assault',
                'es' => 'Asalto Acerado',
            ],
            'deviation' => App\Enum\DeviationWeapon::LOW,
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
                    'Pierce Ammo 2' => 2,
                ],
                'add' => [
                    'Pierce Ammo 3' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Steel Assault',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => [
                'en' => 'Chrome Assault',
                'es' => 'Cromoasalto',
            ],
            'deviation' => App\Enum\DeviationWeapon::LOW,
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
                    'Pierce Ammo 2' => 2,
                    'Normal Ammo 2' => 2,
                ],
                'add' => [
                    'Pierce Ammo 3' => 2,
                    'Normal Ammo 3' => 2,
                ],
            ],
        ],
        [
            'branch' => 'bone',
            'name' => [
                'en' => 'Bone Shooter',
                'es' => 'Disparahueso',
            ],
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
            'count_attack_1' => 6,
            'count_attack_2' => 4,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        [
            'parent' => 'Bone Shooter',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => [
                'en' => 'Heavy Shooter',
                'es' => 'Cañón Pesado',
            ],
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
            'count_attack_1' => 4,
            'count_attack_2' => 5,
            'count_attack_3' => 1,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Sticky Ammo 1' => 1,
                    'Any Card' => 1,
                ],
                'add' => [
                    'Sticky Ammo 2' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Heavy Shooter',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => [
                'en' => 'Power Shooter',
                'es' => 'Superdisparadora',
            ],
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
            'count_attack_1' => 4,
            'count_attack_2' => 4,
            'count_attack_3' => 2,
            'items' => [
                'Monster Hardbone' => 2,
                'Monster Keenbone' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Sticky Ammo 1' => 1,
                    'Spread Ammo 1' => 2,
                    'Any Card' => 1,
                ],
                'add' => [
                    'Sticky Ammo 2' => 2,
                    'Spread Ammo 2' => 2,
                ],
            ],
        ],
        // ANCIENT FOREST
        [
            'parent' => 'Iron Assault',
            'branch' => 'Great Jagras',
            'rarity' => 3,
            'name' => [
                'en' => 'Jagras Assault',
                'es' => 'Asalto Jagras',
            ],
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
            'has_elemental_attacks' => true,
            'count_attack_1' => 4,
            'count_attack_2' => 4,
            'count_attack_3' => 4,
            'items' => [
                'Great Jagras Claw' => 1,
                'Great Jagras Hide' => 1,
                'Great Jagras Scale' => 3,
                'Sharp Claw' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Pierce Ammo 2' => 2,
                ],
                'add' => [
                    'Water Ammo' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Jagras Assault',
            'branch' => 'Great Jagras',
            'rarity' => 4,
            'name' => [
                'en' => 'Jagras Hacker',
                'es' => 'Cortador Jagras',
            ],
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
            'has_elemental_attacks' => true,
            'count_attack_1' => 6,
            'count_attack_2' => 1,
            'count_attack_3' => 5,
            'count_attack_4' => 2,
            'items' => [
                'Great Jagras Scale' => 2,
                'Great Jagras Claw' => 2,
                'Great Jagras Mane' => 2,
                'Piercing Claw' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Pierce Ammo 2' => 2,
                    'Wyvernsnipe' => 1,
                    'Any Card' => 1,
                ],
                'add' => [
                    'Water Ammo' => 2,
                    'Jagras Wyvernheart' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Bone Shooter',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
            'name' => [
                'en' => 'Pulsar Shooter',
                'es' => 'Cañón Púlsar',
            ],
            'deviation' => App\Enum\DeviationWeapon::NONE,
            'has_elemental_attacks' => true,
            'count_attack_1' => 4,
            'count_attack_2' => 2,
            'count_attack_3' => 3,
            'count_attack_4' => 1,
            'items' => [
                'Tobi-Kadachi Claw' => 1,
                'Tobi-Kadachi Scale' => 3,
                'Tobi-Kadachi Pelt' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Pierce Ammo 2' => 2,
                ],
                'add' => [
                    'Electrical Ammo' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Pulsar Shooter',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 4,
            'name' => [
                'en' => 'Kadachi Lion',
                'es' => 'León Kadachi',
            ],
            'deviation' => App\Enum\DeviationWeapon::NONE,
            'has_elemental_attacks' => true,
            'count_attack_1' => 4,
            'count_attack_2' => 3,
            'count_attack_3' => 3,
            'count_attack_4' => 2,
            'items' => [
                'Tobi-Kadachi Claw' => 2,
                'Tobi-Kadachi Scale' => 2,
                'Tobi-Kadachi Pelt' => 2,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Pierce Ammo 2' => 2,
                    'Spread Ammo 1' => 2,
                ],
                'add' => [
                    'Electrical Ammo' => 2,
                    'Thunder Ammo' => 2,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        [
            'parent' => 'Bone Shooter',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
            'name' => [
                'en' => 'Blooming Shooter',
                'es' => 'Ballesta Floral',
            ],
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'count_attack_1' => 3,
            'count_attack_2' => 3,
            'count_attack_3' => 4,
            'items' => [
                'Pukei-Pukei Quill' => 2,
                'Pukei-Pukei Scale' => 2,
                'Poison Sac' => 1,
                'Pukei-Pukei Tail' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 1' => 5,
                ],
                'add' => [
                    'Poison Ammo 1' => 5,
                ],
            ],
        ],
        [
            'parent' => 'Blooming Shooter',
            'branch' => 'Pukei-Pukei',
            'rarity' => 4,
            'name' => [
                'en' => 'Datura Blaster',
                'es' => 'Bláster Datura',
            ],
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'count_attack_1' => 3,
            'count_attack_2' => 3,
            'count_attack_3' => 4,
            'count_attack_4' => 2,
            'items' => [
                'Pukei-Pukei Scale' => 2,
                'Pukei-Pukei Wing' => 2,
                'Toxic Sac' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 1' => 5,
                    'Cluster Bomb 1' => 2,
                ],
                'add' => [
                    'Poison Ammo 1' => 5,
                    'Poison Ammo 2' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Bone Shooter',
            'branch' => 'Diablos',
            'rarity' => 3,
            'name' => [
                'en' => 'Diablos Shooter',
                'es' => 'Cañón Diablos',
            ],
            'deviation' => App\Enum\DeviationWeapon::HIGH,
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 3,
            'count_attack_4' => 2,
            'items' => [
                'Twisted Horn' => 1,
                'Diablos Fang' => 2,
                'Diablos Shell' => 4,
                'Monster Bone Large' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 2' => 2,
                ],
                'add' => [
                    'Brutal Ammo' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Diablos Shooter',
            'branch' => 'Diablos',
            'rarity' => 4,
            'name' => [
                'en' => 'Dual Threat',
                'es' => 'Amenaza Doble',
            ],
            'deviation' => App\Enum\DeviationWeapon::HIGH,
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 3,
            'count_attack_4' => 3,
            'items' => [
                'Majestic Horn' => 2,
                'Diablos Carapace' => 3,
                'Diablos Ridge' => 3,
                'Blos Medulla' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 2' => 2,
                    'Wyvernsnipe' => 1,
                    'Any Card' => 1,
                ],
                'add' => [
                    'Brutal Ammo' => 2,
                    'Wyvern Ammo' => 2,
                ],
            ],
        ],
        // KULU YA KU EXPANSION <NONE>
        // TEOSTRA EXPANSION
        [
            'parent' => 'Iron Assault',
            'branch' => 'Teostra',
            'rarity' => 4,
            'name' => [
                'en' => 'Teostra\'s Artillery',
                'es' => 'Artillería Teostra',
            ],
            'deviation' => App\Enum\DeviationWeapon::LOW,
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
            'deviation' => App\Enum\DeviationWeapon::LOW,
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
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
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
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
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
