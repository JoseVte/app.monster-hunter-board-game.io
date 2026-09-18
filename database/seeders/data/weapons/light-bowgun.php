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
        'Chain Blitz' => [
            'default' => true,
            'branch' => 'mineral',
            'name' => 'Saeta Cadena',
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'count_attack_1' => 10,
            'count_attack_2' => 2,
        ],
        'High Chain Blitz' => [
            'parent' => 'Chain Blitz',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => 'Saeta Cadena Mayor',
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'count_attack_1' => 6,
            'count_attack_2' => 6,
            'items' => [
                'Dragonite Ore' => 1,
                'Machalite Ore' => 1,
                'Monster Bone Medium' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 1' => 5,
                ],
                'add' => [
                    'Rapid Normal Ammo 1' => 5,
                ],
            ],
        ],
        'Cross Blitz' => [
            'parent' => 'High Chain Blitz',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => 'Saeta Cruzada',
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'count_attack_1' => 6,
            'count_attack_2' => 4,
            'count_attack_3' => 2,
            'items' => [
                'Fucium Ore' => 2,
                'Carbalite Ore' => 2,
                'Dragonite Ore' => 3,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 1' => 5,
                    'Normal Ammo 2' => 2,
                ],
                'add' => [
                    'Rapid Normal Ammo 1' => 5,
                    'Normal Ammo 3' => 2,
                ],
            ],
        ],
        'Hunter\'s Rifle' => [
            'branch' => 'bone',
            'name' => 'Rifle de Cazador',
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
            'count_attack_1' => 6,
            'count_attack_2' => 4,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        'Power Rifle' => [
            'parent' => 'Hunter\'s Rifle',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => 'Rifle de Poder',
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 2,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Poison Ammo 1' => 2,
                ],
                'add' => [
                    'Recover Ammo 1' => 2,
                ],
            ],
        ],
        'Sniper Shot' => [
            'parent' => 'Power Rifle',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => 'Francotirador',
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
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
                    'Poison Ammo 1' => 2,
                    'Spread Ammo 1' => 2,
                ],
                'add' => [
                    'Recover Ammo 1' => 2,
                    'Spread Ammo 2' => 2,
                ],
            ],
        ],
        // ANCIENT FOREST
        'Jagras Blitz' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Chain Blitz',
            'branch' => 'Great Jagras',
            'rarity' => 3,
            'name' => 'Saeta Jagras',
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 7,
            'count_attack_3' => 2,
            'items' => [
                'Great Jagras Claw' => 1,
                'Great Jagras Hide' => 1,
                'Great Jagras Scale' => 3,
                'Sharp Claw' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 1' => 5,
                ],
                'add' => [
                    'Water Ammo' => 5,
                ],
            ],
        ],
        'Jagras Fire' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Jagras Blitz',
            'branch' => 'Great Jagras',
            'rarity' => 4,
            'name' => 'Fuego Jagras',
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
            'has_elemental_attacks' => true,
            'count_attack_2' => 5,
            'count_attack_3' => 8,
            'count_attack_4' => 1,
            'items' => [
                'Great Jagras Scale' => 2,
                'Great Jagras Claw' => 2,
                'Great Jagras Mane' => 2,
                'Piercing Claw' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 1' => 5,
                    'Poison Ammo 1' => 2,
                ],
                'add' => [
                    'Water Ammo' => 5,
                    'Recover Ammo 2' => 2,
                ],
            ],
        ],
        'Flame Blitz' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Chain Blitz',
            'branch' => 'Rathalos',
            'rarity' => 3,
            'name' => 'Saeta Abrasadora',
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 4,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Webbing' => 2,
                'Inferno Sac' => 1,
                'Rathalos Marrow' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 1' => 5,
                ],
                'add' => [
                    'Rapid Flaming Ammo' => 5,
                ],
            ],
        ],
        'Rathbuster' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Flame Blitz',
            'branch' => 'Rathalos',
            'rarity' => 4,
            'name' => 'Rathcazadora',
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'has_elemental_attacks' => true,
            'count_attack_1' => 4,
            'count_attack_2' => 4,
            'count_attack_3' => 4,
            'count_attack_4' => 2,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Carapace' => 1,
                'Rathalos Wing' => 1,
                'Rathalos Medulla' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 1' => 5,
                    'Normal Ammo 2' => 2,
                ],
                'add' => [
                    'Rapid Flaming Ammo' => 5,
                    'Flaming Ammo' => 2,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        'Carapace Rifle' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Hunter\'s Rifle',
            'branch' => 'Barroth',
            'rarity' => 3,
            'name' => 'Rifle Acorazada',
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
            'count_attack_1' => 3,
            'count_attack_2' => 2,
            'count_attack_3' => 5,
            'items' => [
                'Barroth Claw' => 1,
                'Barroth Shell' => 4,
                'Barroth Ridge' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Poison Ammo 1' => 2,
                ],
                'add' => [
                    'Armour Ammo 1' => 2,
                ],
            ],
        ],
        'Barroth Shot' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Carapace Rifle',
            'branch' => 'Barroth',
            'rarity' => 4,
            'name' => 'Tiro Barroth',
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
            'count_attack_2' => 9,
            'count_attack_3' => 2,
            'count_attack_4' => 1,
            'items' => [
                'Barroth Claw' => 2,
                'Barroth Carapace' => 3,
                'Barroth Ridge' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Poison Ammo 1' => 2,
                    'Pierce Ammo 1' => 2,
                ],
                'add' => [
                    'Armour Ammo 1' => 2,
                    'Paralysis Ammo' => 2,
                ],
            ],
        ],
        'Madness Rifle' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Hunter\'s Rifle',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
            'name' => 'Rifle Maníaco',
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'has_elemental_attacks' => true,
            'count_attack_1' => 4,
            'count_attack_2' => 3,
            'count_attack_3' => 3,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Shell' => 2,
                'Jyuratodus Scale' => 3,
                'Aqua Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 2' => 2,
                ],
                'add' => [
                    'Rapid Water Ammo' => 2,
                ],
            ],
        ],
        'Jyura Bullet' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Madness Rifle',
            'branch' => 'Jyuratodus',
            'rarity' => 4,
            'name' => 'Bala Jyura',
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 4,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Carapace' => 2,
                'Jyuratodus Scale' => 2,
                'Aqua Sac' => 1,
                'Gajau Scale' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 2' => 2,
                    'Poison Ammo 1' => 2,
                ],
                'add' => [
                    'Rapid Water Ammo' => 2,
                    'Sleep Ammo' => 2,
                ],
            ],
        ],
        // KULU YA KU EXPANSION <NONE>
        // NERGIGANTE EXPANSION
        'Nergal Spitter' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Chain Blitz',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => 'Escupidora Nergal',
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
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
        'Cataclysm\'s Trigger' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Nergal Spitter',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => 'Gatillo Catastrófico',
            'deviation' => App\Enum\DeviationWeapon::AVERAGE,
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
        // TEOSTRA EXPANSION <NONE>
        // KUSHALA EXPANSION
        'Icesteel Wasp' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Chain Blitz',
            'branch' => 'Kushala Daora',
            'rarity' => 4,
            'name' => 'Avispa Acero Helado',
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'has_elemental_attacks' => true,
            'count_attack_1' => 1,
            'count_attack_2' => 9,
            'count_attack_3' => 2,
            'count_attack_4' => 2,
            'items' => [
                'Daora Claw' => 1,
                'Daora Webbing' => 2,
                'Nergigante Carapace' => 1,
                'Daora Tail' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Poison Ammo 1' => 2,
                ],
                'add' => [
                    'Freeze Ammo' => 2,
                ],
            ],
        ],
        'Daora\'s Hornet' => [
            'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
            'parent' => 'Icesteel Wasp',
            'branch' => 'Kushala Daora',
            'rarity' => 5,
            'name' => 'Aguijón Daora',
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 9,
            'count_attack_3' => 3,
            'count_attack_4' => 2,
            'items' => [
                'Daora Horn' => 4,
                'Daora Claw' => 3,
                'Daora Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Poison Ammo 1' => 2,
                    'Wyvernblast' => 1,
                    'Any Card' => 1,
                ],
                'add' => [
                    'Freeze Ammo' => 2,
                    'Freezing Wyvernblast' => 2,
                ],
            ],
        ],
        // KIRIN EXPANSION
        'Mythical Horn' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Hunter\'s Rifle',
            'branch' => 'Kirin',
            'rarity' => 4,
            'name' => 'Espina Mítica',
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'has_elemental_attacks' => true,
            'count_attack_1' => 1,
            'count_attack_2' => 5,
            'count_attack_3' => 5,
            'count_attack_4' => 1,
            'items' => [
                'Kirin Thunderhorn' => 3,
                'Kirin Hide' => 3,
                'Kirin Tail' => 1,
                'Lightcrystal' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 1' => 5,
                ],
                'add' => [
                    'Static Ammo' => 5,
                ],
            ],
        ],
        'Mythical Three-Horn' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Mythical Horn',
            'branch' => 'Kirin',
            'rarity' => 5,
            'name' => 'Tricornio Mítico',
            'deviation' => App\Enum\DeviationWeapon::LOW,
            'has_elemental_attacks' => true,
            'count_attack_2' => 7,
            'count_attack_3' => 4,
            'count_attack_4' => 3,
            'items' => [
                'Kirin Azure Horn' => 2,
                'Kirin Hide' => 2,
                'Kirin Mane' => 2,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Normal Ammo 1' => 5,
                    'Reload' => 2,
                ],
                'add' => [
                    'Static Ammo' => 5,
                    'Thunderous Reload' => 2,
                ],
            ],
        ],
    ],
];
