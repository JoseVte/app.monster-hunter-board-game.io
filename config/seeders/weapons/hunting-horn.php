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
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Metal Bagpipe',
                'es' => 'Gaita Metálica',
            ],
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
        // WILDSPIRE WASTE
        [
            'parent' => 'Bone Horn',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
            'name' => [
                'en' => 'Blooming Horn',
                'es' => 'Cuerno Floral',
            ],
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
