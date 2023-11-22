<?php

return [
    'name' => [
        'en' => 'Sword & Shield',
        'es' => 'Espada y Escudo',
    ],
    'image' => 'icon_weapon_03.png',
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Hunter\'s Knife',
                'es' => 'Cuchillo de cazador',
            ],
            'count_attack_1' => 8,
            'count_attack_2' => 2,
        ],
        // ANCIENT FOREST
        // WILDSPIRE WASTE
        // KULU YA KU EXPANSION
        // TEOSTRA EXPANSION
        [
            'parent' => 'Hunter\'s Knife',
            'branch' => 'Teostra',
            'rarity' => 4,
            'name' => [
                'en' => 'Teostra\'s Spada',
                'es' => 'Spada Teostra',
            ],
            'defense' => 1,
            'count_attack_2' => 4,
            'count_attack_3' => 7,
            'count_attack_4' => 3,
            'items' => [
                'Teostra Claw' => 1,
                'Teostra Mane' => 1,
                'Teostra Carapace' => 2,
                'Teostra Powder' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Guard Up' => 2,
                    'Any Card' => 1,
                ],
                'add' => [
                    'Teostra\'s Guard' => 3,
                ],
            ],
        ],
        [
            'parent' => 'Teostra\'s Spada',
            'branch' => 'Teostra',
            'rarity' => 5,
            'name' => [
                'en' => 'Teostra\'s Emblem',
                'es' => 'Emblema Teostra',
            ],
            'defense' => 1,
            'count_attack_2' => 7,
            'count_attack_3' => 5,
            'count_attack_4' => 3,
            'count_attack_5' => 1,
            'items' => [
                'Teostra Horn' => 3,
                'Teostra Claw' => 2,
                'Teostra Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Guard Up' => 2,
                    'Any Card' => 4,
                ],
                'add' => [
                    'Teostra\'s Guard' => 3,
                    'Fearsome Slice' => 3,
                ],
            ],
        ],
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Hunter\'s Knife',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Jack',
                'es' => 'Jack Nergal',
            ],
            'defense' => 1,
            'count_attack_2' => 5,
            'count_attack_3' => 4,
            'count_attack_4' => 3,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Guard Up' => 2,
                ],
                'add' => [
                    'Scaled Guard' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Nergal Jack',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Eradication Vanguard',
                'es' => 'Vanguardia Erradicadora',
            ],
            'defense' => 1,
            'has_elemental_attacks' => true,
            'count_attack_2' => 5,
            'count_attack_3' => 5,
            'count_attack_4' => 3,
            'count_attack_5' => 1,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Guard Up' => 2,
                    'Chop' => 2,
                ],
                'add' => [
                    'Scaled Guard' => 2,
                    'Draconic Slash' => 2,
                ],
            ],
        ],
        // KUSHALA EXPANSION
    ],
];
