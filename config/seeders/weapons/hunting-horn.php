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
                'es' => '',
            ],
            'description' => [
                'en' => 'Only this hunter is affected. When this hunter walks, they move up to nodes instead of 1.',
                'es' => '',
            ],
        ],
        [
            'name' => [
                'en' => 'Attack Up',
                'es' => '',
            ],
            'description' => [
                'en' => 'The next time each affected hunter inflicts damage, they draw +2 :damage_attack_icon:.',
                'es' => '',
            ],
        ],
        [
            'name' => [
                'en' => 'Defence Up',
                'es' => '',
            ],
            'description' => [
                'en' => 'Each affected hunter gains +1 :defense_icon:.',
                'es' => '',
            ],
        ],
        [
            'name' => [
                'en' => 'Health Recovery',
                'es' => '',
            ],
            'description' => [
                'en' => 'The next time each affected hunter takes a turn, they recover 2 lost health.',
                'es' => '',
            ],
        ],
        [
            'name' => [
                'en' => 'Earplugs',
                'es' => '',
            ],
            'description' => [
                'en' => 'Each affected hunter may immediately discard 1 attack card from their hand to move up to 2 nodes.',
                'es' => '',
            ],
        ],
        [
            'name' => [
                'en' => 'Stamina Use Reduced',
                'es' => '',
            ],
            'description' => [
                'en' => 'The next time each affected hunter plays an attack card onto their stamina board, they may discard it.',
                'es' => '',
            ],
        ],
        [
            'name' => [
                'en' => 'Environment Effects Negated',
                'es' => '',
            ],
            'description' => [
                'en' => 'Each affected hunter ignores the effects of pond nodes.',
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
    ],
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Metal Bagpipe',
                'es' => 'Gaita Metálica',
            ],
            'song_list' => 'Ore Song List',
            'count_attack_1' => 10,
            'count_attack_2' => 2,
        ],
        [
            'parent' => 'Metal Bagpipe',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => [
                'en' => 'Great Bagpipe',
                'es' => 'Gaita Mayor',
            ],
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
        [
            'parent' => 'Great Bagpipe',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => [
                'en' => 'Fortissimo',
                'es' => 'Fortissimo',
            ],
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
        [
            'branch' => 'bone',
            'name' => [
                'en' => 'Bone Horn',
                'es' => 'Cuerno Óseo',
            ],
            'song_list' => 'Bone Song List',
            'count_attack_1' => 7,
            'count_attack_2' => 3,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        [
            'parent' => 'Bone Horn',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => [
                'en' => 'Hard Bone Horn',
                'es' => 'Cuerno Hueso Pétreo',
            ],
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
        [
            'parent' => 'Hard Bone Horn',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => [
                'en' => 'Heavy Bone Horn',
                'es' => 'Cuerno Hueso Pesado',
            ],
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
        [
            'parent' => 'Bone Horn',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
            'name' => [
                'en' => 'Thunder Gaida',
                'es' => 'Gaita Trueno',
            ],
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
        [
            'parent' => 'Thunder Gaida',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 4,
            'name' => [
                'en' => 'Lightning Drm',
                'es' => 'Tambor Relámpago',
            ],
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
        [
            'parent' => 'Metal Bagpipe',
            'branch' => 'Anjanath',
            'rarity' => 3,
            'name' => [
                'en' => 'Blazing Horn',
                'es' => 'Cuerno Flameante',
            ],
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
        [
            'parent' => 'Blazing Horn',
            'branch' => 'Anjanath',
            'rarity' => 4,
            'name' => [
                'en' => 'Anja Barone',
                'es' => 'Barone Anja',
            ],
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
        [
            'parent' => 'Bone Horn',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
            'name' => [
                'en' => 'Blooming Horn',
                'es' => 'Cuerno Floral',
            ],
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
        [
            'parent' => 'Blooming Horn',
            'branch' => 'Pukei-Pukei',
            'rarity' => 4,
            'name' => [
                'en' => 'Datura Horn',
                'es' => 'Cuerno Datura',
            ],
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
        [
            'parent' => 'Bone Horn',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
            'name' => [
                'en' => 'Aqua Bagpipe',
                'es' => 'Gaita Aqua',
            ],
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
        [
            'parent' => 'Aqua Bagpipe',
            'branch' => 'Jyuratodus',
            'rarity' => 4,
            'name' => [
                'en' => 'Water Tamtam',
                'es' => 'Tamtam Acuático',
            ],
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
        [
            'parent' => 'Metal Bagpipe',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 3,
            'name' => [
                'en' => 'Kulu Duda',
                'es' => 'Duta Kulu',
            ],
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
        [
            'parent' => 'Kulu Duda',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 4,
            'name' => [
                'en' => 'Dancing Duval',
                'es' => 'Davul Danzante',
            ],
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
        // TEOSTRA EXPANSION
        [
            'parent' => 'Metal Bagpipe',
            'branch' => 'Teostra',
            'rarity' => 4,
            'name' => [
                'en' => 'Teostra\'s Triple',
                'es' => 'Triple Teostra',
            ],
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
        [
            'parent' => 'Teostra\'s Triple',
            'branch' => 'Teostra',
            'rarity' => 5,
            'name' => [
                'en' => 'Teostra\'s Orphée',
                'es' => 'Orfeón Teostra',
            ],
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
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Metal Bagpipe',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Groove',
                'es' => 'Groove Nergal',
            ],
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
        [
            'parent' => 'Nergal Groove',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Desolation\'s Overture',
                'es' => 'Apertura de Desolación',
            ],
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
        // KUSHALA EXPANSION
    ],
];
