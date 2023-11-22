<?php

return [
    'Great Jagras' => [
        'name' => 'Gran Jagras',
        'category' => \App\Enum\MonsterCategory::FANGED_WYVERN,
        'expansion' => \App\Enum\MonsterExpansion::ANCIENT_FOREST,
        'items' => [
            'Great Jagras Hide',
            'Great Jagras Mane',
            'Great Jagras Claw',
            'Great Jagras Scale',

            'Monster Bone Small',
            'Sharp Claw',
            'Piercing Claw',
        ],
        'resistance' => [
            'fire' => 1,
            'water' => null,
            'thunder' => 2,
            'ice' => 2,
            'dragon' => null,

            'paralysis' => 1,
            'poison' => 1,
            'sleep' => 1,
            'nitro' => 1,
            'stun' => 2,
        ],
        'difficulty' => [
            [
                'difficulty' => \App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 50,
                'ability' => [
                    'name' => [
                        'en' => 'Gluttonous',
                        'es' => 'Glotón',
                    ],
                    'description' => [
                        'en' => 'Each time this monster deals 1 or more damage to a hunter it regains 1 lost health.',
                        'es' => 'Cada vez que este monstruo inflige 1 o más daños a un cazador, recupera 1 de salud perdida.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 0,
                        'broken' => 4,
                        'ability-broken' => [
                            'en' => 'Behaviours with :water_icon: inflict physical damage instead of elemental damage.',
                            'es' => 'Los comportamientos con :water_icon: infligen daño físico en lugar de daño elemental.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'down',
                        'defense' => 1,
                        'broken' => 3,
                        'ability-broken' => [
                            'en' => 'The monster suffers 5 damage.',
                            'es' => 'El monstruo sufre 5 daños.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 0,
                        'broken' => 3,
                    ],
                ],
            ],
            [
                'difficulty' => \App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 60,
                'ability' => [
                    'name' => [
                        'en' => 'Irritable',
                        'es' => 'Irritable',
                    ],
                    'description' => [
                        'en' => 'Each time this monster deals 1 or more damage to a hunter it regains 1 lost health. While this monster has at least 1 broken body part, behaviours this monster performs gain +1 :damage_monster_icon: and +1 :dodge_icon:.',
                        'es' => 'Cada vez que este monstruo inflige 1 o más daños a un cazador, recupera 1 de salud perdida. Mientras este monstruo tenga al menos 1 parte del cuerpo rota, los comportamientos que realiza este monstruo ganan +1 :damage_monster_icon: y +1 :dodge_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 0,
                        'broken' => 4,
                        'ability-broken' => [
                            'en' => 'Behaviours with :water_icon: inflict physical damage instead of elemental damage.',
                            'es' => 'Los comportamientos con :water_icon: infligen daño físico en lugar de daño elemental.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'down',
                        'defense' => 1,
                        'broken' => 4,
                        'ability-broken' => [
                            'en' => 'The monster suffers 5 damage.',
                            'es' => 'El monstruo sufre 5 daños.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 1,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :claw_icon: have -1 :movement_icon:.',
                            'es' => 'Los comportamientos con :claw_icon: tienen -1 :movement_icon:.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => \App\Enum\MonsterDifficulty::HARD,
                'stars' => 3,
                'health' => 65,
                'ability' => [
                    'name' => [
                        'en' => 'Jagras Alpha',
                        'es' => 'Jagras Alpha',
                    ],
                    'description' => [
                        'en' => 'Each time this monster deals 1 or more damage to a hunter it regains 1 lost health. Behaviours this monster performs gain +1 :damage_monster_icon: and +1 :dodge_icon:.',
                        'es' => 'Cada vez que este monstruo inflige 1 o más daños a un cazador, recupera 1 de salud perdida. Los comportamientos que realiza este monstruo ganan +1 :damage_monster_icon: y +1 :dodge_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 1,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :water_icon: inflict physical damage instead of elemental damage.',
                            'es' => 'Los comportamientos con :water_icon: infligen daño físico en lugar de daño elemental.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'down',
                        'defense' => 2,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => "The monster doesn't regain lost health when it damages hunters.",
                            'es' => 'El monstruo no recupera la salud perdida cuando daña a los cazadores.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 1,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :claw_icon: have -1 :movement_icon:.',
                            'es' => 'Los comportamientos con :claw_icon: tienen -1 :movement_icon:.',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            1 => [
                'name' => 'Monster Bone Small',
            ],
            2 => [
                'name' => 'Great Jagras Claw',
            ],
            3 => [
                'name' => 'Great Jagras Hide',
            ],
            4 => [
                'name' => 'Great Jagras Scale',
            ],
            5 => [
                'name' => 'Great Jagras Mane',
            ],
            6 => [
                'name' => 'Great Jagras Claw',
                'extra' => [
                    'en' => 'Gain 1 if the :claw_icon: were broken.',
                    'es' => 'Gana 1 si el :claw_icon: estuviera roto.',
                ],
            ],
            7 => [
                'name' => 'Sharp Claw',
            ],
            8 => [
                'name' => 'Piercing Claw',
            ],
            9 => [
                'name' => 'Monster Bone Small',
            ],
            10 => [
                'name' => 'Great Jagras Hide',
                'extra' => [
                    'en' => 'Gain 1 if the :back_icon: were broken.',
                    'es' => 'Gana 1 si el :back_icon: estuviera roto.',
                ],
            ],
            11 => [
                'name' => 'Great Jagras Scale',
            ],
            12 => [
                'name' => 'Great Jagras Mane',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
        ],
    ],
    'Tobi-Kadachi' => [
        'category' => \App\Enum\MonsterCategory::FANGED_WYVERN,
        'expansion' => \App\Enum\MonsterExpansion::ANCIENT_FOREST,
        'items' => [
            'Tobi-Kadachi Pelt',
            'Tobi-Kadachi Claw',
            'Tobi-Kadachi Membrane',
            'Tobi-Kadachi Scale',
            'Tobi-Kadachi Electrode',
            'Electro Sac',
            'Thunder Sac',

            'Monster Bone Medium',
            'Monster Keenbone',
        ],
        'resistance' => [
            'fire' => 2,
            'water' => 1,
            'thunder' => null,
            'ice' => 2,
            'dragon' => null,

            'paralysis' => 2,
            'poison' => 1,
            'sleep' => 2,
            'nitro' => 2,
            'stun' => 2,
        ],
        'difficulty' => [
            [
                'difficulty' => \App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 60,
                'ability' => [
                    'name' => [
                        'en' => 'Shocking',
                        'es' => 'Impactante',
                    ],
                    'description' => [
                        'en' => "When you determine Tobi-Kadachi's target for a :thunder_icon: behaviour remove Tobi-Kadachi from the board. Place Tobi-Kadachi on the farthest rock node from its current node without changing its facing. If there are multiple farthest rock nodes, the players choose. Move any hunters on that node as if Tobi-Kadachi had moved onto the node. Then resolve the behaviour as normal.",
                        'es' => 'Cuando determines el objetivo de Tobi-Kadachi para un comportamiento :thunder_icon: elimina a Tobi-Kadachi del tablero. Coloca a Tobi-Kadachi en el nodo de roca más alejado de su nodo actual sin cambiar su orientación. Si hay varios nodos rocosos más lejanos, los jugadores eligen. Mueva cualquier cazador en ese nodo como si Tobi-Kadachi se hubiera movido al nodo. Luego resuelva el comportamiento de manera normal.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 1,
                        'broken' => 3,
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 1,
                        'broken' => 4,
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right',
                        'defense' => 2,
                        'broken' => 3,
                        'ability-broken' => [
                            'en' => 'Behaviours with :paralysis_icon: have -1 :damage_icon:.',
                            'es' => 'Los comportamientos con :paralysis_icon: tienen -1 :damage_icon:.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => \App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 65,
                'ability' => [
                    'name' => [
                        'en' => 'Electrifying',
                        'es' => 'Electrizante',
                    ],
                    'description' => [
                        'en' => "When you determine Tobi-Kadachi's target for a :thunder_icon: behaviour remove Tobi-Kadachi from the board. Place Tobi-Kadachi on the farthest rock node from its current node without changing its facing. If there are multiple farthest rock nodes, the players choose. Move any hunters on that node as if Tobi-Kadachi had moved onto the node. Then resolve the behaviour as normal. Behaviours with :thunder_icon: have +2 :damage_icon:.",
                        'es' => 'Cuando determines el objetivo de Tobi-Kadachi para un comportamiento :thunder_icon: elimina a Tobi-Kadachi del tablero. Coloca a Tobi-Kadachi en el nodo de roca más alejado de su nodo actual sin cambiar su orientación. Si hay varios nodos rocosos más lejanos, los jugadores eligen. Mueva cualquier cazador en ese nodo como si Tobi-Kadachi se hubiera movido al nodo. Luego resuelva el comportamiento de manera normal. Los comportamientos con :thunder_icon: tienen +2 :damage_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 2,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Remove Leaping Bite from the behaviour deck. Shuffle discarded behaviour cards into the deck.',
                            'es' => 'Elimina Mordedura Saltadora del mazo de comportamiento. Baraja las cartas de comportamiento descartadas en el mazo.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 1,
                        'broken' => 4,
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right',
                        'defense' => 2,
                        'broken' => 4,
                        'ability-broken' => [
                            'en' => 'Behaviours with :paralysis_icon: have -1 :damage_icon:.',
                            'es' => 'Los comportamientos con :paralysis_icon: tienen -1 :damage_icon:.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => \App\Enum\MonsterDifficulty::HARD,
                'stars' => 3,
                'health' => 70,
                'ability' => [
                    'name' => [
                        'en' => 'Static Charge',
                        'es' => 'Carga Estática',
                    ],
                    'description' => [
                        'en' => 'Each time this monster deals 1 or more damage to a hunter it regains 1 lost health. Behaviours this monster performs gain +1 :damage_monster_icon: and +1 :dodge_icon:.',
                        'es' => 'Cada vez que este monstruo inflige 1 o más daños a un cazador, recupera 1 de salud perdida. Los comportamientos que realiza este monstruo ganan +1 :damage_monster_icon: y +1 :dodge_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 2,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Remove Leaping Bite from the behaviour deck. Shuffle discarded behaviour cards into the deck.',
                            'es' => 'Elimina Mordedura Saltadora del mazo de comportamiento. Baraja las cartas de comportamiento descartadas en el mazo.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 2,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :thunder_icon: have -1 :damage_icon:.',
                            'es' => 'Los comportamientos con :thunder_icon: tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right',
                        'defense' => 3,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :paralysis_icon: have -1 :damage_icon:.',
                            'es' => 'Los comportamientos con :paralysis_icon: tienen -1 :damage_icon:.',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            1 => [
                'name' => 'Monster Bone Medium',
            ],
            2 => [
                'name' => 'Tobi-Kadachi Pelt',
                'extra' => [
                    'en' => 'Gain 1 if the :back_icon: were broken.',
                    'es' => 'Gana 1 si el :back_icon: estuviera roto.',
                ],
            ],
            3 => [
                'name' => 'Tobi-Kadachi Scale',
            ],
            4 => [
                'name' => 'Electro Sac',
            ],
            5 => [
                'name' => 'Tobi-Kadachi Electrode',
            ],
            6 => [
                'name' => 'Tobi-Kadachi Membrane',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
            7 => [
                'name' => 'Monster Keenbone',
            ],
            8 => [
                'name' => 'Tobi-Kadachi Claw',
            ],
            9 => [
                'name' => 'Monster Bone Medium',
            ],
            10 => [
                'name' => 'Thunder Sac',
            ],
            11 => [
                'name' => 'Monster Keenbone',
            ],
            12 => [
                'name' => 'Tobi-Kadachi Electrode',
                'extra' => [
                    'en' => 'Gain 1 if the :tail_icon: were broken.',
                    'es' => 'Gana 1 si el :tail_icon: estuviera roto.',
                ],
            ],
        ],
    ],
    'Anjanath' => [
        'category' => \App\Enum\MonsterCategory::BRUTE_WYVERN,
        'expansion' => \App\Enum\MonsterExpansion::ANCIENT_FOREST,
        'items' => [
            'Anjanath Pelt',
            'Anjanath Scale',
            'Anjanath Tail',
            'Anjanath Fang',
            'Anjanath Nosebone',
            'Flame Sac',
            'Inferno Sac',

            'Monster Bone Large',
            'Monster Keenbone',
        ],
        'resistance' => [
            'fire' => null,
            'water' => 1,
            'thunder' => 2,
            'ice' => 2,
            'dragon' => null,

            'paralysis' => 2,
            'poison' => 2,
            'sleep' => 2,
            'nitro' => null,
            'stun' => 2,
        ],
        'difficulty' => [
            [
                'difficulty' => \App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 65,
                'ability' => [
                    'name' => [
                        'en' => 'Reckless Agression',
                        'es' => 'Agresión Imprudente',
                    ],
                    'description' => [
                        'en' => 'Each time this monster suffers 4 or more damage from an attack card, after the attack is resolved the monster moves 2 nodes toward :far_hunter_icon:.',
                        'es' => 'Cada vez que este monstruo sufre 4 o más daños de una carta de ataque, después de resolver el ataque, el monstruo se mueve 2 nodos hacia :far_hunter_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 2,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :fire_icon: have -1 :damage_icon:.',
                            'es' => 'Los comportamientos con :fire_icon: tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'up-left-right',
                        'defense' => 2,
                        'broken' => 5,
                    ],
                    [
                        'icon' => 'leg',
                        'direction' => 'left-right',
                        'defense' => 2,
                        'broken' => 4,
                        'ability-broken' => [
                            'en' => 'Remove Crush from the behaviour deck. Shuffle discarded behaviour cards into the deck.',
                            'es' => 'Elimina Aplastar del mazo de comportamiento. Baraja las cartas de comportamiento descartadas en el mazo.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 1,
                        'broken' => 4,
                    ],
                ],
            ],
            [
                'difficulty' => \App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 70,
                'ability' => [
                    'name' => [
                        'en' => 'Flaming Anger',
                        'es' => 'Ira Llameante',
                    ],
                    'description' => [
                        'en' => 'Each time this monster suffers 4 or more damage from an attack card, after the attack is resolved the monster moves 2 nodes toward :far_hunter_icon:. Behaviours with :fire_icon: have +1 :damage_icon:.',
                        'es' => 'Cada vez que este monstruo sufre 4 o más daños de una carta de ataque, después de resolver el ataque, el monstruo se mueve 2 nodos hacia :far_hunter_icon:. Los comportamientos con :fire_icon: tienen +1 :damage_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 2,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :fire_icon: have -1 :damage_icon:.',
                            'es' => 'Los comportamientos con :fire_icon: tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'up-left-right',
                        'defense' => 3,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => "Discard the top card of the monster's behaviour deck.",
                            'es' => 'Descarta la carta superior del mazo de comportamiento del monstruo.',
                        ],
                    ],
                    [
                        'icon' => 'leg',
                        'direction' => 'left-right',
                        'defense' => 2,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Remove Crush from the behaviour deck. Shuffle discarded behaviour cards into the deck.',
                            'es' => 'Elimina Aplastar del mazo de comportamiento. Baraja las cartas de comportamiento descartadas en el mazo.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 2,
                        'broken' => 5,
                    ],
                ],
            ],
            [
                'difficulty' => \App\Enum\MonsterDifficulty::HARD,
                'stars' => 3,
                'health' => 75,
                'ability' => [
                    'name' => [
                        'en' => 'Burning Wrath',
                        'es' => 'Ira Ardiente',
                    ],
                    'description' => [
                        'en' => 'Each time this monster suffers 4 or more damage from an attack card, after the attack is resolved the monster moves 2 nodes toward :far_hunter_icon:. Behaviours with :fire_icon: have +1 :damage_icon: and +1 :dodge_icon:.',
                        'es' => 'Cada vez que este monstruo sufre 4 o más daños de una carta de ataque, después de resolver el ataque, el monstruo se mueve 2 nodos hacia :far_hunter_icon:. Los comportamientos con :fire_icon: tienen +1 :damage_icon: y +1 :dodge_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 2,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :fire_icon: have -1 :damage_icon:.',
                            'es' => 'Los comportamientos con :fire_icon: tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'up-left-right',
                        'defense' => 3,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => "Discard the top card of the monster's behaviour deck.",
                            'es' => 'Descarta la carta superior del mazo de comportamiento del monstruo.',
                        ],
                    ],
                    [
                        'icon' => 'leg',
                        'direction' => 'left-right',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Remove Crush from the behaviour deck. Shuffle discarded behaviour cards into the deck.',
                            'es' => 'Elimina Aplastar del mazo de comportamiento. Baraja las cartas de comportamiento descartadas en el mazo.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 2,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            1 => [
                'name' => 'Anjanath Scale',
                'extra' => [
                    'en' => 'Gain 1 if the :leg_icon: were broken.',
                    'es' => 'Gana 1 si el :leg_icon: estuviera roto.',
                ],
            ],
            2 => [
                'name' => 'Anjanath Pelt',
            ],
            3 => [
                'name' => 'Anjanath Nosebone',
            ],
            4 => [
                'name' => 'Anjanath Tail',
                'extra' => [
                    'en' => 'Gain 1 if the :tail_icon: were broken.',
                    'es' => 'Gana 1 si el :tail_icon: estuviera roto.',
                ],
            ],
            5 => [
                'name' => 'Anjanath Fang',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
            6 => [
                'name' => 'Monster Keenbone',
            ],
            7 => [
                'name' => 'Flame Sac',
            ],
            8 => [
                'name' => 'Monster Bone Large',
            ],
            9 => [
                'name' => 'Anjanath Pelt',
            ],
            10 => [
                'name' => 'Monster Bone Large',
            ],
            11 => [
                'name' => 'Flame Sac',
            ],
            12 => [
                'name' => 'Inferno Sac',
                'extra' => [
                    'en' => 'Gain 1 if the :back_icon: were broken.',
                    'es' => 'Gana 1 si el :back_icon: estuviera roto.',
                ],
            ],
        ],
    ],
    'Rathalos' => [
        'category' => \App\Enum\MonsterCategory::FLYING_WYVERN,
        'expansion' => \App\Enum\MonsterExpansion::ANCIENT_FOREST,
        'items' => [
            'Rathalos Scale',
            'Rathalos Shell',
            'Rathalos Marrow',
            'Rathalos Webbing',
            'Rathalos Plate',
            'Rathalos Wingtalon',
            'Rathalos Tail',
            'Rathalos Wing',
            'Rathalos Carapace',
            'Rathalos Medulla',
            'Inferno Sac',

            'Monster Bone Large',
        ],
        'resistance' => [
            'fire' => null,
            'water' => null,
            'thunder' => 2,
            'ice' => null,
            'dragon' => 1,

            'paralysis' => 2,
            'poison' => null,
            'sleep' => 2,
            'nitro' => null,
            'stun' => 2,
        ],
        'difficulty' => [
            [
                'difficulty' => \App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 80,
                'ability' => [
                    'name' => [
                        'en' => 'Chaotic Rage',
                        'es' => 'Rabia Caótica',
                    ],
                    'description' => [
                        'en' => "When this monster has 35 health or less, remove the card with :investigation_behaviour_icon: from the behaviour deck. Then randomly add 1 of the 3 Rathalos behaviour cards with :investigation_behaviour_icon: into this monster's behaviour deck. Shuffle discarded behaviour cards into the deck.",
                        'es' => 'Cuando este monstruo tenga 35 de salud o menos, retira la carta con :investigation_behaviour_icon: del mazo de comportamiento. Luego agrega al azar 1 de las 3 cartas de comportamiento de Rathalos con :investigation_behaviour_icon: al mazo de comportamiento de este monstruo. Baraja las cartas de comportamiento descartadas en el mazo.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :fire_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :fire_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Remove Take Off Blast from the behaviour deck. Shuffle discarded behaviour cards into the deck.',
                            'es' => 'Elimina Despegue Explosivo del mazo de comportamiento. Baraja las cartas de comportamiento descartadas en el mazo.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :back_icon: have +1 :card_behaviour_icon: and +1 :hunter_behaviour_icon:.',
                            'es' => 'Los comportamientos con :back_icon: tienen +1 :card_behaviour_icon: y +1 :hunter_behaviour_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => "Discard the top card of the monster's behaviour deck.",
                            'es' => 'Descarta la carta superior del mazo de comportamiento del monstruo.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => \App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 85,
                'ability' => [
                    'name' => [
                        'en' => 'Burning Rage',
                        'es' => 'Rabia Ardiente',
                    ],
                    'description' => [
                        'en' => "When this monster has 50 health or less, randomly add 1 additional Rathalos behaviour cards with :investigation_behaviour_icon: into this monster's behaviour deck. Shuffle discarded behaviour cards into the deck. Behaviours with :fire_icon: gain +1 :damage_icon:.",
                        'es' => 'Cuando este monstruo tenga 50 de salud o menos, agrega al azar 1 carta de comportamiento de Rathalos adicional con :investigation_behaviour_icon: al mazo de comportamiento de este monstruo. Baraja las cartas de comportamiento descartadas en el mazo. Comportamientos con :fire_icon: ganan +1 :damage_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :fire_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :fire_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Remove Take Off Blast from the behaviour deck. Shuffle discarded behaviour cards into the deck.',
                            'es' => 'Elimina Despegue Explosivo del mazo de comportamiento. Baraja las cartas de comportamiento descartadas en el mazo.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :back_icon: have +1 :card_behaviour_icon: and +1 :hunter_behaviour_icon:.',
                            'es' => 'Los comportamientos con :back_icon: tienen +1 :card_behaviour_icon: y +1 :hunter_behaviour_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => "Discard the top card of the monster's behaviour deck.",
                            'es' => 'Descarta la carta superior del mazo de comportamiento del monstruo.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => \App\Enum\MonsterDifficulty::HARD,
                'stars' => 4,
                'health' => 90,
                'ability' => [
                    'name' => [
                        'en' => 'King of the Skies',
                        'es' => 'Rey de los Cielos',
                    ],
                    'description' => [
                        'en' => "When this monster has 55 health or less, add 2 remaining Rathalos behaviour cards with :investigation_behaviour_icon: into this monster's behaviour deck. Shuffle discarded behaviour cards into the deck. Behaviours gain +1 :damage_icon: and +1 :dodge_icon:.",
                        'es' => 'Cuando este monstruo tenga 55 de salud o menos, añade las 2 cartas de comportamiento de Rathalos restantes con :investigation_behaviour_icon: al mazo de comportamiento de este monstruo. Baraja las cartas de comportamiento descartadas en el mazo. Los comportamientos ganan +1 :damage_icon: y +1 :dodge_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :fire_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :fire_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Remove Take Off Blast from the behaviour deck. Shuffle discarded behaviour cards into the deck.',
                            'es' => 'Elimina Despegue Explosivo del mazo de comportamiento. Baraja las cartas de comportamiento descartadas en el mazo.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right',
                        'defense' => 5,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :back_icon: have +1 :card_behaviour_icon: and +1 :hunter_behaviour_icon:.',
                            'es' => 'Los comportamientos con :back_icon: tienen +1 :card_behaviour_icon: y +1 :hunter_behaviour_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 4,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => "Discard the top card of the monster's behaviour deck.",
                            'es' => 'Descarta la carta superior del mazo de comportamiento del monstruo.',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            1 => [
                'name' => 'Rathalos Wingtalon',
            ],
            2 => [
                'name' => 'Monster Bone Large',
            ],
            3 => [
                'name' => 'Rathalos Scale',
            ],
            4 => [
                'name' => 'Rathalos Webbing',
            ],
            5 => [
                'name' => 'Rathalos Tail',
            ],
            6 => [
                'name' => 'Rathalos Marrow',
                'extra' => [
                    'en' => 'Gain 1 if the :back_icon: were broken.',
                    'es' => 'Gana 1 si el :back_icon: estuviera roto.',
                ],
            ],
            7 => [
                'name' => 'Rathalos Plate',
                'extra' => [
                    'en' => 'Gain 1 if the :tail_icon: were broken.',
                    'es' => 'Gana 1 si el :tail_icon: estuviera roto.',
                ],
            ],
            8 => [
                'name' => 'Rathalos Wing',
                'extra' => [
                    'en' => 'Gain 1 if the :wing_icon: were broken.',
                    'es' => 'Gana 1 si el :wing_icon: estuviera roto.',
                ],
            ],
            9 => [
                'name' => 'Rathalos Carapace',
            ],
            10 => [
                'name' => 'Rathalos Shell',
            ],
            11 => [
                'name' => 'Rathalos Medulla',
            ],
            12 => [
                'name' => 'Inferno Sac',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
        ],
    ],
    'Azure Rathalos' => [
        'name' => 'Rathalos Celeste',
        'category' => \App\Enum\MonsterCategory::FLYING_WYVERN,
        'expansion' => \App\Enum\MonsterExpansion::ANCIENT_FOREST,
        'items' => [
            'Azure Rathalos Scale',
            'Azure Rathalos Carapace',
            'Azure Rathalos Marrow',
            'Azure Rathalos Wing',
            'Azure Rathalos Plate',
            'Azure Rathalos Wingtalon',
            'Azure Rathalos Tail',
            'Inferno Sac',

            'Monster Bone Large',
        ],
        'resistance' => [
            'fire' => null,
            'water' => null,
            'thunder' => null,
            'ice' => 2,
            'dragon' => 1,

            'paralysis' => 2,
            'poison' => null,
            'sleep' => 2,
            'nitro' => null,
            'stun' => 2,
        ],
        'difficulty' => [
            [
                'difficulty' => \App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 80,
                'ability' => [
                    'name' => [
                        'en' => 'Fleeting Instinct',
                        'es' => 'Instinto Fugaz',
                    ],
                    'description' => [
                        'en' => 'Each time this monster suffers damage from an attack card, after the attack is resolved the monster moves 1 node away from :near_hunter_icon:.',
                        'es' => 'Cada vez que este monstruo sufre daño de una carta de ataque, después de que se resuelve el ataque, el monstruo se aleja 1 nodo de :near_hunter_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 3,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :fire_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :fire_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :wing_icon: gain +1 :hunter_behaviour_icon:.',
                            'es' => 'Los comportamientos con :wing_icon: ganan +1 :hunter_behaviour_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Fleeting Instinct moves the monster 2 nodes rather than 1.',
                            'es' => 'Instinto Fugaz mueve el monstruo 2 nodos en lugar de 1.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => \App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 85,
                'ability' => [
                    'name' => [
                        'en' => 'Strafing Instinct',
                        'es' => 'Instinto de Ametrallamiento',
                    ],
                    'description' => [
                        'en' => 'Each time this monster suffers damage from an attack card, after the attack is resolved the monster moves 1 node away from :near_hunter_icon:. Behaviours with :fire_icon: gain +1 :damage_icon:.',
                        'es' => 'Cada vez que este monstruo sufre daño de una carta de ataque, después de que se resuelve el ataque, el monstruo se aleja 1 nodo de :near_hunter_icon:. Comportamientos con :fire_icon: ganan +1 :damage_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :fire_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :fire_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :wing_icon: gain +1 :hunter_behaviour_icon:.',
                            'es' => 'Los comportamientos con :wing_icon: ganan +1 :hunter_behaviour_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Strafing Instinct moves the monster 2 nodes rather than 1.',
                            'es' => 'Instinto de Ametrallamiento mueve el monstruo 2 nodos en lugar de 1.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => \App\Enum\MonsterDifficulty::HARD,
                'stars' => 4,
                'health' => 90,
                'ability' => [
                    'name' => [
                        'en' => 'Skyfire Instinct',
                        'es' => 'Instinto de Fuego Celestial',
                    ],
                    'description' => [
                        'en' => 'Each time this monster suffers damage from an attack card, after the attack is resolved the monster moves 1 node away from :near_hunter_icon:. Behaviours gain +1 :damage_icon:.',
                        'es' => 'Cada vez que este monstruo sufre daño de una carta de ataque, después de que se resuelve el ataque, el monstruo se aleja 1 nodo de :near_hunter_icon:. Comportamientos ganan +1 :damage_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 4,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :fire_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :fire_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :wing_icon: gain +1 :hunter_behaviour_icon:.',
                            'es' => 'Los comportamientos con :wing_icon: ganan +1 :hunter_behaviour_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right',
                        'defense' => 5,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Skyfire Instinct moves the monster 2 nodes rather than 1.',
                            'es' => 'Instinto de Fuego Celestial mueve el monstruo 2 nodos en lugar de 1.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            1 => [
                'name' => 'Azure Rathalos Wingtalon',
                'extra' => [
                    'en' => 'Gain 1 if the :wing_icon: were broken.',
                    'es' => 'Gana 1 si el :wing_icon: estuviera roto.',
                ],
            ],
            2 => [
                'name' => 'Monster Bone Large',
            ],
            3 => [
                'name' => 'Azure Rathalos Scale',
            ],
            4 => [
                'name' => 'Azure Rathalos Wing',
            ],
            5 => [
                'name' => 'Azure Rathalos Plate',
            ],
            6 => [
                'name' => 'Azure Rathalos Marrow',
                'extra' => [
                    'en' => 'Gain 1 if the :back_icon: were broken.',
                    'es' => 'Gana 1 si el :back_icon: estuviera roto.',
                ],
            ],
            7 => [
                'name' => 'Azure Rathalos Tail',
                'extra' => [
                    'en' => 'Gain 1 if the :tail_icon: were broken.',
                    'es' => 'Gana 1 si el :tail_icon: estuviera roto.',
                ],
            ],
            8 => [
                'name' => 'Azure Rathalos Carapace',
            ],
            9 => [
                'name' => 'Azure Rathalos Wingtalon',
            ],
            10 => [
                'name' => 'Azure Rathalos Carapace',
            ],
            11 => [
                'name' => 'Azure Rathalos Tail',
            ],
            12 => [
                'name' => 'Inferno Sac',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
        ],
    ],

    'Barroth' => [
        'category' => \App\Enum\MonsterCategory::BRUTE_WYVERN,
        'expansion' => \App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
        'items' => [
            'Barroth Ridge',
            'Barroth Tail',
            'Barroth Claw',
            'Barroth Carapace',
            'Barroth Shell',
        ],
    ],
    'Pukei-Pukei' => [
        'category' => \App\Enum\MonsterCategory::BIRD_WYVERN,
        'expansion' => \App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
        'items' => [
            'Pukei-Pukei Carapace',
            'Pukei-Pukei Tail',
            'Pukei-Pukei Wing',
            'Pukei-Pukei Scale',
            'Pukei-Pukei Sac',
            'Pukei-Pukei Quill',
            'Poison Sac',
            'Toxic Sac',
        ],
    ],
    'Jyuratodus' => [
        'category' => \App\Enum\MonsterCategory::PISCINE_WYVERN,
        'expansion' => \App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
        'items' => [
            'Jyuratodus Scale',
            'Jyuratodus Carapace',
            'Jyuratodus Fin',
            'Jyuratodus Fang',
            'Jyuratodus Shell',
            'Jyuratodus Shell',
            'Aqua Sac',
            'Torrent Sac',
        ],
    ],
    'Diablos' => [
        'category' => \App\Enum\MonsterCategory::FLYING_WYVERN,
        'expansion' => \App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
        'items' => [
            'Diablos Ridge',
            'Diablos Fang',
            'Diablos Carapace',
            'Diablos Shell',
            'Majestic Horn',
            'Twisted Horn',
            'Blos Medulla',
        ],
    ],
    'Black Diablos' => [
        'name' => 'Diablos Negra',
        'category' => \App\Enum\MonsterCategory::FLYING_WYVERN,
        'expansion' => \App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
        'items' => [
            'Black Diablos Ridge',
            'Black Diablos Carapace',
            'Black Spiral Horn',
        ],
    ],

    'Kulu-Ya-Ku' => [
        'category' => \App\Enum\MonsterCategory::BIRD_WYVERN,
        'expansion' => \App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
        'items' => [
            'Kulu-Ya-Ku Scale',
            'Kulu-Ya-Ku Hide',
            'Kulu-Ya-Ku Plume',
            'Kulu-Ya-Ku Beak',
        ],
    ],

    'Teostra' => [
        'category' => \App\Enum\MonsterCategory::ELDER_DRAGON,
        'expansion' => \App\Enum\MonsterExpansion::TEOSTRA_EXPANSION,
        'items' => [
            'Fire Dragon Scale',
            'Teostra Claw',
            'Teostra Mane',
            'Teostra Carapace',
            'Teostra Powder',
            'Teostra Horn',
            'Teostra Tail',
            'Teostra Webbing',
            'Teostra Gem',

            'Novacrystal',
            'Firecell Stone',
        ],
        'resistance' => [
            'fire' => null,
            'water' => 1,
            'thunder' => null,
            'ice' => 1,
            'dragon' => null,

            'paralysis' => null,
            'poison' => 2,
            'sleep' => null,
            'nitro' => null,
            'stun' => 2,
        ],
        'difficulty' => [
            [
                'difficulty' => \App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 85,
                'ability' => [
                    'name' => [
                        'en' => 'Fiery Presence',
                        'es' => 'Presencia Ardiente',
                    ],
                    'description' => [
                        'en' => 'When a hunter ends their turns in a node adjacent to Teostra, the hunter suffers :blast_icon:. If all 12 blackscale dust tokens are on the game board when Teostra begins its turn, resolve the Supernova :supernova_icon: behaviour card instead of drawing a behaviour card. After resolving this behaviour card remove all of the blackscale dust tokens from the board.',
                        'es' => 'Cuando un cazador termina su turno en un nodo adyacente a Teostra, el cazador sufre :blast_icon:. Si las 12 fichas de polvo de escamas negra están en el tablero de juego cuando Teostra comienza su turno, resuelve la carta de comportamiento Supernova :supernova_icon: en lugar de robar una carta de comportamiento. Después de resolver esta carta de comportamiento, retira todas las fichas de polvo de escama negra del tablero.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 3,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Remove up to 6 blackscale dust tokens from the game board.',
                            'es' => 'Retira hasta 6 fichas de polvo de escamas negras del tablero de juego.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 4,
                        'broken' => 8,
                        'ability-broken' => [
                            'en' => 'This body part has -1 :defense_icon:',
                            'es' => 'Esta parte del cuerpo tiene -1 :defense_icon:',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 8,
                        'ability-broken' => [
                            'en' => 'Behaviours with :wing_icon: have -1 :damage_icon:',
                            'es' => 'Los comportamientos con :wing_icon: tienen -1 :damage_icon:',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => \App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 95,
                'ability' => [
                    'name' => [
                        'en' => 'Fiery Presence',
                        'es' => 'Presencia Ardiente',
                    ],
                    'description' => [
                        'en' => 'When a hunter ends their turns in a node adjacent to Teostra, the hunter suffers :blast_icon:. If all 12 blackscale dust tokens are on the game board when Teostra begins its turn, resolve the Supernova :supernova_icon: behaviour card instead of drawing a behaviour card. After resolving this behaviour card remove all of the blackscale dust tokens from the board.',
                        'es' => 'Cuando un cazador termina su turno en un nodo adyacente a Teostra, el cazador sufre :blast_icon:. Si las 12 fichas de polvo de escamas negra están en el tablero de juego cuando Teostra comienza su turno, resuelve la carta de comportamiento Supernova :supernova_icon: en lugar de robar una carta de comportamiento. Después de resolver esta carta de comportamiento, retira todas las fichas de polvo de escama negra del tablero.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Remove up to 5 blackscale dust tokens from the game board.',
                            'es' => 'Retira hasta 5 fichas de polvo de escamas negras del tablero de juego.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 5,
                        'broken' => 8,
                        'ability-broken' => [
                            'en' => 'This body part has -1 :defense_icon:',
                            'es' => 'Esta parte del cuerpo tiene -1 :defense_icon:',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 8,
                        'ability-broken' => [
                            'en' => 'Remove Claw Swipe from the behaviour deck. Shuffle discarded behaviour cards into the deck.',
                            'es' => 'Elimina Claw Swipe de la plataforma de comportamiento. Mezcla las cartas de comportamiento descartadas en el mazo.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => \App\Enum\MonsterDifficulty::HARD,
                'stars' => 5,
                'health' => 110,
                'ability' => [
                    'name' => [
                        'en' => 'Volcanic Presence',
                        'es' => 'Presencia Volcanica',
                    ],
                    'description' => [
                        'en' => 'Behaviours gain +1 :damage_icon:. When a hunter ends their turns in a node adjacent to Teostra, the hunter suffers :blast_icon:. If all 12 blackscale dust tokens are on the game board when Teostra begins its turn, resolve the Supernova :supernova_icon: behaviour card instead of drawing a behaviour card. After resolving this behaviour card remove all of the blackscale dust tokens from the board.',
                        'es' => 'Los comportamientos ganan +1 :damage_icon:. Cuando un cazador termina su turno en un nodo adyacente a Teostra, el cazador sufre :blast_icon:. Si las 12 fichas de polvo de escamas negra están en el tablero de juego cuando Teostra comienza su turno, resuelve la carta de comportamiento Supernova :supernova_icon: en lugar de robar una carta de comportamiento. Después de resolver esta carta de comportamiento, retira todas las fichas de polvo de escama negra del tablero.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Remove up to 4 blackscale dust tokens from the game board.',
                            'es' => 'Retira hasta 4 fichas de polvo de escamas negras del tablero de juego.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 5,
                        'broken' => 8,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :range_icon:',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :range_icon:',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 5,
                        'broken' => 8,
                        'ability-broken' => [
                            'en' => 'Remove Claw Swipe from the behaviour deck. Shuffle discarded behaviour cards into the deck.',
                            'es' => 'Elimina Claw Swipe de la plataforma de comportamiento. Mezcla las cartas de comportamiento descartadas en el mazo.',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            1 => [
                'name' => 'Fire Dragon Scale',
            ],
            2 => [
                'name' => 'Teostra Horn',
            ],
            3 => [
                'name' => 'Teostra Webbing',
            ],
            4 => [
                'name' => 'Teostra Gem',
            ],
            5 => [
                'name' => 'Teostra Powder',
            ],
            6 => [
                'name' => 'Teostra Carapace',
            ],
            7 => [
                'name' => 'Fire Dragon Scale',
            ],
            8 => [
                'name' => 'Novacrystal',
            ],
            9 => [
                'name' => 'Firecell Stone',
            ],
            10 => [
                'name' => 'Teostra Claw',
                'extra' => [
                    'en' => 'Gain 1 if the :wing_icon: were broken.',
                    'es' => 'Gana 1 si el :wing_icon: estuviera roto.',
                ],
            ],
            11 => [
                'name' => 'Teostra Mane',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
            12 => [
                'name' => 'Teostra Tail',
                'extra' => [
                    'en' => 'Gain 1 if the :tail_icon: were broken.',
                    'es' => 'Gana 1 si el :tail_icon: estuviera roto.',
                ],
            ],
        ],
    ],
    'Nergigante' => [
        'category' => \App\Enum\MonsterCategory::ELDER_DRAGON,
        'expansion' => \App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
        'items' => [
            'Nergigante Horn',
            'Nergigante Carapace',
            'Nergigante Talon',
            'Nergigante Tail',
            'Nergigante Gem',
            'Nergigante Regrowth Plate',
            'Immortal Dragonscale',
        ],
    ],
    'Kushala Daora' => [
        'category' => \App\Enum\MonsterCategory::ELDER_DRAGON,
        'expansion' => \App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
        'items' => [
            'Daora Dragon Scale',
            'Daora Carapace',
            'Daora Claw',
            'Daora Webbing',
            'Daora Tail',
            'Daora Horn',
            'Daora Gem',
        ],
    ],
];
