<?php

return [
    'name' => [
        'en' => 'Switch Axe',
        'es' => 'Hacha Espada',
    ],
    'description' => [
        'en' => 'During set up, divide the Axe :switch_axe_axe_icon: and Sword :switch_axe_sword_icon: attack cards into two separate attack decks. Axe and Sword symbols are located on the back of the switch axe hunter\'s attack cards.<br>
When you draw attack cards you may choose any number of cards from either attack deck, up your hand size of 5. Axe and Sword attack cards each have their own discard piles.',
        'es' => 'Durante la configuración, divide las cartas de ataque Hacha :switch_axe_axe_icon: y Espada :switch_axe_sword_icon: en dos mazos de ataque separados. Los símbolos de hacha y espada se encuentran en la parte posterior de las cartas de ataque del cazador de hachas.<br>
Cuando robas cartas de ataque, puedes elegir cualquier cantidad de cartas de cualquier mazo de ataque, hasta que el tamaño de tu mano sea 5. Las cartas de ataque de Hacha y Espada tienen cada una sus propias pilas de descarte.',
    ],
    'image' => 'icon_weapon_09.png',
    'weapons' => [
        [
            'default' => true,
            'branch' => 'mineral',
            'name' => [
                'en' => 'Proto Iron Axe',
                'es' => 'Protohacha Férrea',
            ],
            'count_attack_1' => 11,
            'count_attack_2' => 1,
        ],
        // ANCIENT FOREST
        // WILDSPIRE WASTE
        // KULU YA KU EXPANSION
        // TEOSTRA EXPANSION
        [
            'parent' => 'Proto Iron Axe',
            'branch' => 'Teostra',
            'rarity' => 4,
            'name' => [
                'en' => 'Teostra\'s Arx',
                'es' => 'Arx Teostra',
            ],
            'count_attack_1' => 6,
            'count_attack_3' => 2,
            'count_attack_4' => 5,
            'count_attack_5' => 1,
            'items' => [
                'Teostra Claw' => 1,
                'Teostra Mane' => 1,
                'Teostra Carapace' => 2,
                'Teostra Powder' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Wild Swing' => 4,
                ],
                'add' => [
                    'Concussive Swing' => 4,
                ],
            ],
        ],
        [
            'parent' => 'Teostra\'s Arx',
            'branch' => 'Teostra',
            'rarity' => 5,
            'name' => [
                'en' => 'Teostra\'s Castle',
                'es' => 'Castillo Teostra',
            ],
            'count_attack_1' => 8,
            'count_attack_4' => 6,
            'count_attack_5' => 2,
            'items' => [
                'Teostra Horn' => 3,
                'Teostra Claw' => 2,
                'Teostra Gem' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Wild Swing' => 4,
                    'Heavenward Flurry' => 2,
                ],
                'add' => [
                    'Concussive Swing' => 4,
                    'Explosive Flurry' => 2,
                ],
            ],
        ],
        // NERGIGANTE EXPANSION
        [
            'parent' => 'Proto Iron Axe',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => [
                'en' => 'Nergal Gash',
                'es' => 'Gash Nergal',
            ],
            'has_elemental_attacks' => true,
            'count_attack_1' => 5,
            'count_attack_3' => 4,
            'count_attack_4' => 2,
            'count_attack_5' => 1,
            'items' => [
                'Nergigante Talon' => 1,
                'Nergigante Regrowth Plate' => 1,
                'Nergigante Tail' => 2,
                'Nergigante Carapace' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Side Slash' => 2,
                ],
                'add' => [
                    'Claw Slash' => 2,
                ],
            ],
        ],
        [
            'parent' => 'Nergal Gash',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => [
                'en' => 'Dying Light',
                'es' => 'Luz Perecedera',
            ],
            'has_elemental_attacks' => true,
            'count_attack_1' => 7,
            'count_attack_3' => 1,
            'count_attack_4' => 3,
            'count_attack_5' => 3,
            'items' => [
                'Nergigante Horn' => 4,
                'Nergigante Talon' => 3,
                'Nergigante Gem' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Side Slash' => 2,
                    'Side Rising Slash' => 2,
                ],
                'add' => [
                    'Claw Slash' => 2,
                    'Dragon Rising Slash' => 2,
                ],
            ],
        ],
        // KUSHALA EXPANSION
    ],
];
