<?php

return [
    'Great Jagras' => [
        'name' => 'Gran Jagras',
        'category' => App\Enum\MonsterCategory::FANGED_WYVERN,
        'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
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
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
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
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
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
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
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
        'category' => App\Enum\MonsterCategory::FANGED_WYVERN,
        'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
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
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
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
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
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
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
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
        'category' => App\Enum\MonsterCategory::BRUTE_WYVERN,
        'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
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
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
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
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
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
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
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
        'category' => App\Enum\MonsterCategory::FLYING_WYVERN,
        'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
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
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
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
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
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
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
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
        'category' => App\Enum\MonsterCategory::FLYING_WYVERN,
        'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
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
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
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
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
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
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
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
        'category' => App\Enum\MonsterCategory::BRUTE_WYVERN,
        'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
        'items' => [
            'Barroth Ridge',
            'Barroth Tail',
            'Barroth Claw',
            'Barroth Carapace',
            'Barroth Shell',
        ],
        'resistance' => [
            'fire' => null,
            'water' => 2,
            'thunder' => null,
            'ice' => 2,
            'dragon' => null,

            'paralysis' => 1,
            'poison' => 1,
            'sleep' => 2,
            'nitro' => 1,
            'stun' => null,
        ],
        'difficulty' => [
            [
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 50,
                'ability' => [
                    'name' => [
                        'en' => 'Mud Coating',
                        'es' => 'Recubrimiento de Lodo',
                    ],
                    'description' => [
                        'en' => 'The first time Barroth moves onto a pond node, remove 1 :break_icon: from each body part that isn\'t broken.',
                        'es' => 'La primera vez que Barroth se mueva a un nodo de estanque, retira 1 :break_icon: de cada parte del cuerpo que no esté rota.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 1,
                        'broken' => 3,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :movement_icon:.',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :movement_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right',
                        'defense' => 0,
                        'broken' => 3,
                        'ability-broken' => [
                            'en' => 'Behaviours with :water_icon: have -1 :dodge_icon:.',
                            'es' => 'Los comportamientos con :water_icon: tienen -1 :dodge_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 0,
                        'broken' => 2,
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 0,
                        'broken' => 2,
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 60,
                'ability' => [
                    'name' => [
                        'en' => 'Mud Cladding',
                        'es' => 'Revestimiento de Lodo',
                    ],
                    'description' => [
                        'en' => 'Each time Barroth moves onto a pond node, remove 1 :break_icon: from each body part that isn\'t broken.',
                        'es' => 'Cada vez que Barroth se mueva a un nodo de estanque, retira 1 :break_icon: de cada parte del cuerpo que no esté rota.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 2,
                        'broken' => 4,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :movement_icon:.',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :movement_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right',
                        'defense' => 1,
                        'broken' => 4,
                        'ability-broken' => [
                            'en' => 'Behaviours with :water_icon: have -1 :dodge_icon:.',
                            'es' => 'Los comportamientos con :water_icon: tienen -1 :dodge_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 0,
                        'broken' => 3,
                        'ability-broken' => [
                            'en' => 'Discard the top card of the monster\'s behaviour deck.',
                            'es' => 'Descarta la carta superior del mazo de comportamientos del monstruo.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 0,
                        'broken' => 3,
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
                'stars' => 3,
                'health' => 65,
                'ability' => [
                    'name' => [
                        'en' => 'Mud Armour',
                        'es' => 'Armadura de Lodo',
                    ],
                    'description' => [
                        'en' => 'Each time Barroth moves onto a pond node, remove 1 :break_icon: from each body part that isn\'t broken. Behaviours gain +1 :damage_icon:.',
                        'es' => 'Cada vez que Barroth se mueva a un nodo de estanque, retira 1 :break_icon: de cada parte del cuerpo que no esté rota. Los comportamientos ganan +1 :damage_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 3,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :movement_icon:.',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :movement_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right',
                        'defense' => 2,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :water_icon: have -1 :dodge_icon:.',
                            'es' => 'Los comportamientos con :water_icon: tienen -1 :dodge_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 1,
                        'broken' => 4,
                        'ability-broken' => [
                            'en' => 'Discard the top card of the monster\'s behaviour deck.',
                            'es' => 'Descarta la carta superior del mazo de comportamientos del monstruo.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 1,
                        'broken' => 4,
                        'ability-broken' => [
                            'en' => 'The monster no longer removes break tokens when it move onto a pond node',
                            'es' => 'El monstruo ya no retira fichas de rotura cuando se mueve a un nodo de estanque',
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
                'name' => 'Barroth Claw',
            ],
            3 => [
                'name' => 'Barroth Ridge',
            ],
            4 => [
                'name' => 'Barroth Shell',
            ],
            5 => [
                'name' => 'Barroth Carapace',
            ],
            6 => [
                'name' => 'Barroth Claw',
            ],
            7 => [
                'name' => 'Monster Bone Small',
            ],
            8 => [
                'name' => 'Barroth Claw',
            ],
            9 => [
                'name' => 'Barroth Carapace',
                'extra' => [
                    'en' => 'Gain 1 if the :back_icon: were broken.',
                    'es' => 'Gana 1 si el :back_icon: estuviera roto.',
                ],
            ],
            10 => [
                'name' => 'Barroth Shell',
                'extra' => [
                    'en' => 'Gain 1 if the :tail_icon: were broken.',
                    'es' => 'Gana 1 si el :tail_icon: estuviera roto.',
                ],
            ],
            11 => [
                'name' => 'Barroth Ridge',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
            12 => [
                'name' => 'Barroth Claw',
                'extra' => [
                    'en' => 'Gain 1 if the :claw_icon: were broken.',
                    'es' => 'Gana 1 si el :claw_icon: estuviera roto.',
                ],
            ],
        ],
    ],
    'Pukei-Pukei' => [
        'category' => App\Enum\MonsterCategory::BIRD_WYVERN,
        'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
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
        'resistance' => [
            'fire' => 2,
            'water' => null,
            'thunder' => 1,
            'ice' => 2,
            'dragon' => null,

            'paralysis' => 1,
            'poison' => null,
            'sleep' => 1,
            'nitro' => 2,
            'stun' => 2,
        ],
        'difficulty' => [
            [
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 60,
                'ability' => [
                    'name' => [
                        'en' => 'Toxic Presence',
                        'es' => 'Presencia Tóxica',
                    ],
                    'description' => [
                        'en' => 'When hunters suffer :poison_icon: from Pukei-Pukei they lose 3 health at the end of their turn instead of 2.',
                        'es' => 'Cuando los cazadores sufren :poison_icon: de Pukei-Pukei, pierden 3 de salud al final de su turno en lugar de 2.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 0,
                        'broken' => 3,
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 1,
                        'broken' => 4,
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 1,
                        'broken' => 3,
                        'ability-broken' => [
                            'en' => 'Behaviours with :claw_icon: have +1 :card_behaviour_icon:.',
                            'es' => 'Los comportamientos con :claw_icon: tienen +1 :card_behaviour_icon:.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 65,
                'ability' => [
                    'name' => [
                        'en' => 'Toxic Presence',
                        'es' => 'Presencia Tóxica',
                    ],
                    'description' => [
                        'en' => 'When hunters suffer :poison_icon: from Pukei-Pukei they lose 3 health at the end of their turn instead of 2. Behaviours with :poison_icon: gain +1 :dodge_icon:.',
                        'es' => 'Cuando los cazadores sufren :poison_icon: de Pukei-Pukei, pierden 3 de salud al final de su turno en lugar de 2. Los comportamientos con :poison_icon: ganan +1 :dodge_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 1,
                        'broken' => 4,
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 1,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 2,
                        'broken' => 4,
                        'ability-broken' => [
                            'en' => 'Behaviours with :claw_icon: have +1 :card_behaviour_icon:.',
                            'es' => 'Los comportamientos con :claw_icon: tienen +1 :card_behaviour_icon:.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
                'stars' => 3,
                'health' => 70,
                'ability' => [
                    'name' => [
                        'en' => 'Toxic Predator',
                        'es' => 'Depredador Tóxico',
                    ],
                    'description' => [
                        'en' => 'When hunters suffer :poison_icon: from Pukei-Pukei they lose 3 health at the end of their turn instead of 2. Behaviours with :poison_icon: gain +1 :dodge_icon:.',
                        'es' => 'Cuando los cazadores sufren :poison_icon: de Pukei-Pukei, pierden 3 de salud al final de su turno en lugar de 2. Los comportamientos con :poison_icon: ganan +1 :dodge_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 2,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => ':poison_icon: causes hunters to lose 2 health instead of 3',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :movement_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 2,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 3,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :claw_icon: have +1 :card_behaviour_icon:.',
                            'es' => 'Los comportamientos con :claw_icon: tienen +1 :card_behaviour_icon:.',
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
                'name' => 'Pukei-Pukei Wing',
            ],
            3 => [
                'name' => 'Pukei-Pukei Scale',
            ],
            4 => [
                'name' => 'Pukei-Pukei Quill',
            ],
            5 => [
                'name' => 'Pukei-Pukei Carapace',
            ],
            6 => [
                'name' => 'Poison Sac',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
            7 => [
                'name' => 'Pukei-Pukei Tail',
                'extra' => [
                    'en' => 'Gain 1 if the :tail_icon: were broken.',
                    'es' => 'Gana 1 si el :tail_icon: estuviera roto.',
                ],
            ],
            8 => [
                'name' => 'Toxic Sac',
            ],
            9 => [
                'name' => 'Pukei-Pukei Wing',
                'extra' => [
                    'en' => 'Gain 1 if the :claw_icon: were broken.',
                    'es' => 'Gana 1 si el :claw_icon: estuviera roto.',
                ],
            ],
            10 => [
                'name' => 'Pukei-Pukei Scale',
            ],
            11 => [
                'name' => 'Pukei-Pukei Carapace',
            ],
            12 => [
                'name' => 'Monster Bone Medium',
            ],
        ],
    ],
    'Jyuratodus' => [
        'category' => App\Enum\MonsterCategory::PISCINE_WYVERN,
        'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
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
        'resistance' => [
            'fire' => null,
            'water' => null,
            'thunder' => 2,
            'ice' => 2,
            'dragon' => null,

            'paralysis' => 2,
            'poison' => 2,
            'sleep' => null,
            'nitro' => null,
            'stun' => 2,
        ],
        'difficulty' => [
            [
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 65,
                'ability' => [
                    'name' => [
                        'en' => 'Mire Dweller',
                        'es' => 'Habitante del Fango',
                    ],
                    'description' => [
                        'en' => 'While Jyuratodus is on a pond node, behaviours gain +1 :dodge_icon:.',
                        'es' => 'Mientras Jyuratodus esté en un nodo de estanque, los comportamientos ganan +1 :dodge_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 2,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :dodge_icon:.',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :dodge_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 1,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :damage_icon:.',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left',
                        'defense' => 2,
                        'broken' => 4,
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'right',
                        'defense' => 2,
                        'broken' => 4,
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 70,
                'ability' => [
                    'name' => [
                        'en' => 'Mire Stalker',
                        'es' => 'Acechador del Fango',
                    ],
                    'description' => [
                        'en' => 'While Jyuratodus is on a pond node, behaviours gain +1 :damage_icon: and +1 :dodge_icon:.',
                        'es' => 'Mientras Jyuratodus esté en un nodo de estanque, los comportamientos ganan +1 :damage_icon: y +1 :dodge_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 2,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :dodge_icon:.',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :dodge_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 2,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :damage_icon:.',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left',
                        'defense' => 3,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'This body part has -1 :defense_icon:.',
                            'es' => 'Esta parte del cuerpo tiene -1 :defense_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'right',
                        'defense' => 3,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'This body part has -1 :defense_icon:.',
                            'es' => 'Esta parte del cuerpo tiene -1 :defense_icon:.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
                'stars' => 3,
                'health' => 75,
                'ability' => [
                    'name' => [
                        'en' => 'Mire Beast',
                        'es' => 'Bestia del Fango',
                    ],
                    'description' => [
                        'en' => 'While Jyuratodus is on a pond node, each body part gains +1 :defense_icon: and behaviour gains +1 :damage_icon: and +1 :dodge_icon:.',
                        'es' => 'Mientras Jyuratodus esté en un nodo de estanque, cada parte del cuerpo gana +1 :defense_icon: y los comportamientos ganan +1 :damage_icon: y +1 :dodge_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :dodge_icon:.',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :dodge_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 2,
                        'broken' => 5,
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'This body part has -1 :defense_icon:.',
                            'es' => 'Esta parte del cuerpo tiene -1 :defense_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'right',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'This body part has -1 :defense_icon:.',
                            'es' => 'Esta parte del cuerpo tiene -1 :defense_icon:.',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            1 => [
                'name' => 'Jyuratodus Fin',
                'extra' => [
                    'en' => 'Gain 1 if the left :paw_icon: were broken.',
                    'es' => 'Gana 1 si la :paw_icon: izquierda estuviera rota.',
                ],
            ],
            2 => [
                'name' => 'Aqua Sac',
            ],
            3 => [
                'name' => 'Jyuratodus Scale',
            ],
            4 => [
                'name' => 'Jyuratodus Shell',
            ],
            5 => [
                'name' => 'Monster Bone Large',
            ],
            6 => [
                'name' => 'Jyuratodus Carapace',
            ],
            7 => [
                'name' => 'Jyuratodus Fang',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
            8 => [
                'name' => 'Jyuratodus Carapace',
            ],
            9 => [
                'name' => 'Gajau Scale',
                'extra' => [
                    'en' => 'Gain 1 if the :tail_icon: were broken.',
                    'es' => 'Gana 1 si el :tail_icon: estuviera roto.',
                ],
            ],
            10 => [
                'name' => 'Jyuratodus Shell',
            ],
            11 => [
                'name' => 'Jyuratodus Scale',
            ],
            12 => [
                'name' => 'Jyuratodus Fin',
                'extra' => [
                    'en' => 'Gain 1 if the right :paw_icon: were broken.',
                    'es' => 'Gana 1 si la :paw_icon: derecha estuviera rota.',
                ],
            ],
        ],
    ],
    'Diablos' => [
        'category' => App\Enum\MonsterCategory::FLYING_WYVERN,
        'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
        'items' => [
            'Diablos Ridge',
            'Diablos Fang',
            'Diablos Carapace',
            'Diablos Shell',
            'Majestic Horn',
            'Twisted Horn',
            'Blos Medulla',
        ],
        'resistance' => [
            'fire' => null,
            'water' => 2,
            'thunder' => null,
            'ice' => 1,
            'dragon' => 2,

            'paralysis' => 1,
            'poison' => 2,
            'sleep' => 2,
            'nitro' => 2,
            'stun' => null,
        ],
        'difficulty' => [
            [
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 80,
                'ability' => [
                    'name' => [
                        'en' => 'Boundless Charge',
                        'es' => 'Carga Infinita',
                    ],
                    'description' => [
                        'en' => 'While performing :head_icon: behaviours, When Diablos moves onto the same node as the hunters those hunters may only move to the node in the centre of Diablos\' front arc unless that node isn\'t available.',
                        'es' => 'Mientras realiza comportamientos :head_icon:, cuando Diablos se mueve al mismo nodo que los cazadores, esos cazadores solo pueden moverse al nodo en el centro del arco frontal de Diablos, a menos que ese nodo no esté disponible.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours have -1 :damage_icon:.',
                            'es' => 'Los comportamientos tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 3,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Discard the top card of the monster\'s behaviour deck.',
                            'es' => 'Descarta la carta superior del mazo de comportamientos del monstruo.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left-right',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :dodge_icon:.',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :dodge_icon:.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 85,
                'ability' => [
                    'name' => [
                        'en' => 'Primal Charge',
                        'es' => 'Carga Primordial',
                    ],
                    'description' => [
                        'en' => 'While performing :head_icon: behaviours, When Diablos moves onto the same node as the hunters those hunters may only move to the node in the centre of Diablos\' front arc unless that node isn\'t available. Behaviours with :head_icon: have +1 :damage_icon:.',
                        'es' => 'Mientras realiza comportamientos :head_icon:, cuando Diablos se mueve al mismo nodo que los cazadores, esos cazadores solo pueden moverse al nodo en el centro del arco frontal de Diablos, a menos que ese nodo no esté disponible. Los comportamientos con :head_icon: tienen +1 :damage_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours have -1 :damage_icon:.',
                            'es' => 'Los comportamientos tienen -1 :damage_icon:.',
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
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Discard the top card of the monster\'s behaviour deck.',
                            'es' => 'Descarta la carta superior del mazo de comportamientos del monstruo.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :movement_icon:.',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :movement_icon:.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
                'stars' => 4,
                'health' => 90,
                'ability' => [
                    'name' => [
                        'en' => 'Devastating Charge',
                        'es' => 'Carga Devastadora',
                    ],
                    'description' => [
                        'en' => 'While performing :head_icon: behaviours, When Diablos moves onto the same node as the hunters those hunters may only move to the node in the centre of Diablos\' front arc unless that node isn\'t available. Behaviours with :head_icon: have +2 :damage_icon:.',
                        'es' => 'Mientras realiza comportamientos :head_icon:, cuando Diablos se mueve al mismo nodo que los cazadores, esos cazadores solo pueden moverse al nodo en el centro del arco frontal de Diablos, a menos que ese nodo no esté disponible. Los comportamientos con :head_icon: tienen +2 :damage_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 5,
                        'broken' => 8,
                        'ability-broken' => [
                            'en' => 'Behaviours have -1 :damage_icon:.',
                            'es' => 'Los comportamientos tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 4,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Discard the top card of the monster\'s behaviour deck.',
                            'es' => 'Descarta la carta superior del mazo de comportamientos del monstruo.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :movement_icon:.',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :movement_icon:.',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            1 => [
                'name' => 'Diablos Shell',
            ],
            2 => [
                'name' => 'Diablos Carapace',
            ],
            3 => [
                'name' => 'Twisted Horn',
            ],
            4 => [
                'name' => 'Majestic Horn',
            ],
            5 => [
                'name' => 'Diablos Fang',
            ],
            6 => [
                'name' => 'Diablos Ridge',
                'extra' => [
                    'en' => 'Gain 1 if the :tail_icon: were broken.',
                    'es' => 'Gana 1 si el :tail_icon: estuviera roto.',
                ],
            ],
            7 => [
                'name' => 'Blos Medulla',
            ],
            8 => [
                'name' => 'Diablos Carapace',
                'extra' => [
                    'en' => 'Gain 1 if the :paw_icon: were broken.',
                    'es' => 'Gana 1 si el :paw_icon: estuviera roto.',
                ],
            ],
            9 => [
                'name' => 'Diablos Fang',
            ],
            10 => [
                'name' => 'Majestic Horn',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
            11 => [
                'name' => 'Twisted Horn',
            ],
            12 => [
                'name' => 'Diablos Shell',
                'extra' => [
                    'en' => 'Gain 1 if the :claw_icon: were broken.',
                    'es' => 'Gana 1 si el :claw_icon: estuviera roto.',
                ],
            ],
        ],
    ],
    'Black Diablos' => [
        'name' => 'Diablos Negra',
        'category' => App\Enum\MonsterCategory::FLYING_WYVERN,
        'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
        'items' => [
            'Black Diablos Ridge',
            'Black Diablos Carapace',
            'Black Spiral Horn',
        ],
        'resistance' => [
            'fire' => null,
            'water' => 2,
            'thunder' => null,
            'ice' => 1,
            'dragon' => null,

            'paralysis' => 1,
            'poison' => 2,
            'sleep' => 2,
            'nitro' => 2,
            'stun' => null,
        ],
        'difficulty' => [
            [
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 80,
                'ability' => [
                    'name' => [
                        'en' => 'Delving Wyvern',
                        'es' => 'Wyvern Explorador',
                    ],
                    'description' => [
                        'en' => 'When you determine Black Diablos\' target for a :claw_icon: behaviour remove Black Diablos from the board. Place Black Diablos on the same node as its target without changing its facing. Move any hunter on that node as if BlackDiablos had moved onto that node. Then resolve the behaviour as normal.',
                        'es' => 'Cuando determines el objetivo de Diablos Negra para un comportamiento :claw_icon:, retira a Diablos Negra del tablero. Coloca a Diablos Negra en el mismo nodo que su objetivo sin cambiar su orientación. Mueve a cualquier cazador en ese nodo como si Black Diablos se hubiera movido a ese nodo. Luego resuelve el comportamiento como de costumbre.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours have -1 :damage_icon:.',
                            'es' => 'Los comportamientos tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 3,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Remove 1 :claw_icon: card of your choice from the behaviour deck then shuffle the deck.',
                            'es' => 'Retira 1 carta :claw_icon: de tu elección del mazo de comportamientos y luego baraja el mazo.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left-right',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'This body part has -1 :defense_icon:.',
                            'es' => 'Esta parte del cuerpo tiene -1 :defense_icon:.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 85,
                'ability' => [
                    'name' => [
                        'en' => 'Tunneling Wyvern',
                        'es' => 'Wyvern Tuneladora',
                    ],
                    'description' => [
                        'en' => 'When you determine Black Diablos\' target for a :claw_icon: behaviour remove Black Diablos from the board. Place Black Diablos on the same node as its target without changing its facing. Move any hunter on that node as if BlackDiablos had moved onto that node. Then resolve the behaviour as normal. Behaviours with :claw_icon: have +1 :damage_icon:.',
                        'es' => 'Cuando determines el objetivo de Diablos Negra para un comportamiento :claw_icon:, retira a Diablos Negra del tablero. Coloca a Diablos Negra en el mismo nodo que su objetivo sin cambiar su orientación. Mueve a cualquier cazador en ese nodo como si Black Diablos se hubiera movido a ese nodo. Luego resuelve el comportamiento como de costumbre. Los comportamientos con :claw_icon: tienen +1 :damage_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours have -1 :damage_icon:.',
                            'es' => 'Los comportamientos tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 3,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Remove 1 :claw_icon: card of your choice from the behaviour deck then shuffle the deck.',
                            'es' => 'Retira 1 carta :claw_icon: de tu elección del mazo de comportamientos y luego baraja el mazo.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'This body part has -1 :defense_icon:.',
                            'es' => 'Esta parte del cuerpo tiene -1 :defense_icon:.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
                'stars' => 4,
                'health' => 90,
                'ability' => [
                    'name' => [
                        'en' => 'Burrowing Wyvern',
                        'es' => 'Wyvern Excavadora',
                    ],
                    'description' => [
                        'en' => 'When you determine Black Diablos\' target for a :claw_icon: behaviour remove Black Diablos from the board. Place Black Diablos on the same node as its target without changing its facing. Move any hunter on that node as if BlackDiablos had moved onto that node. Then resolve the behaviour as normal. Behaviours with :claw_icon: have +2 :damage_icon:.',
                        'es' => 'Cuando determines el objetivo de Diablos Negra para un comportamiento :claw_icon:, retira a Diablos Negra del tablero. Coloca a Diablos Negra en el mismo nodo que su objetivo sin cambiar su orientación. Mueve a cualquier cazador en ese nodo como si Black Diablos se hubiera movido a ese nodo. Luego resuelve el comportamiento como de costumbre. Los comportamientos con :claw_icon: tienen +2 :damage_icon:.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 5,
                        'broken' => 8,
                        'ability-broken' => [
                            'en' => 'Behaviours have -1 :damage_icon:.',
                            'es' => 'Los comportamientos tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 4,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :range_icon:.',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :range_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Remove 1 :claw_icon: card of your choice from the behaviour deck then shuffle the deck.',
                            'es' => 'Retira 1 carta :claw_icon: de tu elección del mazo de comportamientos y luego baraja el mazo.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'This body part has -1 :defense_icon:.',
                            'es' => 'Esta parte del cuerpo tiene -1 :defense_icon:.',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            1 => [
                'name' => 'Novacrystal',
            ],
            2 => [
                'name' => 'Black Diablos Carapace',
            ],
            3 => [
                'name' => 'Black Spiral Horn',
            ],
            4 => [
                'name' => 'Majestic Horn',
            ],
            5 => [
                'name' => 'Black Diablos Carapace',
            ],
            6 => [
                'name' => 'Black Diablos Ridge',
                'extra' => [
                    'en' => 'Gain 1 if the :tail_icon: were broken.',
                    'es' => 'Gana 1 si el :tail_icon: estuviera roto.',
                ],
            ],
            7 => [
                'name' => 'Blos Medulla',
            ],
            8 => [
                'name' => 'Wyvern Gem',
            ],
            9 => [
                'name' => 'Novacrystal',
            ],
            10 => [
                'name' => 'Black Diablos Carapace',
                'extra' => [
                    'en' => 'Gain 1 if the :paw_icon: were broken.',
                    'es' => 'Gana 1 si el :paw_icon: estuviera roto.',
                ],
            ],
            11 => [
                'name' => 'Majestic Horn',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
            12 => [
                'name' => 'Twisted Horn',
                'extra' => [
                    'en' => 'Gain 1 if the :claw_icon: were broken.',
                    'es' => 'Gana 1 si el :claw_icon: estuviera roto.',
                ],
            ],
        ],
    ],

    'Kulu-Ya-Ku' => [
        'category' => App\Enum\MonsterCategory::BIRD_WYVERN,
        'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
        'items' => [
            'Kulu-Ya-Ku Scale',
            'Kulu-Ya-Ku Hide',
            'Kulu-Ya-Ku Plume',
            'Kulu-Ya-Ku Beak',
        ],
        'resistance' => [
            'fire' => 2,
            'water' => 1,
            'thunder' => 2,
            'ice' => null,
            'dragon' => null,

            'paralysis' => 2,
            'poison' => null,
            'sleep' => null,
            'nitro' => 2,
            'stun' => 2,
        ],
        'difficulty' => [
            [
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 60,
                'ability' => [
                    'name' => [
                        'en' => 'Crude Tools',
                        'es' => 'Herramientas Rústicas',
                    ],
                    'description' => [
                        'en' => 'After resolving a :claw_icon: behaviour card, Kulu-Ya-Ku gains +2 :defense_icon: on it :head_icon: and :claw_icon: body parts until its next turn.',
                        'es' => 'Después de resolver una tarjeta de comportamiento :claw_icon:, Kulu-Ya-Ku gana +2 :defense_icon: en sus partes corporales :head_icon: y :claw_icon: hasta su próximo turno.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 0,
                        'broken' => 3,
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 1,
                        'broken' => 3,
                        'ability-broken' => [
                            'en' => 'Behaviours with :claw_icon: have -1 :damage_icon:.',
                            'es' => 'Los comportamientos con :claw_icon: tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'down',
                        'defense' => 1,
                        'broken' => 4,
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 65,
                'ability' => [
                    'name' => [
                        'en' => 'Dangerous Tools',
                        'es' => 'Herramientas Peligrosas',
                    ],
                    'description' => [
                        'en' => 'Behaviours with :claw_icon: gain +1 :damage_icon:. After resolving a :claw_icon: behaviour card, Kulu-Ya-Ku gains +2 :defense_icon: on it :head_icon: and :claw_icon: body parts until its next turn.',
                        'es' => 'Los comportamientos con :claw_icon: tienen +1 :damage_icon:. Después de resolver una tarjeta de comportamiento :claw_icon:, Kulu-Ya-Ku gana +2 :defense_icon: en sus partes corporales :head_icon: y :claw_icon: hasta su próximo turno.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 1,
                        'broken' => 4,
                        'ability-broken' => [
                            'en' => 'Behaviours have -1 :dodge_icon:.',
                            'es' => 'Los comportamientos tienen -1 :dodge_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 1,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :claw_icon: have -1 :damage_icon:.',
                            'es' => 'Los comportamientos con :claw_icon: tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'down',
                        'defense' => 2,
                        'broken' => 4,
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
                'stars' => 3,
                'health' => 70,
                'ability' => [
                    'name' => [
                        'en' => 'Deadly Tools',
                        'es' => 'Herramientas Mortales',
                    ],
                    'description' => [
                        'en' => 'Behaviours with :claw_icon: gain +1 :damage_icon: and +1 :dodge_icon:. After resolving a :claw_icon: behaviour card, Kulu-Ya-Ku gains +2 :defense_icon: on it :head_icon: and :claw_icon: body parts until its next turn.',
                        'es' => 'Los comportamientos con :claw_icon: tienen +1 :damage_icon: y +1 :dodge_icon:. Después de resolver una tarjeta de comportamiento :claw_icon:, Kulu-Ya-Ku gana +2 :defense_icon: en sus partes corporales :head_icon: y :claw_icon: hasta su próximo turno.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 1,
                        'broken' => 4,
                        'ability-broken' => [
                            'en' => 'Behaviours have -1 :dodge_icon:.',
                            'es' => 'Los comportamientos tienen -1 :dodge_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 2,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Behaviours with :claw_icon: have -1 :damage_icon:.',
                            'es' => 'Los comportamientos con :claw_icon: tienen -1 :damage_icon:.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'down',
                        'defense' => 2,
                        'broken' => 5,
                        'ability-broken' => [
                            'en' => 'Remove the top card from the behaviour deck. Shuffle discarded behaviour cards back into the deck.',
                            'es' => 'Retira la carta superior del mazo de comportamientos. Baraja las cartas de comportamiento descartadas de nuevo en el mazo.',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            1 => [
                'name' => 'Boulder Bone',
            ],
            2 => [
                'name' => 'Kulu-Ya-Ku Plume',
            ],
            3 => [
                'name' => 'Kulu-Ya-Ku Beak',
            ],
            4 => [
                'name' => 'Earth Crystal',
            ],
            5 => [
                'name' => 'Kulu-Ya-Ku Scale',
            ],
            6 => [
                'name' => 'Kulu-Ya-Ku Hide',
            ],
            7 => [
                'name' => 'Kulu-Ya-Ku Scale',
                'extra' => [
                    'en' => 'Gain 1 if the :paw_icon: were broken.',
                    'es' => 'Gana 1 si el :paw_icon: estuviera roto.',
                ],
            ],
            8 => [
                'name' => 'Bird Wyvern Gem',
            ],
            9 => [
                'name' => 'Earth Crystal',
            ],
            10 => [
                'name' => 'Boulder Bone',
            ],
            11 => [
                'name' => 'Kulu-Ya-Ku Hide',
                'extra' => [
                    'en' => 'Gain 1 if the :claw_icon: were broken.',
                    'es' => 'Gana 1 si el :claw_icon: estuviera roto.',
                ],
            ],
            12 => [
                'name' => 'Kulu-Ya-Ku Plume',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
        ],
    ],

    'Teostra' => [
        'category' => App\Enum\MonsterCategory::ELDER_DRAGON,
        'expansion' => App\Enum\MonsterExpansion::TEOSTRA_EXPANSION,
        'setup' => [
            'en' => 'Before creating the monster behaviour deck in the gathering phase, remove the Supernova :supernova_icon: behaviour card and place it face up next to Teostra\'s physiology card.<br>Gather the 12 blackscale dust tokens and place them to the side of the playing area.',
            'es' => 'Antes de crear el mazo de comportamiento de monstruos en la fase de recolección, retira la carta de comportamiento Supernova :supernova_icon: y colócala boca arriba junto a la carta de fisiología de Teostra.<br>Reúne las 12 fichas de polvos de escamas negras y colócalos a un lado del área de juego.',
        ],
        'mechanics' => [
            [
                'title' => [
                    'en' => 'Blackscale Dust Tokens',
                    'es' => 'Fichas de Polvo de Escamas Negras',
                ],
                'description' => [
                    [
                        'title' => [
                            'en' => 'Placing Blackscale Dust Tokens',
                            'es' => 'Colocación de Fichas de Polvo de Escamas Negras',
                        ],
                        'description' => [
                            'en' => 'When Teostra moves onto a node, place 1 blackscale dust token onto that node. Blackscale dust tokens can\'t be placed on a node already containing a blackscale dust token. If all 12 blackscale dust tokens have been placed do not place any additional blackscale dust tokens.',
                            'es' => 'Cuando Teostra se mueve a un nodo, coloca 1 ficha de polvo de escamas negras en ese nodo. Las fichas de polvo de escamas negras no se pueden colocar en un nodo que ya contenga una ficha de polvo de escamas negras. Si se han colocado las 12 fichas de polvo de escamas negras, no coloque ninguna ficha adicional.',
                        ],
                    ],
                    [
                        'title' => [
                            'en' => 'Blackscale Dust Effect',
                            'es' => 'Efecto del Polvo de Escamas Negras',
                        ],
                        'description' => [
                            'en' => 'When Teostra performs a :fire_icon: behaviour card, the behaviour gains +2 :damage_icon: against hunters positioned on a node with a blackscale dust token.<br>Blackscale dust tokens do not affect the movement of Teostra or the hunters.',
                            'es' => 'Cuando Teostra realiza una carta de comportamiento :fire_icon:, el comportamiento obtiene +2 :damage_icon: contra los cazadores posicionados en un nodo con una ficha de polvo de escamas negras.<br>Las fichas de polvo de escamas negras no afectan el movimiento de Teostra ni de los cazadores.',
                        ],
                    ],
                    [
                        'title' => [
                            'en' => 'Supernova',
                            'es' => 'Supernova',
                        ],
                        'description' => [
                            'en' => 'If all 12 blackscale dust tokens are on the game board when Teostra begins its turn, resolve the Supernova :supernova_icon: behaviour card instead of drawing a behaviour card.<br>After resolving the Supernova behaviour card remove all blackscale dust tokens from the board. Don\'t discard the Supernova. Instead, place Supernova face up next to Teostra\'s physiology card. Supernova may need to be resolved multiple times during the hunt.',
                            'es' => 'Si las 12 fichas de polvo de escamas negras están en el tablero de juego cuando Teostra comienza En su turno, resuelve la carta de comportamiento Supernova :supernova_icon: en lugar de robar una carta de comportamiento.<br>Después de resolver la carta de comportamiento Supernova, retira todas las fichas de polvo de escamas negras del tablero. No descartes la Supernova. En su lugar, coloca Supernova boca arriba junto a la carta de fisiología de Teostra. Es posible que sea necesario resolver Supernova varias veces durante la caza.',
                        ],
                    ],
                ],
            ],
            [
                'title' => [
                    'en' => 'Wreathed in Flames',
                    'es' => 'Envuelto en Llamas',
                ],
                'description' => [
                    [
                        'title' => [
                            'en' => '',
                            'es' => '',
                        ],
                        'description' => [
                            'en' => 'When a hunter ends their turn on a node adjacent to Teostra, the hunter suffers :nitro_icon:.',
                            'es' => 'Cuando un cazador termina su turno en un nodo adyacente a Teostra, el cazador sufre :nitro_icon:.',
                        ],
                    ],
                ],
            ],
        ],
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
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
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
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
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
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
                'stars' => 5,
                'health' => 110,
                'ability' => [
                    'name' => [
                        'en' => 'Volcanic Presence',
                        'es' => 'Presencia Volcánica',
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
        'category' => App\Enum\MonsterCategory::ELDER_DRAGON,
        'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
        'setup' => [
            'en' => 'Before creating the monster behaviour deck in the gathering phase, remove the Nergigante Dive :nergigante_icon: behaviour card and place it face up next to Nergigante\'s physiology card.<br>Gather the 12 spike tokens and place them to the side of the playing area.',
            'es' => 'Antes de crear el mazo de comportamiento del monstruo en la fase de recolección, retira la carta de comportamiento Nergigante Dive :nergigante_icon: y colócala boca arriba junto a la carta de fisiología de Nergigante.<br>Reúne las 12 fichas de pico y colócalas al lado del área de juego.',
        ],
        'mechanics' => [
            [
                'title' => [
                    'en' => 'Spike Tokens',
                    'es' => 'Fichas de Espiga',
                ],
                'description' => [
                    [
                        'title' => [
                            'en' => 'Placing Spike Tokens',
                            'es' => 'Colocando Fichas de Espiga',
                        ],
                        'description' => [
                            'en' => 'Each body part on Nergigante\'s physiology card has a spike token stash, where spike tokens assigned to that part should be placed. Each stash can hold a maximum of 3 spike tokens; don\'t place any spike tokens that would exceed this amount.<br>When a body part has no spike tokens on it, the first spike token to be placed in its spike token stash is a black spike token. Any additional spike tokens placed on that body part are white spike tokens.<br>After resolving a behaviour card with the :spike_icon: place 1 spike token on each body part.',
                            'es' => 'Cada parte del cuerpo en la carta de fisiología de Nergigante tiene un alijo de fichas de espiga, donde se deben colocar las fichas de espiga asignadas a esa parte. Cada alijo puede contener un máximo de 3 fichas de espiga; no coloques ninguna ficha de espiga que exceda esta cantidad.<br>Cuando una parte del cuerpo no tiene fichas de espiga, la primera ficha de espiga que se coloque en su alijo de fichas de espiga es una ficha de espiga negra. Cualquier ficha de espiga adicional colocada en esa parte del cuerpo son fichas de espiga blancas.<br>Después de resolver una carta de comportamiento con el :spike_icon:, coloca 1 ficha de espiga en cada parte del cuerpo.',
                        ],
                    ],
                    [
                        'title' => [
                            'en' => 'Spike Token Effect',
                            'es' => 'Efecto de las Fichas de Espiga',
                        ],
                        'description' => [
                            'en' => 'Each monster part gains +1 :defense_icon: for each spike token currently in its spike token stash.',
                            'es' => 'Cada parte de monstruo gana +1 :defense_icon: por cada ficha de espiga que tenga actualmente en su reserva de fichas de espiga.',
                        ],
                    ],
                    [
                        'title' => [
                            'en' => 'Removing Spike Token',
                            'es' => 'Eliminar Ficha de Espiga',
                        ],
                        'description' => [
                            'en' => 'When a hunter attacks a part of Nergigante with white spike tokens in its spike token stash, after the attack card is resolved, they may remove a number of white spike tokens from that part up to the :break_icon: of the attack card, including any :break_icon: bonuses.',
                            'es' => 'Cuando un cazador ataca una parte de Nergigante con fichas de espiga blancas en su reserva de fichas de espiga, después de que se resuelva la carta de ataque, puede eliminar una cantidad de fichas de espiga blancas de esa parte hasta el :break_icon: de la carta de ataque, incluyendo cualquier :break_icon: de bonificación.',
                        ],
                    ],
                    [
                        'title' => [
                            'en' => 'Nergigante Dive',
                            'es' => 'Nergigante Dive',
                        ],
                        'description' => [
                            'en' => 'If Nergigante begins its turn with 6 or more spike tokens on its physiology card, resolve the Nergigante Dive :nergigante_icon: behaviour card instead of drawing a behaviour card.<br>After resolving this behaviour card remove all spike tokens from Nergigante\'s physiology card, but don\'t discard the Nergigante Dive behaviour card. Instead, place it face up next to the physiology card. Nergigante Dive may need to be resolved multiple times during the hunt.',
                            'es' => 'Si Nergigante comienza su turno con 6 o más fichas de espinas en su carta de fisiología, resuelve la carta de comportamiento Nergigante Dive :nergigante_icon: en lugar de robar una carta de comportamiento.<br>Después de resolver esta carta de comportamiento, retira todas las fichas de espinas de la carta de fisiología de Nergigante, pero no descartes la carta de comportamiento Nergigante Dive. En su lugar, colócala boca arriba junto a la carta de fisiología. Nergigante Dive puede necesitar resolverse varias veces durante la caza',
                        ],
                    ],
                ],
            ],
        ],
        'items' => [
            'Nergigante Horn',
            'Nergigante Carapace',
            'Nergigante Talon',
            'Nergigante Tail',
            'Nergigante Gem',
            'Nergigante Regrowth Plate',
            'Immortal Dragonscale',
        ],
        'resistance' => [
            'fire' => 2,
            'water' => null,
            'thunder' => 1,
            'ice' => null,
            'dragon' => 2,

            'paralysis' => 2,
            'poison' => 2,
            'sleep' => 2,
            'nitro' => 2,
            'stun' => null,
        ],
        'difficulty' => [
            [
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 85,
                'ability' => [
                    'name' => [
                        'en' => 'Growing Armour',
                        'es' => 'Armadura en Crecimiento',
                    ],
                    'description' => [
                        'en' => 'When you attack a body part of Nergigante without spike tokens, place 1 black spike token on that part. After resolving a behaviour card with :black_spike_icon: place 1 spike token on each body part. If Nergigante begins its turn with 6 or more spike tokens on its physiology card, resolve the Nergigante Dive :nergigante_icon: behaviour card instead of drawing a behaviour card.',
                        'es' => 'Cuando un cazador ataca una parte del cuerpo de Nergigante sin fichas de espiga, coloca 1 ficha de espiga negra en esa parte. Después de resolver una carta de comportamiento con :black_spike_icon:, coloca 1 ficha de espiga en cada parte del cuerpo. Si Nergigante comienza su turno con 6 o más fichas de espiga en su carta de fisiología, resuelve la carta de comportamiento Nergigante Dive :nergigante_icon: en lugar de robar una carta de comportamiento.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 2,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Remove Horn Gouge from the behaviour deck. Shuffle discarded behaviour cards into the deck.',
                            'es' => 'Retira Horn Gouge de la plataforma de comportamiento. Mezcla las cartas de comportamiento descartadas en el mazo.',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 3,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :wing_icon: have -1 :dodge_icon:',
                            'es' => 'Los comportamientos con :wing_icon: tienen -1 :dodge_icon:',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 2,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Discard the top card of the monster\'s behaviour deck.',
                            'es' => 'Descarta la carta superior del mazo de comportamiento del monstruo.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :range_icon:',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :range_icon:',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 95,
                'ability' => [
                    'name' => [
                        'en' => 'Growing Armour',
                        'es' => 'Armadura en Crecimiento',
                    ],
                    'description' => [
                        'en' => 'When you attack a body part of Nergigante without spike tokens, place 1 black spike token on that part. After resolving a behaviour card with :black_spike_icon: place 1 spike token on each body part. If Nergigante begins its turn with 6 or more spike tokens on its physiology card, resolve the Nergigante Dive :nergigante_icon: behaviour card instead of drawing a behaviour card.',
                        'es' => 'Cuando un cazador ataca una parte del cuerpo de Nergigante sin fichas de espiga, coloca 1 ficha de espiga negra en esa parte. Después de resolver una carta de comportamiento con :black_spike_icon:, coloca 1 ficha de espiga en cada parte del cuerpo. Si Nergigante comienza su turno con 6 o más fichas de espiga en su carta de fisiología, resuelve la carta de comportamiento Nergigante Dive :nergigante_icon: en lugar de robar una carta de comportamiento.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 2,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :damage_icon:',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :damage_icon:',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 3,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :wing_icon: have -1 :dodge_icon:',
                            'es' => 'Los comportamientos con :wing_icon: tienen -1 :dodge_icon:',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Remove 1 white spike token from each body part.',
                            'es' => 'Retira 1 ficha de pico blanco de cada parte del cuerpo.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :damage_icon:',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :damage_icon:',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
                'stars' => 5,
                'health' => 110,
                'ability' => [
                    'name' => [
                        'en' => 'Armoured Nightmare',
                        'es' => 'Pesadilla Acorazada',
                    ],
                    'description' => [
                        'en' => 'Behaviour gain +1 :damage_icon:. When you attack a body part of Nergigante without spike tokens, place 1 black spike token on that part. After resolving a behaviour card with :black_spike_icon: place 1 spike token on each body part. If Nergigante begins its turn with 6 or more spike tokens on its physiology card, resolve the Nergigante Dive :nergigante_icon: behaviour card instead of drawing a behaviour card.',
                        'es' => 'Los comportamientos ganan +1 :damage_icon:. Cuando un cazador ataca una parte del cuerpo de Nergigante sin fichas de espiga, coloca 1 ficha de espiga negra en esa parte. Después de resolver una carta de comportamiento con :black_spike_icon:, coloca 1 ficha de espiga en cada parte del cuerpo. Si Nergigante comienza su turno con 6 o más fichas de espiga en su carta de fisiología, resuelve la carta de comportamiento Nergigante Dive :nergigante_icon: en lugar de robar una carta de comportamiento.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :damage_icon:',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :damage_icon:',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :wing_icon: have -1 :dodge_icon:',
                            'es' => 'Los comportamientos con :wing_icon: tienen -1 :dodge_icon:',
                        ],
                    ],
                    [
                        'icon' => 'claw',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Remove 1 white spike token from each body part.',
                            'es' => 'Retira 1 ficha de pico blanco de cada parte del cuerpo.',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 4,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :tail_icon: have -1 :damage_icon:',
                            'es' => 'Los comportamientos con :tail_icon: tienen -1 :damage_icon:',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            1 => [
                'name' => 'Immortal Dragonscale',
            ],
            2 => [
                'name' => 'Nergigante Talon',
            ],
            3 => [
                'name' => 'Nergigante Carapace',
            ],
            4 => [
                'name' => 'Nergigante Regrowth Plate',
            ],
            5 => [
                'name' => 'Nergigante Horn',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
            6 => [
                'name' => 'Nergigante Tail',
                'extra' => [
                    'en' => 'Gain 1 if the :tail_icon: were broken.',
                    'es' => 'Gana 1 si el :tail_icon: estuviera roto.',
                ],
            ],
            7 => [
                'name' => 'Elder Dragon Bone',
            ],
            8 => [
                'name' => 'Elder Dragon Blood',
            ],
            9 => [
                'name' => 'Nergigante Regrowth Plate',
                'extra' => [
                    'en' => 'Gain 1 if the :claw_icon: were broken.',
                    'es' => 'Gana 1 si el :claw_icon: estuviera roto.',
                ],
            ],
            10 => [
                'name' => 'Nergigante Gem',
            ],
            11 => [
                'name' => 'Elder Dragon Bone',
            ],
            12 => [
                'name' => 'Nergigante Talon',
                'extra' => [
                    'en' => 'Gain 1 if the :wing_icon: were broken.',
                    'es' => 'Gana 1 si el :wing_icon: estuviera roto.',
                ],
            ],
        ],
    ],
    'Kushala Daora' => [
        'category' => App\Enum\MonsterCategory::ELDER_DRAGON,
        'expansion' => App\Enum\MonsterExpansion::KUSHALA_EXPANSION,
        'setup' => [
            'en' => 'Gather 2 wind tokens and 5 tornado tokens. Place them to the side of the playing area.<br>Return additional wind and tornado tokens to the game box, there are spare tokens.',
            'es' => 'Reúne 2 fichas de viento y 5 fichas de tornado. Colócalas a un lado del área de juego.<br>Devuelve las fichas de viento y tornado adicionales a la caja del juego, hay fichas de repuesto.',
        ],
        'mechanics' => [
            [
                'title' => [
                    'en' => 'Wind Tokens',
                    'es' => 'Fichas de Viento',
                ],
                'description' => [
                    [
                        'title' => [
                            'en' => 'Placing Wind Tokens',
                            'es' => 'Colocación de Fichas de Viento',
                        ],
                        'description' => [
                            'en' => 'At the start of Kushala Daora\'s turn, place 1 wind token on its physiology card. If 2 wind tokens are on its physiology card, remove both tokens instead of placing 1.',
                            'es' => 'Al comienzo del turno de Kushala Daora, coloca 1 ficha de viento en su carta de fisiología. Si ya hay 2 fichas de viento en su carta de fisiología, retira ambas fichas en lugar de colocar 1.',
                        ],
                    ],
                    [
                        'title' => [
                            'en' => 'Wind Token Effect',
                            'es' => 'Efecto de las Fichas de Viento',
                        ],
                        'description' => [
                            'en' => 'During your turn, when your hunter moves onto a node adjacent to Kushala Daora you must discard attack cards from your hand with a total agility value that equals or exceeds the number of wind tokens currently on its physiology card.<br>If you\'re unable to discard the required attacks cards your hunter can\'t move onto the node. If there are no wind tokens on the physiology card, you don\'t discard any attacks cards.<br>Hunter attacks cards have -1 :range_icon: for each wind token on Kushala Daora\'s physiology card, to a minimum of 1.',
                            'es' => 'Durante tu turno, cuando tu cazador se mueva a un nodo adyacente a Kushala Daora debes descartar cartas de ataque de tu mano con un valor de agilidad total que iguale o supere el número de fichas de viento que haya en ese momento en su carta de fisiología.<br>Si no puedes descartar las cartas de ataque necesarias, tu cazador no puede moverse a ese nodo. Si no hay fichas de viento en la carta de fisiología, no descartas ninguna carta de ataque.<br>Las cartas de ataque de los cazadores tienen -1 :range_icon: por cada ficha de viento en la carta de fisiología de Kushala Daora, hasta un mínimo de 1.',
                        ],
                    ],
                ],
            ],
            [
                'title' => [
                    'en' => 'Tornado Tokens',
                    'es' => 'Fichas de Tornado',
                ],
                'description' => [
                    [
                        'title' => [
                            'en' => 'Placing Tornado Tokens',
                            'es' => 'Colocación de Fichas de Tornado',
                        ],
                        'description' => [
                            'en' => 'When you draw a behaviour card for Kushala Daora with :tornado_icon:, place 1 tornado token on the node it\'s positioned on.<br>If that node already has a tornado token, don\'t place another one. If there are already 5 tornado tokens on the game board, remove all tornado tokens from game board. Then place 1 tornado token on the node Kushala Daora is positioned on.',
                            'es' => 'Cuando robes una carta de comportamiento para Kushala Daora con :tornado_icon:, coloca 1 ficha de tornado en el nodo en el que se encuentra.<br>Si ese nodo ya tiene una ficha de tornado, no coloques otra. Si ya hay 5 fichas de tornado en el tablero de juego, retira todas las fichas de tornado del tablero. Después coloca 1 ficha de tornado en el nodo en el que se encuentra Kushala Daora.',
                        ],
                    ],
                    [
                        'title' => [
                            'en' => 'Tornado Token Effect',
                            'es' => 'Efecto de las Fichas de Tornado',
                        ],
                        'description' => [
                            'en' => 'During your turn, when your hunter moves onto a node containing a tornado token you must discard attack cards from your hand with a total agility value that equals or exceeds the number of wind token on the Kushala Daora\'s physiology card.<br>If you\'re unable to discard the required attacks cards your hunter can\'t move onto the node. If there are no wind tokens on the physiology card, you don\'t discard any attacks cards.<br>Tornado tokens don\'t affect the movement of Kushala Daora.',
                            'es' => 'Durante tu turno, cuando tu cazador se mueva a un nodo que contenga una ficha de tornado debes descartar cartas de ataque de tu mano con un valor de agilidad total que iguale o supere el número de fichas de viento que haya en la carta de fisiología de Kushala Daora.<br>Si no puedes descartar las cartas de ataque necesarias, tu cazador no puede moverse a ese nodo. Si no hay fichas de viento en la carta de fisiología, no descartas ninguna carta de ataque.<br>Las fichas de tornado no afectan al movimiento de Kushala Daora.',
                        ],
                    ],
                ],
            ],
        ],
        'items' => [
            'Daora Dragon Scale',
            'Daora Carapace',
            'Daora Claw',
            'Daora Webbing',
            'Daora Tail',
            'Daora Horn',
            'Daora Gem',
        ],
        'resistance' => [
            'fire' => 2,
            'water' => null,
            'thunder' => 1,
            'ice' => null,
            'dragon' => 2,

            'paralysis' => null,
            'poison' => 1,
            'sleep' => null,
            'nitro' => 1,
            'stun' => 2,
        ],
        'difficulty' => [
            [
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 85,
                'ability' => [
                    'name' => [
                        'en' => 'Fierce Winds',
                        'es' => 'Vientos Feroces',
                    ],
                    'description' => [
                        'en' => 'At the start of Kushala Daora\'s turn, place 1 wind token on its physiology card. If 2 wind tokens are on its physiology card, remove both tokens instead of placing 1. During your turn, when your hunter moves onto a node adjacent to Kushala Daora you must discard attack cards from your hand with a total agility value that equals or exceeds the number of wind tokens currently on its physiology card.',
                        'es' => 'Al comienzo del turno de Kushala Daora, coloca 1 ficha de viento en su carta de fisiología. Si hay 2 fichas de viento en su carta de fisiología, retira ambas fichas en lugar de colocar 1. Durante tu turno, cuando tu cazador se mueva a un nodo adyacente a Kushala Daora, debes descartar cartas de ataque de tu mano con un valor total de agilidad que sea igual o superior al número de fichas de viento que haya actualmente en su carta de fisiología.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Remove Double Bite from the behaviour deck. Shuffle discarded behaviour cards into the deck.',
                            'es' => 'Retira Double Bite del mazo de comportamientos. Baraja las cartas de comportamiento descartadas en el mazo.',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Remove up to 5 tornado tokens from the game board.',
                            'es' => 'Retira hasta 5 fichas de tornado del tablero de juego.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :movement_icon:',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :movement_icon:',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Remove up to 2 wind tokens from this monster\'s physiology card.',
                            'es' => 'Retira hasta 2 fichas de viento de la carta de fisiología de este monstruo.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 95,
                'ability' => [
                    'name' => [
                        'en' => 'Fierce Winds',
                        'es' => 'Vientos Feroces',
                    ],
                    'description' => [
                        'en' => 'At the start of Kushala Daora\'s turn, place 1 wind token on its physiology card. If 2 wind tokens are on its physiology card, remove both tokens instead of placing 1. During your turn, when your hunter moves onto a node adjacent to Kushala Daora you must discard attack cards from your hand with a total agility value that equals or exceeds the number of wind tokens currently on its physiology card.',
                        'es' => 'Al comienzo del turno de Kushala Daora, coloca 1 ficha de viento en su carta de fisiología. Si hay 2 fichas de viento en su carta de fisiología, retira ambas fichas en lugar de colocar 1. Durante tu turno, cuando tu cazador se mueva a un nodo adyacente a Kushala Daora, debes descartar cartas de ataque de tu mano con un valor total de agilidad que sea igual o superior al número de fichas de viento que haya actualmente en su carta de fisiología.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 3,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have +1 :card_behaviour_icon:',
                            'es' => 'Los comportamientos con :head_icon: tienen +1 :card_behaviour_icon:',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Remove up to 4 tornado tokens from the game board.',
                            'es' => 'Retira hasta 4 fichas de tornado del tablero de juego.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :movement_icon:',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :movement_icon:',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 5,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Remove up to 2 wind tokens from this monster\'s physiology card.',
                            'es' => 'Retira hasta 2 fichas de viento de la carta de fisiología de este monstruo.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
                'stars' => 5,
                'health' => 110,
                'ability' => [
                    'name' => [
                        'en' => 'Devastating Winds',
                        'es' => 'Vientos Devastadores',
                    ],
                    'description' => [
                        'en' => 'Behaviours gain +1 :damage_icon:. At the start of Kushala Daora\'s turn, place 1 wind token on its physiology card. If 2 wind tokens are on its physiology card, remove both tokens instead of placing 1. During your turn, when your hunter moves onto a node adjacent to Kushala Daora you must discard attack cards from your hand with a total agility value that equals or exceeds the number of wind tokens currently on its physiology card.',
                        'es' => 'Los comportamientos ganan +1 :damage_icon:. Al comienzo del turno de Kushala Daora, coloca 1 ficha de viento en su carta de fisiología. Si hay 2 fichas de viento en su carta de fisiología, retira ambas fichas en lugar de colocar 1. Durante tu turno, cuando tu cazador se mueva a un nodo adyacente a Kushala Daora, debes descartar cartas de ataque de tu mano con un valor total de agilidad que sea igual o superior al número de fichas de viento que haya actualmente en su carta de fisiología.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have +1 :card_behaviour_icon:',
                            'es' => 'Los comportamientos con :head_icon: tienen +1 :card_behaviour_icon:',
                        ],
                    ],
                    [
                        'icon' => 'wing',
                        'direction' => 'left-right',
                        'defense' => 5,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Remove up to 3 tornado tokens from the game board.',
                            'es' => 'Retira hasta 3 fichas de tornado del tablero de juego.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left-right',
                        'defense' => 5,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Behaviours with :head_icon: have -1 :movement_icon:',
                            'es' => 'Los comportamientos con :head_icon: tienen -1 :movement_icon:',
                        ],
                    ],
                    [
                        'icon' => 'tail',
                        'direction' => 'down',
                        'defense' => 5,
                        'broken' => 6,
                        'ability-broken' => [
                            'en' => 'Remove up to 1 wind tokens from this monster\'s physiology card.',
                            'es' => 'Retira hasta 1 fichas de viento de la carta de fisiología de este monstruo.',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            1 => [
                'name' => 'Daora Webbing',
            ],
            2 => [
                'name' => 'Daora Gem',
            ],
            3 => [
                'name' => 'Daora Claw',
                'extra' => [
                    'en' => 'Gain 1 if the :wing_icon: were broken.',
                    'es' => 'Gana 1 si el :wing_icon: estuviera roto.',
                ],
            ],
            4 => [
                'name' => 'Daora Dragon Scale',
            ],
            5 => [
                'name' => 'Daora Carapace',
            ],
            6 => [
                'name' => 'Daora Horn',
            ],
            7 => [
                'name' => 'Daora Tail',
                'extra' => [
                    'en' => 'Gain 1 if the :tail_icon: were broken.',
                    'es' => 'Gana 1 si el :tail_icon: estuviera roto.',
                ],
            ],
            8 => [
                'name' => 'Elder Dragon Bone',
            ],
            9 => [
                'name' => 'Elder Dragon Blood',
            ],
            10 => [
                'name' => 'Daora Horn',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
            11 => [
                'name' => 'Daora Carapace',
                'extra' => [
                    'en' => 'Gain 1 if the :paw_icon: were broken.',
                    'es' => 'Gana 1 si el :paw_icon: estuviera roto.',
                ],
            ],
            12 => [
                'name' => 'Elder Dragon Bone',
            ],
        ],
    ],
    'Kirin' => [
        'category' => App\Enum\MonsterCategory::ELDER_DRAGON,
        'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
        'setup' => [
            'en' => 'Locate the Powered Up card and the 5 Thunderstrike cards.<br>While preparing for the gathering phase, place the Powered Up card near the playing area, <strong>face down</strong>. Shuffle the Thunderstrike cards and place them in a deck near the Powered Up card, <strong>face up</strong>. Be careful not to change the orientation of this deck during the game.',
            'es' => 'Localiza la carta de Sobrecarga y las 5 cartas de Descarga.<br>Mientras preparas la fase de recolección, coloca la carta de Sobrecarga cerca de la zona de juego, <strong>boca abajo</strong>. Baraja las cartas de Descarga y colócalas en un mazo cerca de la carta de Sobrecarga, <strong>boca arriba</strong>. Ten cuidado de no cambiar la orientación de este mazo durante la partida.',
        ],
        'mechanics' => [
            [
                'title' => [
                    'en' => 'Special Rules',
                    'es' => 'Reglas Especiales',
                ],
                'description' => [
                    [
                        'title' => [
                            'en' => 'Powered Up Card',
                            'es' => 'Carta de Sobrecarga',
                        ],
                        'description' => [
                            'en' => 'When Kirin resolves a :thunder_icon: behaviour card while the Powered Up card is face down, flip it face up.',
                            'es' => 'Cuando Kirin resuelve una carta de comportamiento :thunder_icon: mientras la carta de Sobrecarga está boca abajo, dale la vuelta boca arriba.',
                        ],
                    ],
                    [
                        'title' => [
                            'en' => 'Powered Up Effect',
                            'es' => 'Efecto de Sobrecarga',
                        ],
                        'description' => [
                            'en' => 'While the Powered Up card is face up, Kirin\'s :back_icon: and :paw_icon: body parts have +1 :defense_icon:.',
                            'es' => 'Mientras la carta de Sobrecarga está boca arriba, las partes del cuerpo :back_icon: y :paw_icon: de Kirin tienen +1 :defense_icon:.',
                        ],
                    ],
                    [
                        'title' => [
                            'en' => 'Thunderstrike Cards',
                            'es' => 'Cartas de Descarga',
                        ],
                        'description' => [
                            'en' => 'When Kirin resolves a :thunder_icon: behaviour card while the Powered Up card is face up, refer to the top Thunderstrike card to determine its targets.<br>As well as targeting the hunters indicated on its behaviour card as normal, this attack also targets any hunters in the highlighted nodes, and the damage is increased by the amount shown by the symbol. If a node is targeted by both the behaviour card and the Thunderstrike card, the hunter is still only attacked once.<br>After resolving the attack, flip the Powered Up card face down, and discard the Thunderstrike card to reveal the next card. If the Thunderstrike deck is empty, shuffle it to create a new Thunderstrike deck.',
                            'es' => 'Cuando Kirin resuelve una carta de comportamiento :thunder_icon: mientras la carta de Sobrecarga está boca arriba, consulta la carta de Descarga superior para determinar sus objetivos.<br>Además de tener como objetivo a los cazadores indicados en su carta de comportamiento como es habitual, este ataque también tiene como objetivo a cualquier cazador situado en los nodos resaltados, y el daño aumenta en la cantidad que muestre el símbolo. Si un nodo es objetivo tanto de la carta de comportamiento como de la carta de Descarga, el cazador solo es atacado una vez.<br>Después de resolver el ataque, pon la carta de Sobrecarga boca abajo y descarta la carta de Descarga para revelar la siguiente. Si el mazo de Descarga está vacío, barájalo para crear un nuevo mazo de Descarga.',
                        ],
                    ],
                    [
                        'title' => [
                            'en' => 'Meowscular Chef\'s Aid (Wildspire Waste Campaign Only)',
                            'es' => 'Ayuda del Chef Felinítico (solo campaña de Yermo de Agujas)',
                        ],
                        'description' => [
                            'en' => 'The Wildspire Waste set doesn\'t have any armour cards with thunder resistance, with them only originally being available to forge if you also have the Ancient Forest set.<br>When playing the Kirin assigned quest, if no armour cards with thunder elemental resistance are available, each hunter in the group has +2 bonus thunder elemental resistance for the duration of the quest.',
                            'es' => 'El set de Yermo de Agujas no tiene ninguna carta de armadura con resistencia al trueno, ya que originalmente solo se podían forjar si también tenías el set de Bosque Primigenio.<br>Al jugar la misión asignada de Kirin, si no hay disponible ninguna carta de armadura con resistencia elemental al trueno, cada cazador del grupo tiene +2 de resistencia elemental al trueno durante toda la misión.',
                        ],
                    ],
                ],
            ],
        ],
        'items' => [
            'Kirin Thunderhorn',
            'Kirin Hide',
            'Kirin Tail',
            'Kirin Azure Horn',
            'Kirin Mane',
        ],
        'resistance' => [
            'fire' => 1,
            'water' => 1,
            'thunder' => null,
            'ice' => 1,
            'dragon' => null,

            'paralysis' => null,
            'poison' => null,
            'sleep' => 2,
            'nitro' => 2,
            'stun' => 2,
        ],
        'difficulty' => [
            [
                'difficulty' => App\Enum\MonsterDifficulty::EASY,
                'stars' => 1,
                'health' => 85,
                'ability' => [
                    'name' => [
                        'en' => 'High Voltage',
                        'es' => 'Alto Voltaje',
                    ],
                    'description' => [
                        'en' => 'When Kirin resolves a :thunder_icon: behaviour card while the Powered Up card is face down, flip face up. When Kirin resolves a :thunder_icon: behaviour card while the Powered Up card is face up, refer to the top Thunderstrike card to determine its targets. After resolving the attack flip the Powered Up card face down, and discard the Thunderstrike card.',
                        'es' => 'Cuando Kirin resuelve una carta de comportamiento :thunder_icon: mientras la carta de Sobrecarga está boca abajo, ponla boca arriba. Cuando Kirin resuelve una carta de comportamiento :thunder_icon: mientras la carta de Sobrecarga está boca arriba, consulta la carta de Descarga superior para determinar sus objetivos. Después de resolver el ataque, pon la carta de Sobrecarga boca abajo y descarta la carta de Descarga.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 3,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Discard the top card of the Thunderstrike deck.',
                            'es' => 'Descarta la carta superior del mazo de Descarga.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right-down',
                        'defense' => 4,
                        'broken' => 6,
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left-right',
                        'defense' => 3,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'This body part doesn\'t gain +1 :defense_icon: while the Powered Up card is face up.',
                            'es' => 'Esta parte del cuerpo no obtiene +1 :defense_icon: mientras la carta de Sobrecarga está boca arriba.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::NORMAL,
                'stars' => 2,
                'health' => 95,
                'ability' => [
                    'name' => [
                        'en' => 'High Voltage',
                        'es' => 'Alto Voltaje',
                    ],
                    'description' => [
                        'en' => 'When Kirin resolves a :thunder_icon: behaviour card while the Powered Up card is face down, flip face up. When Kirin resolves a :thunder_icon: behaviour card while the Powered Up card is face up, refer to the top Thunderstrike card to determine its targets. After resolving the attack flip the Powered Up card face down, and discard the Thunderstrike card.',
                        'es' => 'Cuando Kirin resuelve una carta de comportamiento :thunder_icon: mientras la carta de Sobrecarga está boca abajo, ponla boca arriba. Cuando Kirin resuelve una carta de comportamiento :thunder_icon: mientras la carta de Sobrecarga está boca arriba, consulta la carta de Descarga superior para determinar sus objetivos. Después de resolver el ataque, pon la carta de Sobrecarga boca abajo y descarta la carta de Descarga.',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 4,
                        'broken' => 8,
                        'ability-broken' => [
                            'en' => 'Discard the top card of the Thunderstrike deck.',
                            'es' => 'Descarta la carta superior del mazo de Descarga.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right-down',
                        'defense' => 5,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Ignore the :thunder_icon: bonus on the next Thunderstrike card.',
                            'es' => 'Ignora la bonificación :thunder_icon: de la siguiente carta de Descarga.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left-right',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'This body part doesn\'t gain +1 :defense_icon: while the Powered Up card is face up.',
                            'es' => 'Esta parte del cuerpo no obtiene +1 :defense_icon: mientras la carta de Sobrecarga está boca arriba.',
                        ],
                    ],
                ],
            ],
            [
                'difficulty' => App\Enum\MonsterDifficulty::HARD,
                'stars' => 5,
                'health' => 110,
                'ability' => [
                    'name' => [
                        'en' => 'Thunderstruck',
                        'es' => 'Fulminado',
                    ],
                    'description' => [
                        'en' => 'When Kirin resolves a :thunder_icon: behaviour card while the Powered Up card is face down, flip face up. When Kirin resolves a :thunder_icon: behaviour card while the Powered Up card is face up, refer to the top Thunderstrike card to determine its targets. After resolving the attack flip the Powered Up card face down, and discard the Thunderstrike card. Behaviours gain +1 :damage_icon:',
                        'es' => 'Cuando Kirin resuelve una carta de comportamiento :thunder_icon: mientras la carta de Sobrecarga está boca abajo, ponla boca arriba. Cuando Kirin resuelve una carta de comportamiento :thunder_icon: mientras la carta de Sobrecarga está boca arriba, consulta la carta de Descarga superior para determinar sus objetivos. Después de resolver el ataque, pon la carta de Sobrecarga boca abajo y descarta la carta de Descarga. Los comportamientos obtienen +1 :damage_icon:',
                    ],
                ],
                'parts' => [
                    [
                        'icon' => 'head',
                        'direction' => 'up',
                        'defense' => 4,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Look at then discard any number of the Thunderstrike cards.',
                            'es' => 'Mira y después descarta cualquier número de cartas de Descarga.',
                        ],
                    ],
                    [
                        'icon' => 'back',
                        'direction' => 'left-right-down',
                        'defense' => 5,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'Ignore the :thunder_icon: bonus on the next Thunderstrike card.',
                            'es' => 'Ignora la bonificación :thunder_icon: de la siguiente carta de Descarga.',
                        ],
                    ],
                    [
                        'icon' => 'paw',
                        'direction' => 'left-right',
                        'defense' => 5,
                        'broken' => 7,
                        'ability-broken' => [
                            'en' => 'This body part doesn\'t gain +1 :defense_icon: while the Powered Up card is face up.',
                            'es' => 'Esta parte del cuerpo no obtiene +1 :defense_icon: mientras la carta de Sobrecarga está boca arriba.',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            1 => [
                'name' => 'Kirin Azure Horn',
            ],
            2 => [
                'name' => 'Kirin Thunderhorn',
            ],
            3 => [
                'name' => 'Kirin Mane',
            ],
            4 => [
                'name' => 'Kirin Hide',
            ],
            5 => [
                'name' => 'Kirin Tail',
            ],
            6 => [
                'name' => 'Kirin Hide',
            ],
            7 => [
                'name' => 'Kirin Thunderhorn',
                'extra' => [
                    'en' => 'Gain 1 if the :head_icon: were broken.',
                    'es' => 'Gana 1 si el :head_icon: estuviera roto.',
                ],
            ],
            8 => [
                'name' => 'Kirin Tail',
                'extra' => [
                    'en' => 'Gain 1 if the :paw_icon: were broken.',
                    'es' => 'Gana 1 si el :paw_icon: estuviera roto.',
                ],
            ],
            9 => [
                'name' => 'Kirin Azure Horn',
            ],
            10 => [
                'name' => 'Kirin Hide',
                'extra' => [
                    'en' => 'Gain 1 if the :back_icon: were broken.',
                    'es' => 'Gana 1 si el :back_icon: estuviera roto.',
                ],
            ],
            11 => [
                'name' => 'Kirin Mane',
            ],
            12 => [
                'name' => 'Kirin Azure Horn',
            ],
        ],
    ],
];
