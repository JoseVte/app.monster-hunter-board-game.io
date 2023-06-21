<?php

return [
    [
        'name' => 'Great Sword',
        'description' => '',
        'image' => 'icon_weapon_01.png',
        'weapons' => [
            [
                'default' => true,
                'branch' => 'mineral',
                'name' => 'Buster Sword',
                'count_attack_1' => 7,
                'count_attack_2' => 4,
                'count_attack_3' => 1,
            ],
            [
                'parent' => 'Buster Sword',
                'branch' => 'mineral',
                'rarity' => 2,
                'name' => 'Buster Blade',
                'count_attack_1' => 4,
                'count_attack_2' => 6,
                'count_attack_3' => 2,
                'items' => [
                    'Dragonite Ore' => 1,
                    'Machalite Ore' => 1,
                    'Monster Bone Medium' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Jumping Slash' => 2,
                    ],
                    'add' => [
                        'Enhanced Jumping Slash' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Buster Blade',
                'branch' => 'mineral',
                'rarity' => 3,
                'name' => 'Chrome Razor',
                'count_attack_1' => 2,
                'count_attack_2' => 6,
                'count_attack_3' => 4,
                'items' => [
                    'Fucium Ore' => 2,
                    'Carbalite Ore' => 2,
                    'Dragonite Ore' => 3,
                    'Dragonvein Crystal' => 2,
                ],
                'attacks' => [
                    'remove' => [
                        'Jumping Slash' => 2,
                        'Wide Slash' => 2,
                    ],
                    'add' => [
                        'Enhanced Jumping Slash' => 2,
                        'Heavy Slice' => 2,
                    ],
                ],
            ],
            [
                'branch' => 'bone',
                'name' => 'Bone Blade',
                'count_attack_1' => 5,
                'count_attack_2' => 3,
                'count_attack_3' => 2,
                'items' => [
                    'Monster Bone Small' => 1,
                ],
            ],
            [
                'parent' => 'Bone Blade',
                'branch' => 'bone',
                'rarity' => 2,
                'name' => 'Bone Slasher',
                'count_attack_1' => 2,
                'count_attack_2' => 5,
                'count_attack_3' => 3,
                'items' => [
                    'Monster Bone Large' => 1,
                    'Monster Bone Medium' => 1,
                    'Boulder Bone' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Any Card' => 1,
                    ],
                    'add' => [
                        'Greater Sword Block' => 1,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Slasher',
                'branch' => 'bone',
                'rarity' => 3,
                'name' => 'Giant Jawblade',
                'count_attack_1' => 2,
                'count_attack_2' => 4,
                'count_attack_3' => 4,
                'items' => [
                    'Monster Hardbone' => 2,
                    'Monster Keenbone' => 2,
                    'Quality Bone' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'Any Card' => 1,
                        'Overhead Slam' => 4,
                    ],
                    'add' => [
                        'Greater Sword Block' => 1,
                        'Enhanced Overhead Slam' => 4,
                    ],
                ],
            ],
            [
                'parent' => 'Buster Sword',
                'branch' => 'Great Jagras',
                'rarity' => 3,
                'name' => 'Jagras Blade',
                'count_attack_2' => 6,
                'count_attack_3' => 5,
                'count_attack_4' => 1,
                'items' => [
                    'Great Jagras Claw' => 2,
                    'Great Jagras Hide' => 1,
                    'Great Jagras Scale' => 2,
                    'Sharp Claw' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Rising Slash' => 3,
                    ],
                    'add' => [
                        'Strong Rising Slash' => 3,
                    ],
                ],
            ],
            [
                'parent' => 'Jagras Blade',
                'branch' => 'Great Jagras',
                'rarity' => 4,
                'name' => 'Jagras Hacker',
                'count_attack_2' => 3,
                'count_attack_3' => 9,
                'count_attack_4' => 2,
                'items' => [
                    'Great Jagras Scale' => 2,
                    'Great Jagras Claw' => 2,
                    'Great Jagras Mane' => 2,
                    'Piercing Claw' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Rising Slash' => 3,
                        'Any Card' => 2,
                    ],
                    'add' => [
                        'Strong Rising Slash' => 3,
                        'Strong Charge Up' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Buster Sword',
                'branch' => 'Rathalos',
                'rarity' => 3,
                'name' => 'Flame Blade',
                'has_elemental_attacks' => true,
                'count_attack_2' => 5,
                'count_attack_3' => 5,
                'count_attack_4' => 2,
                'items' => [
                    'Rathalos Scale' => 2,
                    'Rathalos Webbing' => 2,
                    'Inferno Sac' => 1,
                    'Rathalos Marrow' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Overhead Slam' => 4,
                    ],
                    'add' => [
                        'Blazing Slam' => 4,
                    ],
                ],
            ],
            [
                'parent' => 'Flame Blade',
                'branch' => 'Rathalos',
                'rarity' => 4,
                'name' => 'Red Wing',
                'defense' => 1,
                'has_elemental_attacks' => true,
                'count_attack_2' => 5,
                'count_attack_3' => 6,
                'count_attack_4' => 3,
                'items' => [
                    'Rathalos Scale' => 2,
                    'Rathalos Carapace' => 2,
                    'Rathalos Wing' => 2,
                    'Rathalos Medulla' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Overhead Slam' => 4,
                        'Wide Slash' => 2,
                    ],
                    'add' => [
                        'Blazing Slam' => 4,
                        'Crushing Slash' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Blade',
                'branch' => 'Barroth',
                'rarity' => 3,
                'name' => 'Carapace Buster',
                'count_attack_2' => 5,
                'count_attack_3' => 4,
                'count_attack_4' => 1,
                'items' => [
                    'Barroth Claw' => 1,
                    'Barroth Shell' => 3,
                    'Barroth Ridge' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'Great Sword Block' => 2,
                    ],
                    'add' => [
                        'Empowered Great Sword Block' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Carapace Buster',
                'branch' => 'Barroth',
                'rarity' => 4,
                'name' => 'Barroth Shredder',
                'count_attack_2' => 6,
                'count_attack_3' => 4,
                'count_attack_4' => 2,
                'items' => [
                    'Barroth Claw' => 2,
                    'Barroth Carapace' => 3,
                    'Barroth Ridge' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'Great Sword Block' => 2,
                        'Any Card' => 2,
                    ],
                    'add' => [
                        'Empowered Great Sword Block' => 2,
                        'Paralysing Slash' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Buster Sword',
                'branch' => 'Pukei-Pukei',
                'rarity' => 3,
                'name' => 'Blooming Blade',
                'count_attack_2' => 5,
                'count_attack_3' => 6,
                'count_attack_4' => 1,
                'items' => [
                    'Pukei-Pukei Quill' => 2,
                    'Pukei-Pukei Scale' => 2,
                    'Poison Sac' => 1,
                    'Pukei-Pukei Tail' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'True Charged Slash' => 2,
                    ],
                    'add' => [
                        'Toxic Charged Slash' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Blooming Blade',
                'branch' => 'Pukei-Pukei',
                'rarity' => 4,
                'name' => 'Datura Blaze',
                'defense' => 1,
                'count_attack_2' => 3,
                'count_attack_3' => 8,
                'count_attack_4' => 3,
                'items' => [
                    'Pukei-Pukei Scale' => 2,
                    'Pukei-Pukei Wing' => 2,
                    'Toxic Sac' => 2,
                    'Quality Bone' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'True Charged Slash' => 2,
                        'Charge Up' => 2,
                    ],
                    'add' => [
                        'Toxic Charged Slash' => 2,
                        'Poisoned Charge Up' => 2,
                    ],
                ],
            ],
        ],
    ],
    [
        'name' => 'Lance',
        'description' => 'After you resolve an attack card, if there are at least 3 face up attack cards with __lance_icon__ on your stamina board you may discard 3 face up attack cards with __lance_icon__ from your stamina board.',
        'image' => 'icon_weapon_07.png',
        'weapons' => [
            [
                'default' => true,
                'branch' => 'mineral',
                'name' => 'Iron Lance',
                'defense' => 1,
                'count_attack_1' => 8,
                'count_attack_2' => 2,
            ],
            [
                'parent' => 'Iron Lance',
                'branch' => 'mineral',
                'rarity' => 2,
                'name' => 'Steel Lance',
                'defense' => 1,
                'count_attack_1' => 6,
                'count_attack_2' => 6,
                'items' => [
                    'Dragonite Ore' => 1,
                    'Machalite Ore' => 1,
                    'Monster Bone Medium' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Mid Thrust' => 3,
                    ],
                    'add' => [
                        'Long Thrust' => 3,
                    ],
                ],
            ],
            [
                'parent' => 'Steel Lance',
                'branch' => 'mineral',
                'rarity' => 3,
                'name' => 'Chrome Lance',
                'defense' => 1,
                'count_attack_1' => 4,
                'count_attack_2' => 6,
                'count_attack_3' => 2,
                'items' => [
                    'Fucium Ore' => 2,
                    'Carbalite Ore' => 2,
                    'Dragonite Ore' => 3,
                    'Dragonvein Crystal' => 2,
                ],
                'attacks' => [
                    'remove' => [
                        'Mid Thrust' => 3,
                        'Guard Thrust' => 2,
                    ],
                    'add' => [
                        'Long Thrust' => 3,
                        'Long Guard' => 2,
                    ],
                ],
            ],
            [
                'branch' => 'bone',
                'name' => 'Bone Lance',
                'defense' => 1,
                'count_attack_1' => 6,
                'count_attack_2' => 4,
                'items' => [
                    'Monster Bone Small' => 1,
                ],
            ],
            [
                'parent' => 'Bone Lance',
                'branch' => 'bone',
                'rarity' => 2,
                'name' => 'Hard Bone Lance',
                'defense' => 1,
                'count_attack_1' => 4,
                'count_attack_2' => 6,
                'items' => [
                    'Monster Bone Large' => 1,
                    'Monster Bone Medium' => 1,
                    'Boulder Bone' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'High Thrust' => 3,
                    ],
                    'add' => [
                        'High Lunge' => 3,
                    ],
                ],
            ],
            [
                'parent' => 'Hard Bone Lance',
                'branch' => 'bone',
                'rarity' => 3,
                'name' => 'Heavy Bone Lance',
                'defense' => 1,
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
                        'High Thrust' => 3,
                        'Guard Dash' => 2,
                    ],
                    'add' => [
                        'High Lunge' => 3,
                        'Guard Sprint' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Lance',
                'branch' => 'Barroth',
                'rarity' => 3,
                'name' => 'Carapace Lance',
                'defense' => 1,
                'count_attack_1' => 2,
                'count_attack_2' => 5,
                'count_attack_3' => 3,
                'items' => [
                    'Barroth Claw' => 1,
                    'Barroth Shell' => 3,
                    'Barroth Ridge' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'Counter Thrust' => 2,
                    ],
                    'add' => [
                        'Armoured Thrust' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Carapace Lance',
                'branch' => 'Barroth',
                'rarity' => 4,
                'name' => 'Barroth Stinger',
                'defense' => 1,
                'count_attack_2' => 9,
                'count_attack_3' => 3,
                'items' => [
                    'Barroth Claw' => 2,
                    'Barroth Carapace' => 3,
                    'Barroth Ridge' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'Counter Thrust' => 2,
                        'Guard Thrust' => 2,
                    ],
                    'add' => [
                        'Armoured Thrust' => 2,
                        'Armoured Guard' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Lance',
                'branch' => 'Jyuratodus',
                'rarity' => 3,
                'name' => 'Aqua Lance',
                'defense' => 1,
                'has_elemental_attacks' => true,
                'count_attack_1' => 2,
                'count_attack_2' => 4,
                'count_attack_3' => 4,
                'items' => [
                    'Jyuratodus Fin' => 1,
                    'Jyuratodus Shell' => 2,
                    'Jyuratodus Scale' => 3,
                    'Aqua Sac' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'High Thrust' => 3,
                    ],
                    'add' => [
                        'Aqua Thrust' => 3,
                    ],
                ],
            ],
            [
                'parent' => 'Aqua Lance',
                'branch' => 'Jyuratodus',
                'rarity' => 4,
                'name' => 'Water Spike',
                'defense' => 1,
                'has_elemental_attacks' => true,
                'count_attack_1' => 6,
                'count_attack_3' => 6,
                'items' => [
                    'Jyuratodus Fin' => 1,
                    'Jyuratodus Carapace' => 2,
                    'Jyuratodus Scale' => 2,
                    'Aqua Sac' => 1,
                    'Gajau Scale' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'High Thrust' => 3,
                        'Guard Bash' => 2,
                    ],
                    'add' => [
                        'Aqua Thrust' => 3,
                        'Aqua Bash' => 2,
                    ],
                ],
            ],
        ],
    ],
    [
        'name' => 'Gunlance',
        'description' => '',
        'image' => 'icon_weapon_08.png',
        'weapons' => [
            [
                'default' => true,
                'branch' => 'mineral',
                'name' => 'Iron Gunlance',
                'defense' => 1,
                'count_attack_1' => 8,
                'count_attack_2' => 2,
            ],
            [
                'parent' => 'Iron Gunlance',
                'branch' => 'mineral',
                'rarity' => 2,
                'name' => 'Steel Gunlance',
                'defense' => 1,
                'count_attack_1' => 7,
                'count_attack_2' => 4,
                'count_attack_3' => 1,
                'items' => [
                    'Dragonite Ore' => 1,
                    'Machalite Ore' => 1,
                    'Monster Bone Medium' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Full Burst' => 2,
                    ],
                    'add' => [
                        'Improved Full Burst' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Steel Gunlance',
                'branch' => 'mineral',
                'rarity' => 3,
                'name' => 'Chrome Gunlance',
                'defense' => 1,
                'count_attack_1' => 5,
                'count_attack_2' => 4,
                'count_attack_3' => 3,
                'items' => [
                    'Fucium Ore' => 2,
                    'Carbalite Ore' => 2,
                    'Dragonite Ore' => 3,
                    'Dragonvein Crystal' => 2,
                ],
                'attacks' => [
                    'remove' => [
                        'Full Burst' => 2,
                        'Lunging Upthrust' => 2,
                    ],
                    'add' => [
                        'Improved Full Burst' => 2,
                        'Improved Lunging Upthrust' => 2,
                    ],
                ],
            ],
            [
                'branch' => 'bone',
                'name' => 'Bone Gunlance',
                'defense' => 1,
                'count_attack_1' => 5,
                'count_attack_2' => 5,
                'items' => [
                    'Monster Bone Small' => 1,
                ],
            ],
            [
                'parent' => 'Bone Gunlance',
                'branch' => 'bone',
                'rarity' => 2,
                'name' => 'Bone Cannon',
                'defense' => 1,
                'count_attack_1' => 3,
                'count_attack_2' => 6,
                'count_attack_3' => 1,
                'items' => [
                    'Monster Bone Large' => 1,
                    'Monster Bone Medium' => 1,
                    'Boulder Bone' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Charged Shell' => 2,
                    ],
                    'add' => [
                        'Improved Charged Shell' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Cannon',
                'branch' => 'bone',
                'rarity' => 3,
                'name' => 'Great Bone Gunlance',
                'defense' => 1,
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
                        'Charged Shell' => 2,
                        'Overhead Smash' => 2,
                    ],
                    'add' => [
                        'Improved Charged Shell' => 2,
                        'Improved Overhead Smash' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Gunlance',
                'branch' => 'Barroth',
                'rarity' => 3,
                'name' => 'Carapace Cannon',
                'defense' => 1,
                'count_attack_1' => 3,
                'count_attack_2' => 3,
                'count_attack_3' => 4,
                'items' => [
                    'Barroth Claw' => 1,
                    'Barroth Shell' => 3,
                    'Barroth Ridge' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'Wyrmstake Cannon' => 2,
                    ],
                    'add' => [
                        'Brutal Wyrmstake Cannon' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Carapace Cannon',
                'branch' => 'Barroth',
                'rarity' => 4,
                'name' => 'Barroth Blaster',
                'defense' => 1,
                'count_attack_1' => 3,
                'count_attack_2' => 5,
                'count_attack_3' => 3,
                'count_attack_4' => 1,
                'items' => [
                    'Barroth Claw' => 2,
                    'Barroth Carapace' => 3,
                    'Barroth Ridge' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'Wyrmstake Cannon' => 2,
                        'Rising Slash' => 2,
                    ],
                    'add' => [
                        'Brutal Wyrmstake Cannon' => 2,
                        'Crippling Rising Slash' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Iron Gunlance',
                'branch' => 'Jyuratodus',
                'rarity' => 3,
                'name' => 'Madness Gunlance',
                'defense' => 1,
                'has_elemental_attacks' => true,
                'count_attack_1' => 2,
                'count_attack_2' => 7,
                'count_attack_3' => 3,
                'items' => [
                    'Jyuratodus Fin' => 1,
                    'Jyuratodus Shell' => 2,
                    'Jyuratodus Scale' => 3,
                    'Aqua Sac' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Burst' => 2,
                    ],
                    'add' => [
                        'Water Burst' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Madness Gunlance',
                'branch' => 'Jyuratodus',
                'rarity' => 4,
                'name' => 'Jyura Buster',
                'defense' => 1,
                'has_elemental_attacks' => true,
                'count_attack_1' => 2,
                'count_attack_2' => 7,
                'count_attack_3' => 5,
                'items' => [
                    'Jyuratodus Fin' => 1,
                    'Jyuratodus Carapace' => 2,
                    'Jyuratodus Scale' => 2,
                    'Aqua Sac' => 1,
                    'Gajau Scale' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Burst' => 2,
                        'Wyrmstake Cannon' => 2,
                    ],
                    'add' => [
                        'Water Burst' => 2,
                        'Tidal Wyrmstake Cannon' => 2,
                    ],
                ],
            ],
        ],
    ],
    [
        'name' => 'Hammer',
        'description' => '',
        'image' => 'icon_weapon_05.png',
        'weapons' => [
            [
                'default' => true,
                'branch' => 'mineral',
                'name' => 'Iron Hammer',
                'count_attack_1' => 10,
                'count_attack_2' => 1,
                'count_attack_4' => 1,
            ],
            [
                'parent' => 'Iron Hammer',
                'branch' => 'mineral',
                'rarity' => 2,
                'name' => 'Iron Demon',
                'count_attack_1' => 8,
                'count_attack_2' => 2,
                'count_attack_4' => 2,
                'items' => [
                    'Dragonite Ore' => 1,
                    'Machalite Ore' => 1,
                    'Monster Bone Medium' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Rare Steak' => 2,
                    ],
                    'add' => [
                        'Well-Done Steak' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Iron Demon',
                'branch' => 'mineral',
                'rarity' => 3,
                'name' => 'Iron Demon',
                'count_attack_1' => 5,
                'count_attack_2' => 3,
                'count_attack_4' => 3,
                'items' => [
                    'Fucium Ore' => 2,
                    'Carbalite Ore' => 2,
                    'Dragonite Ore' => 3,
                    'Dragonvein Crystal' => 2,
                ],
                'attacks' => [
                    'remove' => [
                        'Rare Steak' => 2,
                        'Upswing' => 2,
                    ],
                    'add' => [
                        'Well-Done Steak' => 2,
                        'Improved Upswing' => 2,
                    ],
                ],
            ],
            [
                'branch' => 'bone',
                'name' => 'Bone Bludgeon',
                'count_attack_1' => 7,
                'count_attack_2' => 2,
                'count_attack_4' => 1,
                'items' => [
                    'Monster Bone Small' => 1,
                ],
            ],
            [
                'parent' => 'Bone Bludgeon',
                'branch' => 'bone',
                'rarity' => 2,
                'name' => 'Fossil Bludgeon',
                'count_attack_1' => 5,
                'count_attack_2' => 3,
                'count_attack_4' => 2,
                'items' => [
                    'Monster Bone Large' => 1,
                    'Monster Bone Medium' => 1,
                    'Boulder Bone' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Charge' => 3,
                    ],
                    'add' => [
                        'Improved Charge' => 3,
                    ],
                ],
            ],
            [
                'parent' => 'Fossil Bludgeon',
                'branch' => 'bone',
                'rarity' => 3,
                'name' => 'Grand Rock',
                'count_attack_1' => 4,
                'count_attack_2' => 3,
                'count_attack_4' => 3,
                'items' => [
                    'Monster Hardbone' => 2,
                    'Monster Keenbone' => 2,
                    'Quality Bone' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'Charge' => 3,
                        'Spinning Bludgeon' => 2,
                    ],
                    'add' => [
                        'Improved Charge' => 3,
                        'Improved Spinning Bludgeon' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Bludgeon',
                'branch' => 'bone',
                'rarity' => 3,
                'name' => 'Blazing Hammer',
                'has_elemental_attacks' => true,
                'count_attack_2' => 8,
                'count_attack_4' => 2,
                'items' => [
                    'Anjanath Fang' => 2,
                    'Anjanath Scale' => 3,
                    'Flame Sac' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Big Bang' => 4,
                    ],
                    'add' => [
                        'Blazing Big Bang' => 4,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Bludgeon',
                'branch' => 'bone',
                'rarity' => 3,
                'name' => 'Blazing Hammer',
                'defense' => 1,
                'has_elemental_attacks' => true,
                'count_attack_2' => 9,
                'count_attack_4' => 3,
                'items' => [
                    'Anjanath Fang' => 4,
                    'Anjanath Scale' => 2,
                    'Inferno Sac' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Big Bang' => 4,
                        'Charged Upswing' => 2,
                    ],
                    'add' => [
                        'Blazing Big Bang' => 4,
                        'Blazing Charged Upswing' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Bludgeon',
                'branch' => 'Barroth',
                'rarity' => 3,
                'name' => 'Carapace Sledge',
                'count_attack_1' => 4,
                'count_attack_2' => 2,
                'count_attack_4' => 4,
                'items' => [
                    'Barroth Claw' => 1,
                    'Barroth Shell' => 4,
                    'Barroth Ridge' => 2,
                ],
                'attacks' => [
                    'remove' => [
                        'Spinning Bludgeon' => 2,
                    ],
                    'add' => [
                        'Brutal Bludgeon' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Carapace Sledge',
                'branch' => 'Barroth',
                'rarity' => 4,
                'name' => 'Barroth Shredder',
                'count_attack_1' => 2,
                'count_attack_2' => 5,
                'count_attack_4' => 5,
                'items' => [
                    'Barroth Claw' => 2,
                    'Barroth Carapace' => 3,
                    'Barroth Ridge' => 2,
                ],
                'attacks' => [
                    'remove' => [
                        'Spinning Bludgeon' => 2,
                        'Charged Brutal Big Bang' => 2,
                    ],
                    'add' => [
                        'Brutal Bludgeon' => 2,
                        'Pulverising Brutal Big Bang' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Iron Hammer',
                'branch' => 'Pukei-Pukei',
                'rarity' => 3,
                'name' => 'Blooming Hammer',
                'count_attack_1' => 1,
                'count_attack_2' => 8,
                'count_attack_4' => 3,
                'items' => [
                    'Pukei-Pukei Quill' => 2,
                    'Pukei-Pukei Scale' => 3,
                    'Poison Sac' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Slide Smash' => 2,
                    ],
                    'add' => [
                        'Poisoned Slide Smash' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Blooming Hammer',
                'branch' => 'Pukei-Pukei',
                'rarity' => 4,
                'name' => 'Buon Fiore',
                'count_attack_1' => 1,
                'count_attack_2' => 9,
                'count_attack_4' => 4,
                'items' => [
                    'Pukei-Pukei Scale' => 3,
                    'Pukei-Pukei Wing' => 2,
                    'Toxic Sac' => 2,
                    'Quality Bone' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'Slide Smash' => 2,
                        'Charged Upswing' => 2,
                    ],
                    'add' => [
                        'Poisoned Slide Smash' => 2,
                        'Poisoned Charged Upswing' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Bludgeon',
                'branch' => 'Diablos',
                'rarity' => 3,
                'name' => 'Diablos Sledge',
                'count_attack_1' => 4,
                'count_attack_2' => 3,
                'count_attack_4' => 5,
                'items' => [
                    'Twisted Horn' => 1,
                    'Diablos Fang' => 2,
                    'Diablos Shell' => 4,
                    'Monster Bone Large' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'Big Bang' => 4,
                    ],
                    'add' => [
                        'Crippling Big Bang' => 4,
                    ],
                ],
            ],
            [
                'parent' => 'Diablos Sledge',
                'branch' => 'Diablos',
                'rarity' => 4,
                'name' => 'Barroth Shredder',
                'defense' => 1,
                'count_attack_1' => 3,
                'count_attack_2' => 5,
                'count_attack_4' => 6,
                'items' => [
                    'Majestic Horn' => 2,
                    'Diablos Carapace' => 2,
                    'Diablos Ridge' => 2,
                    'Blos Medulla' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Big Bang' => 4,
                        'Upswing' => 2,
                    ],
                    'add' => [
                        'Crippling Big Bang' => 4,
                        'Brutal Upswing' => 2,
                    ],
                ],
            ],
        ],
    ],
    [
        'name' => 'Hunting Horn',
        'description' => '',
        'image' => 'icon_weapon_06.png',
        'weapons' => [
            [
                'default' => true,
                'branch' => 'mineral',
                'name' => 'Metal Bagpipe',
                'count_attack_1' => 10,
                'count_attack_2' => 2,
            ],
            [
                'parent' => 'Metal Bagpipe',
                'branch' => 'mineral',
                'rarity' => 2,
                'name' => 'Great Bagpipe',
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
                'name' => 'Fortissimo',
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
                'name' => 'Bone Horn',
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
                'name' => 'Hard Bone Horn',
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
                'name' => 'Heavy Bone Horn',
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
            [
                'parent' => 'Bone Horn',
                'branch' => 'Pukei-Pukei',
                'rarity' => 3,
                'name' => 'Blooming Horn',
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
                'name' => 'Datura Horn',
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
                'name' => 'Aqua Bagpipe',
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
                'name' => 'Water Tamtam',
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
        ],
    ],
    [
        'name' => 'Longsword',
        'description' => 'During setup, place the spirit card next to your stamina board with the white-only side at the top. Your attack cards have a spirit symbol with colours matching sides of the spirit card.<br>
Attack cards will instruct you when to rotate the spirit card, and in which direction. The spirit card is always rotated 90 degrees at a time.<br>
You may only play attack cards wit a spirit symbol if all the colours in the symbol are currently at the rop of the spirit card.<br>
When the white-only spirit symbol is at the top, the spirit card can\'t be rotated anti-clockwise. When the red spirit symbol is at the top, the spirit card can\'t be rotated clockwise.',
        'image' => 'icon_weapon_02.png',
    ],
    [
        'name' => 'Sword & Shield',
        'description' => '',
        'image' => 'icon_weapon_03.png',
    ],
    [
        'name' => 'Dual Blades',
        'description' => '',
        'image' => 'icon_weapon_04.png',
        'weapons' => [
            [
                'default' => true,
                'branch' => 'mineral',
                'name' => 'Matched Slicers',
                'count_attack_1' => 10,
                'count_attack_2' => 2,
            ],
            [
                'parent' => 'Matched Slicers',
                'branch' => 'mineral',
                'rarity' => 2,
                'name' => 'Dual Slicers',
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
                        'Lunging Stab' => 2,
                    ],
                    'add' => [
                        'Enhanced Lunging Stab' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Dual Slicers',
                'branch' => 'mineral',
                'rarity' => 3,
                'name' => 'Chrome Slicers',
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
                        'Lunging Stab' => 2,
                        'Blade Dance' => 4,
                    ],
                    'add' => [
                        'Enhanced Lunging Stab' => 2,
                        'Enhanced Blade Dance' => 4,
                    ],
                ],
            ],
            [
                'branch' => 'bone',
                'name' => 'Bone Hatchets',
                'count_attack_1' => 7,
                'count_attack_2' => 3,
                'items' => [
                    'Monster Bone Small' => 1,
                ],
            ],
            [
                'parent' => 'Bone Hatchets',
                'branch' => 'bone',
                'rarity' => 2,
                'name' => 'Wild Hatchets',
                'count_attack_1' => 5,
                'count_attack_2' => 5,
                'items' => [
                    'Monster Bone Large' => 1,
                    'Monster Bone Medium' => 1,
                    'Boulder Bone' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Double Slash' => 2,
                    ],
                    'add' => [
                        'Impact Double Slash' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Wild Hatchets',
                'branch' => 'bone',
                'rarity' => 3,
                'name' => 'Strong Hatchets',
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
                        'Double Slash' => 2,
                        'Rapid Spin' => 2,
                    ],
                    'add' => [
                        'Impact Double Slash' => 2,
                        'Strong Rapid Spin' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Hatchets',
                'branch' => 'Tobi-Kadachi',
                'rarity' => 3,
                'name' => 'Pulsar Hatchets',
                'has_elemental_attacks' => true,
                'count_attack_1' => 3,
                'count_attack_2' => 4,
                'count_attack_3' => 3,
                'items' => [
                    'Tobi-Kadachi Electrode' => 1,
                    'Tobi-Kadachi Claw' => 2,
                    'Electro Sac' => 2,
                    'Coral Crystal' => 2,
                ],
                'attacks' => [
                    'remove' => [
                        'Bladed Fangs' => 2,
                        'Rapid Spin' => 2,
                    ],
                    'add' => [
                        'Shocking Rush' => 4,
                    ],
                ],
            ],
            [
                'parent' => 'Pulsar Hatchets',
                'branch' => 'Tobi-Kadachi',
                'rarity' => 4,
                'name' => 'Kadachi Claws',
                'has_elemental_attacks' => true,
                'count_attack_1' => 3,
                'count_attack_2' => 4,
                'count_attack_3' => 5,
                'items' => [
                    'Tobi-Kadachi Electrode' => 2,
                    'Tobi-Kadachi Claw' => 2,
                    'Thunder Sac' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Bladed Fangs' => 2,
                        'Rapid Spin' => 2,
                        'Demon Mode' => 2,
                    ],
                    'add' => [
                        'Shocking Rush' => 4,
                        'Enhanced Demon Mode' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Hatchets',
                'branch' => 'Anjanath',
                'rarity' => 3,
                'name' => 'Blazing Hatchets',
                'has_elemental_attacks' => true,
                'count_attack_1' => 3,
                'count_attack_2' => 4,
                'count_attack_3' => 3,
                'items' => [
                    'Anjanath Scale' => 3,
                    'Anjanath Fang' => 2,
                    'Flame Sac' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Six Fold Slash' => 1,
                        'Any Card' => 1,
                    ],
                    'add' => [
                        'Blazing Fold Slash' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Blazing Hatchets',
                'branch' => 'Anjanath',
                'rarity' => 4,
                'name' => 'Anja Cyclone',
                'has_elemental_attacks' => true,
                'count_attack_1' => 3,
                'count_attack_2' => 4,
                'count_attack_3' => 5,
                'items' => [
                    'Anjanath Fang' => 4,
                    'Anjanath Pelt' => 4,
                    'Firecell Stone' => 2,
                ],
                'attacks' => [
                    'remove' => [
                        'Six Fold Slash' => 1,
                        'Any Card' => 1,
                        'Double Slash' => 2,
                    ],
                    'add' => [
                        'Blazing Fold Slash' => 2,
                        'Blazing Double Slash' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Hatchets',
                'branch' => 'Jyuratodus',
                'rarity' => 3,
                'name' => 'Madness Pangas',
                'has_elemental_attacks' => true,
                'count_attack_1' => 2,
                'count_attack_2' => 5,
                'count_attack_3' => 3,
                'items' => [
                    'Jyuratodus Fin' => 1,
                    'Jyuratodus Shell' => 2,
                    'Jyuratodus Scale' => 3,
                    'Aqua Sac' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Blade Dance' => 4,
                    ],
                    'add' => [
                        'Water Dance' => 4,
                    ],
                ],
            ],
            [
                'parent' => 'Madness Pangas',
                'branch' => 'Jyuratodus',
                'rarity' => 4,
                'name' => 'Jyura Hatchets',
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
                        'Blade Dance' => 4,
                        'Rapid Spin' => 2,
                    ],
                    'add' => [
                        'Water Dance' => 4,
                        'Flurry Rush' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Bone Hatchets',
                'branch' => 'Diablos',
                'rarity' => 3,
                'name' => 'Diablos Hatchets',
                'count_attack_1' => 2,
                'count_attack_2' => 6,
                'count_attack_3' => 4,
                'items' => [
                    'Twisted Horn' => 1,
                    'Diablos Fang' => 2,
                    'Diablos Shell' => 4,
                    'Monster Bone Large' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'Double Slash' => 2,
                    ],
                    'add' => [
                        'Brutal Double Slash' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Diablos Hatchets',
                'branch' => 'Diablos',
                'rarity' => 4,
                'name' => 'Diablos Clubs',
                'defense' => 1,
                'count_attack_1' => 2,
                'count_attack_2' => 7,
                'count_attack_3' => 5,
                'items' => [
                    'Majestic Horn' => 2,
                    'Diablos Carapace' => 2,
                    'Diablos Ridge' => 2,
                    'Blos Medulla' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Double Slash' => 2,
                        'Demon Mode' => 2,
                    ],
                    'add' => [
                        'Brutal Double Slash' => 2,
                        'Brutal Demon Mode' => 2,
                    ],
                ],
            ],
        ],
    ],
    [
        'name' => 'Switch Axe',
        'description' => '',
        'image' => 'icon_weapon_09.png',
    ],
    [
        'name' => 'Charge Blade',
        'description' => '',
        'image' => 'icon_weapon_10.png',
    ],
    [
        'name' => 'Insect Glaive',
        'description' => '',
        'image' => 'icon_weapon_11.png',
    ],
    [
        'name' => 'Bow',
        'description' => '',
        'image' => 'icon_weapon_12.png',
        'weapons' => [
            [
                'default' => true,
                'branch' => 'mineral',
                'name' => 'Iron Bow',
                'count_attack_1' => 8,
                'count_attack_2' => 4,
            ],
            [
                'parent' => 'Iron Bow',
                'branch' => 'mineral',
                'rarity' => 2,
                'name' => 'Steel Bow',
                'count_attack_1' => 6,
                'count_attack_2' => 6,
                'items' => [
                    'Dragonite Ore' => 1,
                    'Machalite Ore' => 1,
                    'Monster Bone Medium' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Feint' => 2,
                    ],
                    'add' => [
                        'Skilled Feint' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Steel Bow',
                'branch' => 'mineral',
                'rarity' => 3,
                'name' => 'Alloy Bow',
                'count_attack_1' => 4,
                'count_attack_2' => 6,
                'count_attack_3' => 2,
                'items' => [
                    'Fucium Ore' => 2,
                    'Carbalite Ore' => 2,
                    'Dragonite Ore' => 3,
                    'Dragonvein Crystal' => 2,
                ],
                'attacks' => [
                    'remove' => [
                        'Feint' => 2,
                        'Charge Shot' => 3,
                    ],
                    'add' => [
                        'Skilled Feint' => 2,
                        'Enhanced Charge Shot' => 3,
                    ],
                ],
            ],
            [
                'branch' => 'bone',
                'name' => 'Hunter\'s Bow',
                'count_attack_1' => 6,
                'count_attack_2' => 4,
                'items' => [
                    'Monster Bone Small' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Power Coating' => 4,
                    ],
                    'add' => [
                        'Poison Coating' => 2,
                        'Paralysis Coating' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Hunter\'s Bow',
                'branch' => 'bone',
                'rarity' => 2,
                'name' => 'Hunter\'s Stoutbow',
                'count_attack_1' => 4,
                'count_attack_2' => 6,
                'items' => [
                    'Monster Bone Large' => 1,
                    'Monster Bone Medium' => 1,
                    'Boulder Bone' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Power Coating' => 4,
                        'Shot' => 2,
                    ],
                    'add' => [
                        'Poison Coating' => 2,
                        'Paralysis Coating' => 2,
                        'Enhanced Shot' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Hunter\'s Stoutbow',
                'branch' => 'bone',
                'rarity' => 3,
                'name' => 'Hunter\'s Proudbow',
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
                        'Power Coating' => 4,
                        'Shot' => 2,
                        'Arc Shot' => 2,
                    ],
                    'add' => [
                        'Poison Coating' => 2,
                        'Paralysis Coating' => 2,
                        'Enhanced Shot' => 2,
                        'Strong Arc Shot' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Hunter\'s Bow',
                'branch' => 'Tobi-Kadachi',
                'rarity' => 3,
                'name' => 'Pulsar Bow',
                'has_elemental_attacks' => true,
                'count_attack_1' => 2,
                'count_attack_2' => 5,
                'count_attack_3' => 3,
                'items' => [
                    'Tobi-Kadachi Electrode' => 2,
                    'Tobi-Kadachi Claw' => 2,
                    'Electro Sac' => 1,
                    'Coral Crystal' => 2,
                ],
                'attacks' => [
                    'remove' => [
                        'Power Coating' => 4,
                    ],
                    'add' => [
                        'High Power Coating' => 3,
                        'Paralysis Coating' => 1,
                    ],
                ],
            ],
            [
                'parent' => 'Pulsar Bow',
                'branch' => 'Tobi-Kadachi',
                'rarity' => 4,
                'name' => 'Kadachi Claws',
                'has_elemental_attacks' => true,
                'count_attack_2' => 9,
                'count_attack_3' => 3,
                'items' => [
                    'Tobi-Kadachi Claw' => 2,
                    'Tobi-Kadachi Scale' => 2,
                    'Tobi-Kadachi Pelt' => 2,
                    'Dragonvein Crystal' => 2,
                ],
                'attacks' => [
                    'remove' => [
                        'Power Coating' => 4,
                        'Dragon Piercer' => 1,
                        'Any Card' => 1,
                    ],
                    'add' => [
                        'High Power Coating' => 3,
                        'Paralysis Coating' => 1,
                        'Striking Dragon Piercer' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Hunter\'s Bow',
                'branch' => 'Anjanath',
                'rarity' => 3,
                'name' => 'Blazing Bow',
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
                        'Power Coating' => 4,
                    ],
                    'add' => [
                        'Blast Coating' => 2,
                        'Paralysis Coating' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Blazing Bow',
                'branch' => 'Anjanath',
                'rarity' => 4,
                'name' => 'Anja Cyclone',
                'has_elemental_attacks' => true,
                'count_attack_2' => 6,
                'count_attack_3' => 8,
                'items' => [
                    'Anjanath Fang' => 4,
                    'Anjanath Pelt' => 4,
                    'Firecell Stone' => 2,
                ],
                'attacks' => [
                    'remove' => [
                        'Power Coating' => 4,
                        'Charge Shot' => 3,
                    ],
                    'add' => [
                        'Blast Coating' => 2,
                        'Paralysis Coating' => 2,
                        'Blazing Charge Shot' => 3,
                    ],
                ],
            ],
            [
                'parent' => 'Hunter\'s Bow',
                'branch' => 'Pukei-Pukei',
                'rarity' => 3,
                'name' => 'Blooming Arch',
                'count_attack_1' => 1,
                'count_attack_2' => 7,
                'count_attack_3' => 2,
                'items' => [
                    'Pukei-Pukei Quill' => 2,
                    'Pukei-Pukei Scale' => 3,
                    'Poison Sac' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Power Coating' => 4,
                        'Shot' => 2,
                    ],
                    'add' => [
                        'Poison Coating' => 2,
                        'Paralysis Coating' => 2,
                        'Poisoned Shot' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Blooming Arch',
                'branch' => 'Pukei-Pukei',
                'rarity' => 4,
                'name' => 'Datura String',
                'count_attack_1' => 1,
                'count_attack_2' => 7,
                'count_attack_3' => 4,
                'items' => [
                    'Pukei-Pukei Scale' => 3,
                    'Pukei-Pukei Wing' => 2,
                    'Toxic Sac' => 2,
                    'Quality Bone' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'Power Coating' => 4,
                        'Shot' => 6,
                    ],
                    'add' => [
                        'Poison Coating' => 2,
                        'Paralysis Coating' => 2,
                        'Poisoned Shot' => 2,
                        'Flared' => 4,
                    ],
                ],
            ],
            [
                'parent' => 'Hunter\'s Bow',
                'branch' => 'Diablos',
                'rarity' => 3,
                'name' => 'Diablos Hatchets',
                'count_attack_1' => 4,
                'count_attack_2' => 4,
                'count_attack_3' => 4,
                'items' => [
                    'Twisted Horn' => 1,
                    'Diablos Fang' => 2,
                    'Diablos Shell' => 4,
                    'Monster Bone Large' => 3,
                ],
                'attacks' => [
                    'remove' => [
                        'Power Coating' => 2,
                        'Shot' => 2,
                    ],
                    'add' => [
                        'Paralysis Coating' => 2,
                        'Rending Arrows' => 2,
                    ],
                ],
            ],
            [
                'parent' => 'Diablos Hatchets',
                'branch' => 'Diablos',
                'rarity' => 4,
                'name' => 'Diablos Clubs',
                'count_attack_1' => 2,
                'count_attack_2' => 7,
                'count_attack_3' => 5,
                'items' => [
                    'Majestic Horn' => 2,
                    'Diablos Carapace' => 2,
                    'Diablos Ridge' => 2,
                    'Blos Medulla' => 1,
                ],
                'attacks' => [
                    'remove' => [
                        'Power Coating' => 2,
                        'Shot' => 2,
                        'Charge Sidestep' => 2,
                    ],
                    'add' => [
                        'Paralysis Coating' => 2,
                        'Rending Arrows' => 2,
                        'Rapid Dash' => 2,
                    ],
                ],
            ],
        ],
    ],
    [
        'name' => 'Light Bowgun',
        'description' => '',
        'image' => 'icon_weapon_13.png',
    ],
    [
        'name' => 'Heavy Bowgun',
        'description' => '',
        'image' => 'icon_weapon_14.png',
    ],
];
