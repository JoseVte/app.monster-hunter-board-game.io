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
        'Proto Iron Axe' => [
            'default' => true,
            'branch' => 'mineral',
            'name' => 'Protohacha Férrea',
            'count_attack_1' => 11,
            'count_attack_2' => 4,
        ],
        'Improved Steel Axe' => [
            'parent' => 'Proto Iron Axe',
            'branch' => 'mineral',
            'rarity' => 2,
            'name' => 'Hacha Acerada Ultra',
            'count_attack_1' => 10,
            'count_attack_3' => 1,
            'count_attack_4' => 1,
            'items' => [
                'Dragonite Ore' => 1,
                'Machalite Ore' => 1,
                'Monster Bone Medium' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Overhead Slash' => 2,
                ],
                'add' => [
                    'Enhanced Overhead Slash' => 2,
                ],
            ],
        ],
        'Perfected Alloy Axe' => [
            'parent' => 'Improved Steel Axe',
            'branch' => 'mineral',
            'rarity' => 3,
            'name' => 'Hacha de Aleación',
            'count_attack_1' => 8,
            'count_attack_3' => 1,
            'count_attack_4' => 3,
            'items' => [
                'Fucium Ore' => 2,
                'Carbalite Ore' => 2,
                'Dragonite Ore' => 3,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Overhead Slash' => 2,
                    'Wild Swing' => 4,
                ],
                'add' => [
                    'Enhanced Overhead Slash' => 2,
                    'Savage Swing' => 4,
                ],
            ],
        ],
        'Bone Axe' => [
            'branch' => 'bone',
            'name' => 'Hacha Ósea',
            'count_attack_1' => 8,
            'count_attack_3' => 2,
            'items' => [
                'Monster Bone Small' => 1,
            ],
        ],
        'Bone Smasher' => [
            'parent' => 'Bone Axe',
            'branch' => 'bone',
            'rarity' => 2,
            'name' => 'Machacador Óseo',
            'count_attack_1' => 7,
            'count_attack_3' => 3,
            'items' => [
                'Monster Bone Large' => 1,
                'Monster Bone Medium' => 1,
                'Boulder Bone' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Forward Slash' => 2,
                ],
                'add' => [
                    'Leaping Slash' => 2,
                ],
            ],
        ],
        'Power Smasher' => [
            'parent' => 'Bone Smasher',
            'branch' => 'bone',
            'rarity' => 3,
            'name' => 'Supermachacador',
            'count_attack_1' => 5,
            'count_attack_3' => 4,
            'count_attack_4' => 1,
            'items' => [
                'Monster Hardbone' => 2,
                'Monster Keenbone' => 2,
                'Quality Bone' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Forward Slash' => 2,
                    'Heavenward Flurry' => 2,
                ],
                'add' => [
                    'Leaping Slash' => 2,
                    'Heavenward Combo' => 2,
                ],
            ],
        ],
        // ANCIENT FOREST
        'Flammenebeil' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Bone Axe',
            'branch' => 'Anjanath',
            'rarity' => 3,
            'name' => 'Flammenebeil',
            'has_elemental_attacks' => true,
            'count_attack_1' => 5,
            'count_attack_3' => 3,
            'count_attack_4' => 2,
            'items' => [
                'Anjanath Fang' => 2,
                'Anjanath Scale' => 1,
                'Anjanath Pelt' => 2,
                'Flame Sac' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Forward Slash' => 2,
                ],
                'add' => [
                    'Charging Slash' => 2,
                ],
            ],
        ],
        'Gnashing Flammenebeil' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Flammenebeil',
            'branch' => 'Anjanath',
            'rarity' => 4,
            'name' => 'Flammenebeil Mordiente',
            'has_elemental_attacks' => true,
            'count_attack_1' => 6,
            'count_attack_3' => 3,
            'count_attack_4' => 3,
            'items' => [
                'Anjanath Fang' => 4,
                'Anjanath Pelt' => 4,
                'Firecell Stone' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Forward Slash' => 2,
                    'Overhead Slash' => 2,
                ],
                'add' => [
                    'Charging Slash' => 2,
                    'Blazing Slash' => 2,
                ],
            ],
        ],
        'Rathalos Axe' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Proto Iron Axe',
            'branch' => 'Rathalos',
            'rarity' => 3,
            'name' => 'Hacha Rathalos',
            'has_elemental_attacks' => true,
            'count_attack_1' => 6,
            'count_attack_3' => 4,
            'count_attack_4' => 2,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Webbing' => 2,
                'Inferno Sac' => 1,
                'Rathalos Marrow' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Wild Swing' => 4,
                ],
                'add' => [
                    'Burning Swing' => 4,
                ],
            ],
        ],
        'Rathbringer Axe' => [
            'expansion' => App\Enum\MonsterExpansion::ANCIENT_FOREST,
            'parent' => 'Rathalos Axe',
            'branch' => 'Rathalos',
            'rarity' => 4,
            'name' => 'Rathbringer',
            'has_elemental_attacks' => true,
            'count_attack_1' => 7,
            'count_attack_3' => 3,
            'count_attack_4' => 4,
            'items' => [
                'Rathalos Scale' => 2,
                'Rathalos Carapace' => 1,
                'Rathalos Wing' => 1,
                'Rathalos Medulla' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Wild Swing' => 4,
                    'Heavenward Flurry' => 2,
                ],
                'add' => [
                    'Burning Swing' => 4,
                    'Hellward Flurry' => 2,
                ],
            ],
        ],
        // WILDSPIRE WASTE
        'Carapace Axe' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Axe',
            'branch' => 'Barroth',
            'rarity' => 3,
            'name' => 'Hacha Acorazada',
            'count_attack_1' => 6,
            'count_attack_3' => 3,
            'count_attack_4' => 2,
            'items' => [
                'Barroth Claw' => 1,
                'Barroth Shell' => 4,
                'Barroth Ridge' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Side Slash' => 2,
                ],
                'add' => [
                    'Pulverising Slash' => 2,
                ],
            ],
        ],
        'Barroth Grinder' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Carapace Axe',
            'branch' => 'Barroth',
            'rarity' => 4,
            'name' => 'Trituradora Barroth',
            'has_elemental_attacks' => true,
            'count_attack_1' => 6,
            'count_attack_3' => 4,
            'count_attack_4' => 2,
            'items' => [
                'Barroth Claw' => 2,
                'Barroth Carapace' => 3,
                'Barroth Ridge' => 3,
                'Fertile Mud' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Side Slash' => 2,
                    'Double Slash' => 3,
                ],
                'add' => [
                    'Pulverising Slash' => 2,
                    'Brutal Slash' => 3,
                ],
            ],
        ],
        'Diablos Axe' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Bone Axe',
            'branch' => 'Diablos',
            'rarity' => 3,
            'name' => 'Hacha Diablos',
            'count_attack_1' => 7,
            'count_attack_3' => 2,
            'count_attack_4' => 3,
            'items' => [
                'Twisted Horn' => 1,
                'Diablos Fang' => 2,
                'Diablos Shell' => 4,
                'Monster Bone Large' => 3,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash' => 2,
                ],
                'add' => [
                    'Crippling Slash' => 2,
                ],
            ],
        ],
        'Axe Semper Tyrannis' => [
            'expansion' => App\Enum\MonsterExpansion::WILDSPIRE_WASTE,
            'parent' => 'Diablos Axe',
            'branch' => 'Diablos',
            'rarity' => 4,
            'name' => 'Hacha Semper Tyrannis',
            'count_attack_1' => 8,
            'count_attack_4' => 6,
            'items' => [
                'Majestic Horn' => 2,
                'Diablos Carapace' => 2,
                'Diablos Ridge' => 2,
                'Blos Medulla' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Rising Slash' => 2,
                    'Elemental Discharge' => 1,
                    'Any Sword Card' => 1,
                ],
                'add' => [
                    'Crippling Slash' => 2,
                    'Power Discharge' => 2,
                ],
            ],
        ],
        // KULU YA KU EXPANSION <NONE>
        // NERGIGANTE EXPANSION
        'Nergal Gash' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Proto Iron Axe',
            'branch' => 'Nergigante',
            'rarity' => 4,
            'name' => 'Gash Nergal',
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
        'Dying Light' => [
            'expansion' => App\Enum\MonsterExpansion::NERGIGANTE_EXPANSION,
            'parent' => 'Nergal Gash',
            'branch' => 'Nergigante',
            'rarity' => 5,
            'name' => 'Luz Perecedera',
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
        // TEOSTRA EXPANSION
        'Teostra\'s Arx' => [
            'expansion' => App\Enum\MonsterExpansion::TEOSTRA_EXPANSION,
            'parent' => 'Proto Iron Axe',
            'branch' => 'Teostra',
            'rarity' => 4,
            'name' => 'Arx Teostra',
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
        'Teostra\'s Castle' => [
            'expansion' => App\Enum\MonsterExpansion::TEOSTRA_EXPANSION,
            'parent' => 'Teostra\'s Arx',
            'branch' => 'Teostra',
            'rarity' => 5,
            'name' => 'Castillo Teostra',
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
        // KUSHALA EXPANSION <NONE>
        // KIRIN EXPANSION
        'Peal' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Bone Axe',
            'branch' => 'Kirin',
            'rarity' => 4,
            'name' => 'Zas',
            'has_elemental_attacks' => true,
            'count_attack_1' => 5,
            'count_attack_3' => 5,
            'count_attack_4' => 2,
            'items' => [
                'Kirin Thunderhorn' => 3,
                'Kirin Hide' => 3,
                'Kirin Tail' => 1,
                'Lightcrystal' => 1,
            ],
            'attacks' => [
                'remove' => [
                    'Wild Swing' => 4,
                ],
                'add' => [
                    'Thunderous Swing' => 4,
                ],
            ],
        ],
        'Kirin Thunderpeal' => [
            'expansion' => App\Enum\MonsterExpansion::KIRIN_EXPANSION,
            'parent' => 'Peal',
            'branch' => 'Kirin',
            'rarity' => 5,
            'name' => 'Zas Atronador Kirin',
            'has_elemental_attacks' => true,
            'count_attack_1' => 5,
            'count_attack_3' => 6,
            'count_attack_4' => 3,
            'items' => [
                'Kirin Azure Horn' => 2,
                'Kirin Hide' => 2,
                'Kirin Mane' => 2,
                'Dragonvein Crystal' => 2,
            ],
            'attacks' => [
                'remove' => [
                    'Wild Swing' => 4,
                    'Overhead Slash' => 2,
                ],
                'add' => [
                    'Thunderous Swing' => 4,
                    'Lightning Slash' => 2,
                ],
            ],
        ],
    ],
];
