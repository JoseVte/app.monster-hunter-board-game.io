<?php

return [
    'name' => [
        'en' => 'Hunting Horn',
        'es' => 'Cornamusa',
    ],
    'description' => [
        'en' => 'During setup, locate the Song List card shown on your weapon card. Place the Song List and Perform cards face up near your stamina board.<br>
During your turn you may play a song by following the instructions on the Perform card.<br>
Song effects last until the start of your next turn.',
        'es' => 'Durante la configuración, localiza la carta de Lista de Canciones que se muestra en tu carta de arma. Coloca la Lista de Canciones y las cartas de Actuación boca arriba cerca de tu tablero de resistencia.<br>
Durante tu turno puedes tocar una canción siguiendo las instrucciones en la carta de Actuación.<br>
Los efectos de la canción duran hasta el comienzo de tu próximo turno.',
    ],
    'image' => 'icon_weapon_06.png',
    'song-effects' => [
        [
            'name' => [
                'en' => 'Self Improvement',
                'es' => 'Automejora',
            ],
            'description' => [
                'en' => 'Only this hunter is affected. When this hunter walks, they move up to 2 nodes instead of 1.',
                'es' => 'Solo este cazador se ve afectado. Cuando este cazador camina, se mueve hasta 2 nodos en lugar de 1.',
            ],
        ],
        [
            'name' => [
                'en' => 'Attack Up',
                'es' => 'Ataque Mejorado',
            ],
            'description' => [
                'en' => 'The next time each affected hunter inflicts damage, they draw +2 :damage_attack_icon:.',
                'es' => 'La próxima vez que cada cazador afectado inflija daño, roba +2 :damage_attack_icon:.',
            ],
        ],
        [
            'name' => [
                'en' => 'Defence Up',
                'es' => 'Defensa Mejorada',
            ],
            'description' => [
                'en' => 'Each affected hunter gains +1 :defense_icon:.',
                'es' => 'Cada cazador afectado obtiene +1 :defense_icon:.',
            ],
        ],
        [
            'name' => [
                'en' => 'Health Recovery',
                'es' => 'Recuperación de Salud',
            ],
            'description' => [
                'en' => 'The next time each affected hunter takes a turn, they recover 2 lost health.',
                'es' => 'La próxima vez que cada cazador afectado tome un turno, recupera 2 de salud perdida.',
            ],
        ],
        [
            'name' => [
                'en' => 'Earplugs',
                'es' => 'Tapones para los Oídos',
            ],
            'description' => [
                'en' => 'Each affected hunter may immediately discard 1 attack card from their hand to move up to 2 nodes.',
                'es' => 'Cada cazador afectado puede descartar inmediatamente 1 carta de ataque de su mano para moverse hasta 2 nodos.',
            ],
        ],
        [
            'name' => [
                'en' => 'Stamina Use Reduced',
                'es' => 'Uso de Resistencia Reducido',
            ],
            'description' => [
                'en' => 'The next time each affected hunter plays an attack card onto their stamina board, they may discard it.',
                'es' => 'La próxima vez que cada cazador afectado juegue una carta de ataque en su tablero de resistencia, puede descartarla.',
            ],
        ],
        [
            'name' => [
                'en' => 'Environment Effects Negated',
                'es' => 'Efectos del Entorno Anulados',
            ],
            'description' => [
                'en' => 'Each affected hunter ignores the effects of pond nodes.',
                'es' => 'Cada cazador afectado ignora los efectos de los nodos de estanque.',
            ],
        ],
        [
            'name' => [
                'en' => 'Affinity Up and Health Recovery',
                'es' => '',
            ],
            'description' => [
                'en' => 'The next time each affected hunter takes a turn, they recover 2 lost health and they double the value of the next :damage_attack_icon: card they draw.',
                'es' => '',
            ],
        ],
        [
            'name' => [
                'en' => 'All Ailment Negated',
                'es' => '',
            ],
            'description' => [
                'en' => 'Until their next turn affected hunters can\'t suffer ailments.',
                'es' => '',
            ],
        ],
        [
            'name' => [
                'en' => 'Divine Protection',
                'es' => '',
            ],
            'description' => [
                'en' => 'The next time each affected hunter suffers damage that would cause them to faint, set their dial to 1.',
                'es' => '',
            ],
        ],
        [
            'name' => [
                'en' => 'Thunder Resistance Boost',
                'es' => '',
            ],
            'description' => [
                'en' => 'Each affected hunter gains 1 :thunder_resistance_icon:.',
                'es' => '',
            ],
        ],
    ],
    'song-lists' => [
        [
            'name' => [
                'en' => 'Ore Song List',
                'es' => 'Lista de Canciones de Metal',
            ],
            'songs' => [
                'Self Improvement' => [
                    'range' => 0,
                    'notes' => ['white', 'white'],
                ],
                'Attack Up' => [
                    'range' => 1,
                    'notes' => ['white', 'red', 'red'],
                ],
                'Defence Up' => [
                    'range' => 1,
                    'notes' => ['white', 'blue', 'blue'],
                ],
            ],
        ],
        [
            'name' => [
                'en' => 'Bone Song List',
                'es' => 'Lista de Canciones de Huesos',
            ],
            'songs' => [
                'Self Improvement' => [
                    'range' => 0,
                    'notes' => ['white', 'white'],
                ],
                'Attack Up' => [
                    'range' => 1,
                    'notes' => ['white', 'red', 'red'],
                ],
                'Environment Effects Negated' => [
                    'range' => 3,
                    'notes' => ['red', 'red', 'blue'],
                ],
            ],
        ],
        [
            'name' => [
                'en' => 'Tobi-Kadachi Song List',
                'es' => 'Lista de Canciones de Tobi-Kadachi',
            ],
            'songs' => [
                'Self Improvement' => [
                    'range' => 0,
                    'notes' => ['white', 'white'],
                ],
                'Health Recovery' => [
                    'range' => 1,
                    'notes' => ['white', 'red', 'white'],
                ],
                'Earplugs' => [
                    'range' => 2,
                    'notes' => ['blue', 'blue', 'red', 'white'],
                ],
            ],
        ],
        [
            'name' => [
                'en' => 'Anjanath Song List',
                'es' => 'Lista de Canciones de Anjanath',
            ],
            'songs' => [
                'Self Improvement' => [
                    'range' => 0,
                    'notes' => ['white', 'white'],
                ],
                'Stamina Use Reduced' => [
                    'range' => 2,
                    'notes' => ['white', 'blue', 'red'],
                ],
                'Defence Up' => [
                    'range' => 1,
                    'notes' => ['white', 'red', 'red'],
                ],
            ],
        ],
        [
            'name' => [
                'en' => 'Pukei-Pukei Song List',
                'es' => 'Lista de Canciones de Pukei-Pukei',
            ],
            'songs' => [
                'Self Improvement' => [
                    'range' => 0,
                    'notes' => ['white', 'white'],
                ],
                'Health Recovery' => [
                    'range' => 1,
                    'notes' => ['white', 'red', 'white'],
                ],
                'Earplugs' => [
                    'range' => 2,
                    'notes' => ['blue', 'blue', 'red', 'white'],
                ],
            ],
        ],
        [
            'name' => [
                'en' => 'Jyuratodus Song List',
                'es' => 'Lista de Canciones de Jyuratodus',
            ],
            'songs' => [
                'Self Improvement' => [
                    'range' => 0,
                    'notes' => ['white', 'white'],
                ],
                'Attack Up' => [
                    'range' => 1,
                    'notes' => ['white', 'red', 'red'],
                ],
                'Environment Effects Negated' => [
                    'range' => 3,
                    'notes' => ['red', 'red', 'blue'],
                ],
            ],
        ],
        [
            'name' => [
                'en' => 'Kulu-Ya-Ku Song List',
                'es' => 'Lista de Canciones de Kulu-Ya-Ku',
            ],
            'songs' => [
                'Self Improvement' => [
                    'range' => 0,
                    'notes' => ['white', 'white'],
                ],
                'Stamina Use Reduced' => [
                    'range' => 2,
                    'notes' => ['white', 'blue', 'red'],
                ],
                'Defence Up' => [
                    'range' => 1,
                    'notes' => ['white', 'blue', 'blue'],
                ],
            ],
        ],
        [
            'name' => [
                'en' => 'Nergigante Song List',
                'es' => 'Lista de Canciones de Nergigante',
            ],
            'songs' => [
                'Self Improvement' => [
                    'range' => 0,
                    'notes' => ['white', 'white'],
                ],
                'Health Recovery' => [
                    'range' => 1,
                    'notes' => ['white', 'red', 'white'],
                ],
                'Affinity Up and Health Recovery' => [
                    'range' => 1,
                    'notes' => ['red', 'blue', 'white', 'blue'],
                ],
            ],
        ],
        [
            'name' => [
                'en' => 'Teostra Song List',
                'es' => 'Lista de Canciones de Teostra',
            ],
            'songs' => [
                'Self Improvement' => [
                    'range' => 0,
                    'notes' => ['white', 'white'],
                ],
                'All Ailment Negated' => [
                    'range' => 1,
                    'notes' => ['red', 'white', 'blue', 'blue'],
                ],
                'Divine Protection' => [
                    'range' => 1,
                    'notes' => ['white', 'blue', 'white', 'red'],
                ],
            ],
        ],
        [
            'name' => [
                'en' => 'Kirin Song List',
                'es' => 'Lista de Canciones de Kirin',
            ],
            'songs' => [
                'Self Improvement' => [
                    'range' => 0,
                    'notes' => ['white', 'white'],
                ],
                'Health Recovery' => [
                    'range' => 1,
                    'notes' => ['white', 'red', 'white'],
                ],
                'Thunder Resistance Boost' => [
                    'range' => 2,
                    'notes' => ['red', 'blue', 'blue'],
                ],
            ],
        ],
    ],
    'weapons' => [
        'Metal Bagpipe' => [
            'default' => true,
            'branch' => 'mineral',
            'name' => 'Gaita Metálica',
            'song_list' => 'Ore Song List',
            'count_attack_1' => 10,
            'count_attack_2' => 2,
        ],
        'Great Bagpipe' => [
            'parent' => 'Metal Bagpipe',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => 'Gaita Mayor',
            'song_list' => 'Ore Song List',
            'count_attack_1' => 8,
            'count_attack_2' => 3,
            'count_attack_3' => 1,
            'items' => [
                'Dragonite Ore' => 1,
                'Machalite Ore' => 1,
                'Monster Bone Medium' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Forward Smash' => 2,
                ],
                'add' => [
                    'Leaping Smash' => 2,
                ],
            ],
        ],
        'Fortissimo' => [
            'parent' => 'Great Bagpipe',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => 'Fortissimo',
            'song_list' => 'Ore Song List',
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
                    'Forward Smash' => 2,
                    'Right Swing' => 2,
                ],
                'add' => [
                    'Leaping Smash' => 2,
                    'Crunching Swing' => 2,
                ],
            ],
        ],
        'Bone Horn' => [
            'branch' => 'bone',
            'name' => 'Cuerno Óseo',
            'song_list' => 'Bone Song List',
            'count_attack_1' => 7,
            'count_attack_2' => 3,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        'Hard Bone Horn' => [
            'parent' => 'Bone Horn',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => 'Cuerno Hueso Pétreo',
            'song_list' => 'Bone Song List',
            'count_attack_1' => 5,
            'count_attack_2' => 5,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Backwards Strike' => 2,
                ],
                'add' => [
                    'Retreatring Strike' => 2,
                ],
            ],
        ],
        'Heavy Bone Horn' => [
            'parent' => 'Hard Bone Horn',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => 'Cuerno Hueso Pesado',
            'song_list' => 'Bone Song List',
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 2,
            'items' => [
                'Monster Hardbone' => 2,
                'Monster Keenbone' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Backwards Strike' => 2,
                    'Hilt Stab' => 2,
                ],
                'add' => [
                    'Retreatring Strike' => 2,
                    'Hilt Slice' => 2,
                ],
            ],
        ],
        // ANCIENT FOREST
        'Thunder Gaida' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Bone Horn',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
            'name' => 'Gaita Trueno',
            'song_list' => 'Tobi-Kadachi Song List',
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 4,
            'items' => [
                'Dragonite Ore' => 2,
                'Tobi-Kadachi Electrode' => 1,
                'Tobi-Kadachi Claw' => 2,
                'Electro Sac' => 1,
                'Coral Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Left Swing' => 2,
                ],
                'add' => [
                    'Static Swing' => 2,
                ],
            ],
        ],
        'Lightning Drm' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Thunder Gaida',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 4,
            'name' => 'Tambor Relámpago',
            'song_list' => 'Tobi-Kadachi Song List',
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 7,
            'items' => [
                'Fucium Ore' => 2,
                'Tobi-Kadachi Electrode' => 2,
                'Tobi-Kadachi Claw' => 2,
                'Thunder Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Left Swing' => 2,
                    'Hilt Stab' => 3,
                ],
                'add' => [
                    'Static Swing' => 2,
                    'Static Strike' => 3,
                ],
            ],
        ],
        'Blazing Horn' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Metal Bagpipe',
            'branch' => 'Anjanath',
            'rarity' => 3,
            'name' => 'Cuerno Flameante',
            'song_list' => 'Anjanath Song List',
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 4,
            'items' => [
                'Anjanath Scale' => 3,
                'Anjanath Fang' => 2,
                'Flame Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Forward Smash' => 2,
                ],
                'add' => [
                    'Forward Blazing Smash' => 2,
                ],
            ],
        ],
        'Anja Barone' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Blazing Horn',
            'branch' => 'Anjanath',
            'rarity' => 4,
            'name' => 'Barone Anja',
            'song_list' => 'Anjanath Song List',
            'has_elemental_attacks' => true,
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 6,
            'items' => [
                'Anjanath Fang' => 4,
                'Anjanath Pelt' => 4,
                'Firecell Stone' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Forward Smash' => 2,
                    'Backwards Strike' => 2,
                ],
                'add' => [
                    'Forward Blazing Smash' => 2,
                    'Blazing Strike' => 2,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        'Blooming Horn' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Horn',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
            'name' => 'Cuerno Floral',
            'song_list' => 'Pukei-Pukei Song List',
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 4,
            'items' => [
                'Pukei-Pukei Quill' => 2,
                'Pukei-Pukei Scale' => 2,
                'Poison Sac' => 1,
                'Pukei-Pukei Tail' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Forward Smash' => 2,
                ],
                'add' => [
                    'Poison Forward Slash' => 2,
                ],
            ],
        ],
        'Datura Horn' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Blooming Horn',
            'branch' => 'Pukei-Pukei',
            'rarity' => 4,
            'name' => 'Cuerno Datura',
            'song_list' => 'Pukei-Pukei Song List',
            'count_attack_1' => 3,
            'count_attack_2' => 4,
            'count_attack_3' => 7,
            'items' => [
                'Pukei-Pukei Scale' => 2,
                'Pukei-Pukei Wing' => 2,
                'Toxic Sac' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Forward Smash' => 2,
                    'Encore' => 2,
                ],
                'add' => [
                    'Poison Forward Slash' => 2,
                    'Poison Encore' => 2,
                ],
            ],
        ],
        'Aqua Bagpipe' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Horn',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
            'name' => 'Gaita Aqua',
            'song_list' => 'Jyuratodus Song List',
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 6,
            'count_attack_3' => 4,
            'items' => [
                'Jyuratodus Fin' => 1,
                'Jyuratodus Shell' => 2,
                'Jyuratodus Scale' => 3,
                'Aqua Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Right Swing' => 2,
                ],
                'add' => [
                    'Aqua Right Swing' => 2,
                ],
            ],
        ],
        'Water Tamtam' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Aqua Bagpipe',
            'branch' => 'Jyuratodus',
            'rarity' => 4,
            'name' => 'Tamtam Acuático',
            'song_list' => 'Jyuratodus Song List',
            'has_elemental_attacks' => true,
            'count_attack_1' => 2,
            'count_attack_2' => 6,
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
                    'Right Swing' => 2,
                    'Hilt Stab' => 3,
                ],
                'add' => [
                    'Aqua Right Swing' => 2,
                    'Aqua Hilt Stab' => 3,
                ],
            ],
        ],
        // KULU YA KU EXPANSION
        'Kulu Duda' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'Metal Bagpipe',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 3,
            'name' => 'Duta Kulu',
            'song_list' => 'Kulu-Ya-Ku Song List',
            'count_attack_1' => 3,
            'count_attack_2' => 5,
            'count_attack_3' => 4,
            'items' => [
                'Kulu-Ya-Ku Beak' => 1,
                'Kulu-Ya-Ku Hide' => 2,
                'Kulu-Ya-Ku Scale' => 4,
                'Earth Crystal' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Left Swing' => 2,
                ],
                'add' => [
                    'Dive Swing' => 2,
                ],
            ],
        ],
        'Dancing Duval' => [
            'expansion' => App\Enum\MonsterExpansion::KULU_YA_KU_EXPANSION,
            'parent' => 'Kulu Duda',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 4,
            'name' => 'Davul Danzante',
            'song_list' => 'Kulu-Ya-Ku Song List',
            'count_attack_1' => 1,
            'count_attack_2' => 4,
            'count_attack_3' => 7,
            'items' => [
                'Kulu-Ya-Ku Beak' => 2,
                'Kulu-Ya-Ku Hide' => 3,
                'Kulu-Ya-Ku Plume' => 3,
                'Boulder Bone' => 4,
            ],
            'attacks' => [
                'remove' => [
                    'Left Swing' => 2,
                    'Upward Swing' => 2,
                ],
                'add' => [
                    'Dive Swing' => 2,
                    'Lullaby Smash' => 1,
                ],
            ],
        ],
        // NERGIGANTE EXPANSION
        'Nergal Groove' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Metal Bagpipe',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => 'Groove Nergal',
            'song_list' => 'Nergigante Song List',
            'has_elemental_attacks' => true,
            'count_attack_2' => 9,
            'count_attack_3' => 2,
            'count_attack_4' => 1,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Backward Strike' => 2,
                ],
                'add' => [
                    'Dragon Strike' => 2,
                ],
            ],
        ],
        'Desolation\'s Overture' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Nergal Groove',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => 'Apertura de Desolación',
            'song_list' => 'Nergigante Song List',
            'has_elemental_attacks' => true,
            'count_attack_2' => 8,
            'count_attack_3' => 4,
            'count_attack_4' => 2,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Backward Strike' => 2,
                    'Encore' => 2,
                ],
                'add' => [
                    'Dragon Strike' => 2,
                    'Explosive Encore' => 2,
                ],
            ],
        ],
        // TEOSTRA EXPANSION
        'Teostra\'s Triple' => [
            'expansion' => App\Enum\MonsterExpansion::TEOSTRA_EXPANSION,
            'parent' => 'Metal Bagpipe',
            'branch' => 'Teostra',
            'rarity' => 4,
            'name' => 'Triple Teostra',
            'count_attack_1' => 4,
            'count_attack_2' => 4,
            'count_attack_3' => 5,
            'count_attack_4' => 1,
            'items' => [
                'Teostra Claw' => 1,
                'Teostra Mane' => 1,
                'Teostra Carapace' => 2,
                'Teostra Powder' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Hilt Stab' => 3,
                ],
                'add' => [
                    'Boom Box' => 3,
                ],
            ],
        ],
        'Teostra\'s Orphée' => [
            'expansion' => App\Enum\MonsterExpansion::TEOSTRA_EXPANSION,
            'parent' => 'Teostra\'s Triple',
            'branch' => 'Teostra',
            'rarity' => 5,
            'name' => 'Orfeón Teostra',
            'count_attack_2' => 9,
            'count_attack_3' => 4,
            'count_attack_4' => 3,
            'items' => [
                'Teostra Horn' => 3,
                'Teostra Claw' => 2,
                'Teostra Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Hilt Stab' => 3,
                    'Left Swing' => 2,
                ],
                'add' => [
                    'Boom Box' => 3,
                    'Blast Swing' => 2,
                ],
            ],
        ],
        // KUSHALA EXPANSION <NONE>
        // KIRIN EXPANSION
        'Thundercry Horn' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Bone Horn',
            'branch' => 'Kirin',
            'rarity' => 4,
            'name' => 'Cuerno Atronador',
            'song_list' => 'Kirin Song List',
            'has_elemental_attacks' => true,
            'count_attack_1' => 4,
            'count_attack_2' => 3,
            'count_attack_3' => 3,
            'count_attack_4' => 2,
            'items' => [
                'Kirin Thunderhorn' => 3,
                'Kirin Hide' => 3,
                'Kirin Tail' => 1,
                'Lightcrystal' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Left Swing' => 2,
                ],
                'add' => [
                    'Charged Swing' => 2,
                ],
            ],
        ],
        'Thunderbolt Horn' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Thundercry Horn',
            'branch' => 'Kirin',
            'rarity' => 5,
            'name' => 'Cuerno Relámpago',
            'song_list' => 'Kirin Song List',
            'has_elemental_attacks' => true,
            'count_attack_1' => 4,
            'count_attack_2' => 3,
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
                    'Left Swing' => 2,
                    'Overhead Smash' => 2,
                ],
                'add' => [
                    'Charged Swing' => 2,
                    'Thunder Crack' => 2,
                ],
            ],
        ],
    ],
];
