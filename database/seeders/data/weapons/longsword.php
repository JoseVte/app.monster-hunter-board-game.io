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
    'image' => 'weapon-types/longsword.svg',
    'weapons' => [
        'Iron Katana' => [
            'default' => true,
            'branch' => 'mineral',
            'name' => 'Katana Férrea',
            'count_attack_1' => 9,
            'count_attack_2' => 3,
        ],
        'Iron Grace' => [
            'parent' => 'Iron Katana',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => 'Gracia Férrea',
            'count_attack_1' => 7,
            'count_attack_2' => 5,
            'items' => [
                'Dragonite Ore' => 1,
                'Machalite Ore' => 1,
                'Monster Bone Medium' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Spirit Thrust' => 2,
                ],
                'add' => [
                    'Enhanced Spirit Thrust' => 2,
                ],
            ],
        ],
        'Iron Gospel' => [
            'parent' => 'Iron Grace',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => 'Palabra Férrea',
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
                    'Spirit Thrust' => 2,
                    'Overhead Slash' => 2,
                ],
                'add' => [
                    'Enhanced Spirit Thrust' => 2,
                    'Enhanced Overhead Slash' => 2,
                ],
            ],
        ],
        'Bone Shotel' => [
            'branch' => 'bone',
            'name' => 'Shotel Óseo',
            'count_attack_1' => 6,
            'count_attack_2' => 4,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        'Hard Bone Shotel' => [
            'parent' => 'Bone Shotel',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => 'Shotel Hueso Pétreo',
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
                    'Foresight Slash' => 2,
                ],
                'add' => [
                    'Enhanced Foresight Slash' => 2,
                ],
            ],
        ],
        'Bone Reaper' => [
            'parent' => 'Hard Bone Shotel',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => 'Segadora Ósea',
            'count_attack_1' => 1,
            'count_attack_2' => 5,
            'count_attack_3' => 2,
            'items' => [
                'Monster Hardbone' => 2,
                'Monster Keenbone' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Foresight Slash' => 2,
                    'Thrust' => 3,
                ],
                'add' => [
                    'Enhanced Foresight Slash' => 2,
                    'Enhanced Thrust' => 3,
                ],
            ],
        ],
        // ANCIENT FOREST
        'Pulsar Shotel' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Bone Shotel',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
            'name' => 'Shotel Púlsar',
            'has_elemental_attacks' => true,
            'count_attack_1' => 1,
            'count_attack_2' => 7,
            'count_attack_3' => 2,
            'items' => [
                'Tobi-Kadachi Claw' => 1,
                'Tobi-Kadachi Pelt' => 3,
                'Tobi-Kadachi Scale' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Fade Slash' => 2,
                ],
                'add' => [
                    'Thunder Fade Slash' => 2,
                ],
            ],
        ],
        'Kadachi Fang' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Pulsar Shotel',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 4,
            'name' => 'Colmillo Kadachi',
            'has_elemental_attacks' => true,
            'count_attack_1' => 1,
            'count_attack_2' => 8,
            'count_attack_3' => 3,
            'items' => [
                'Tobi-Kadachi Claw' => 3,
                'Tobi-Kadachi Scale' => 1,
                'Tobi-Kadachi Pelt' => 1,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Fade Slash' => 2,
                    'Rising Slash' => 2,
                ],
                'add' => [
                    'Thunder Fade Slash' => 2,
                    'Shocking Rising Slash' => 2,
                ],
            ],
        ],
        'Blazing Shotel' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Bone Shotel',
            'branch' => 'Anjanath',
            'rarity' => 3,
            'name' => 'Shotel Flameante',
            'count_attack_1' => 1,
            'count_attack_2' => 9,
            'count_attack_3' => 2,
            'items' => [
                'Anjanath Fang' => 2,
                'Anjanath Scale' => 3,
                'Flame Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Ready Stance' => 2,
                ],
                'add' => [
                    'Poised Stance' => 2,
                ],
            ],
        ],
        'Anja Scimitar' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Blazing Shotel',
            'branch' => 'Anjanath',
            'rarity' => 4,
            'name' => 'Cimitarra Anja',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_1' => 1,
            'count_attack_2' => 9,
            'count_attack_3' => 4,
            'items' => [
                'Anjanath Fang' => 2,
                'Anjanath Scale' => 2,
                'Inferno Sac' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Ready Stance' => 2,
                    'Helm Breaker' => 2,
                ],
                'add' => [
                    'Poised Stance' => 2,
                    'Flaming Helm Breaker' => 2,
                ],
            ],
        ],
        'Wyvern Blade "Fall"' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Iron Katana',
            'branch' => 'Rathalos',
            'rarity' => 3,
            'name' => 'Filo Wyvern "Otoño"',
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 8,
            'count_attack_3' => 2,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Webbing' => 2,
                'Inferno Sac' => 1,
                'Rathalos Marrow' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash' => 2,
                ],
                'add' => [
                    'Blazing Rising Slash' => 2,
                ],
            ],
        ],
        'Wyvern Blade "Blood"' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Wyvern Blade "Fall"',
            'branch' => 'Rathalos',
            'rarity' => 4,
            'name' => 'Filo Wyvern "Sangre"',
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 8,
            'count_attack_3' => 4,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Carapace' => 1,
                'Rathalos Wing' => 1,
                'Rathalos Medulla' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash' => 2,
                    'Spirit Helm Breaker' => 2,
                ],
                'add' => [
                    'Blazing Rising Slash' => 2,
                    'Blazing Helm Breaker' => 2,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        'Jyura Shotel' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Shotel',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
            'name' => 'Shotel Jyura',
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 2,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Shell' => 2,
                'Jyuratodus Scale' => 3,
                'Aqua Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Helm Breaker' => 2,
                ],
                'add' => [
                    'Mud Helm Breaker' => 2,
                ],
            ],
        ],
        'Dipterus' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Jyura Shotel',
            'branch' => 'Jyuratodus',
            'rarity' => 4,
            'name' => 'Díptero',
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 7,
            'count_attack_4' => 3,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Carapace' => 2,
                'Jyuratodus Scale' => 2,
                'Aqua Sac' => 1,
                'Gajau Scale' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Helm Breaker' => 2,
                    'Spirit Thrust' => 2,
                ],
                'add' => [
                    'Mud Helm Breaker' => 2,
                    'Water Spirit Thrust' => 2,
                ],
            ],
        ],
        // KULU YA KU EXPANSION
        'First Dance' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'Iron Katana',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 3,
            'name' => 'Primer Baile',
            'count_attack_1' => 6,
            'count_attack_2' => 3,
            'count_attack_3' => 5,
            'items' => [
                'Kulu-Ya-Ku Beak' => 1,
                'Kulu-Ya-Ku Hide' => 2,
                'Kulu-Ya-Ku Scale' => 4,
                'Earth Crystal' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Thrust' => 2,
                ],
                'add' => [
                    'Evasive Thrust' => 2,
                ],
            ],
        ],
        'Last Dance' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'First Dance',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 4,
            'name' => 'Último Baile',
            'count_attack_1' => 5,
            'count_attack_2' => 7,
            'count_attack_3' => 4,
            'items' => [
                'Kulu-Ya-Ku Beak' => 2,
                'Kulu-Ya-Ku Hide' => 3,
                'Kulu-Ya-Ku Plume' => 3,
                'Boulder Bone' => 4,
            ],
            'attacks' => [
                'remove' => [
                    'Thrust' => 2,
                    'Overhead Slash' => 2,
                ],
                'add' => [
                    'Evasive Thrust' => 2,
                    'Evasive Overhead Slash' => 2,
                ],
            ],
        ],
        // NERGIGANTE EXPANSION
        'Nergal Reaver' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Iron Katana',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => 'Segadora Nergal',
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
        'Extermination\'s Edge' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Nergal Reaver',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => 'Filo Exterminador',
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
        // TEOSTRA EXPANSION
        'Imperial Saber' => [
            'expansion' => App\Enum\MonsterExpansion::TEOSTRA_EXPANSION,
            'parent' => 'Iron Katana',
            'branch' => 'Teostra',
            'rarity' => 4,
            'name' => 'Sable Imperial',
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
        'Imperial Shimmer' => [
            'expansion' => App\Enum\MonsterExpansion::TEOSTRA_EXPANSION,
            'parent' => 'Imperial Saber',
            'branch' => 'Teostra',
            'rarity' => 5,
            'name' => 'Destello Imperial',
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
        // KUSHALA EXPANSION <NONE>
    ],
];
