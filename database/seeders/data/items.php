<?php

use App\Enum\ItemType;

return [
    ItemType::COMMON->name => [
        'Carbalite Ore' => 'Carbalita',
        'Machalite Ore' => 'Machalita',
        'Dragonite Ore' => 'Dragonita',
        'Fucium Ore' => 'Fucium',
        'Quality Bone' => 'Hueso Escogido',
        'Monster Bone Small' => 'Hueso Monstruo Pequeño',
        'Monster Bone Medium' => 'Hueso Monstruo Mediano',
        'Monster Bone Large' => 'Hueso Monstruo Grande',
        'Monster Keenbone' => 'Hueso Afilado',
        'Monster Hardbone' => 'Hueso Escudo',
        'Ancient Bone' => 'Hueso Antiguo',
        'Boulder Bone' => 'Hueso Fósil',
        'Dragonvein Crystal' => 'Cristal de Dracovena',
        'Wingdrake Hide' => 'Piel de Dracoalado',
        'Coral Bone' => 'Hueso de Coral',
    ],
    ItemType::OTHER->name => [
        'Firecell Stone' => 'Piedra de Lava',
        'Warm Pelt' => 'Piel Cálida',
        'Fertile Mud' => 'Barro Fértil',
        'Gajau Scale' => 'Escama de Gajau',
        'Sharp Claw' => 'Garra Afilada',
        'Piercing Claw' => 'Garra Perforante',
        'Coral Crystal' => 'Cristal Coralino',
        'Lightcrystal' => 'Cristal Reluciente',
        'Novacrystal' => 'Novacristal',
        'Earth Crystal' => 'Cristal de Tierra',
        'Elder Dragon Bone' => 'Hueso de Dragón Anciano',
        'Elder Dragon Blood' => 'Sangre de Dragón Anciano',
    ],
    ItemType::MONSTER_PART->name => [
        // Great Jagras
        'Great Jagras Hide' => 'Piel de Gran Jagras',
        'Great Jagras Mane' => 'Melena de Gran Jagras',
        'Great Jagras Claw' => 'Garra de Gran Jagras',
        'Great Jagras Scale' => 'Escama de Gran Jagras',

        // Tobi-Kadachi
        'Tobi-Kadachi Pelt' => 'Piel de Tobi-Kadachi',
        'Tobi-Kadachi Claw' => 'Garra de Tobi-Kadachi',
        'Tobi-Kadachi Membrane' => 'Membrana de Tobi-Kadachi',
        'Tobi-Kadachi Scale' => 'Escama de Tobi-Kadachi',
        'Tobi-Kadachi Electrode' => 'Electrodo de Tobi-Kadachi',
        'Electro Sac' => 'Vesícula Eléctrica',
        'Thunder Sac' => 'Vesícula de Rayo',

        // Anjanath
        'Anjanath Pelt' => 'Piel de Anjanath',
        'Anjanath Scale' => 'Escama de Anjanath',
        'Anjanath Tail' => 'Cola de Anjanath',
        'Anjanath Fang' => 'Colmillo de Anjanath',
        'Anjanath Nosebone' => 'Hueso Nasal de Anjanath',

        // Rathalos
        'Rathalos Scale' => 'Escama de Rathalos',
        'Rathalos Shell' => 'Caparazón de Rathalos',
        'Rathalos Marrow' => 'Tuétano de Rathalos',
        'Rathalos Webbing' => 'Membrana de Rathalos',
        'Rathalos Plate' => 'Placa de Rathalos',
        'Rathalos Wingtalon' => 'Garra de Rathalos',
        'Rathalos Tail' => 'Cola de Rathalos',
        'Rathalos Wing' => 'Ala de Rathalos',
        'Rathalos Carapace' => 'Coraza de Rathalos',
        'Rathalos Medulla' => 'Médula de Rathalos',
        'Flame Sac' => 'Vesícula Flamígera',
        'Inferno Sac' => 'Vesícula Infernal',

        // Azure Rathalos
        'Azure Rathalos Scale' => 'Escama de Rathalos Celeste',
        'Azure Rathalos Carapace' => 'Coraza de Rathalos Celeste',
        'Azure Rathalos Marrow' => 'Tuétano de Rathalos Celeste',
        'Azure Rathalos Wing' => 'Ala de Rathalos Celeste',
        'Azure Rathalos Plate' => 'Placa de Rathalos Celeste',
        'Azure Rathalos Wingtalon' => 'Garra de Rathalos Celeste',
        'Azure Rathalos Tail' => 'Cola de Rathalos Celeste',

        // Barroth
        'Barroth Ridge' => 'Cresta de Barroth',
        'Barroth Tail' => 'Cola de Barroth',
        'Barroth Claw' => 'Garra de Barroth',
        'Barroth Carapace' => 'Coraza de Barroth',
        'Barroth Shell' => 'Caparazón de Barroth',

        // Pukei-Pukei
        'Pukei-Pukei Carapace' => 'Coraza de Pukei-Pukei',
        'Pukei-Pukei Tail' => 'Cola de Pukei-Pukei',
        'Pukei-Pukei Wing' => 'Ala de Pukei-Pukei',
        'Pukei-Pukei Scale' => 'Escama de Pukei-Pukei',
        'Pukei-Pukei Sac' => 'Saco de Pukei-Pukei',
        'Pukei-Pukei Quill' => 'Péndola de Pukei-Pukei',
        'Poison Sac' => 'Vesícula de Veneno',
        'Toxic Sac' => 'Vesícula Tóxica',

        // Jyuratodus
        'Jyuratodus Scale' => 'Escama de Jyuratodus',
        'Jyuratodus Carapace' => 'Coraza de Jyuratodus',
        'Jyuratodus Fin' => 'Aleta de Jyuratodus',
        'Jyuratodus Fang' => 'Colmillo de Jyuratodus',
        'Jyuratodus Shell' => 'Caparazón de Jyuratodus',
        'Aqua Sac' => 'Vesícula Acuosa',
        'Torrent Sac' => 'Vesícula Torrencial',

        // Diablos
        'Diablos Ridge' => 'Cresta de Diablos',
        'Diablos Fang' => 'Colmillo de Diablos',
        'Diablos Carapace' => 'Coraza de Diablos',
        'Diablos Shell' => 'Caparazón de Diablos',
        'Majestic Horn' => 'Cuerno Majestuoso',
        'Twisted Horn' => 'Cuerno Retorcido',
        'Blos Medulla' => 'Médula de Blos',

        // Black Diablos
        'Black Diablos Ridge' => 'Cresta de Diablos Negra',
        'Black Diablos Carapace' => 'Coraza de Diablos Negra',
        'Black Spiral Horn' => 'Colmillo Negro en Espiral',

        'Wyvern Gem' => 'Gema de Wyvern',
        'Bird Wyvern Gem' => 'Gema de Wyvern Pájaro',
        'Fire Dragon Scale' => 'Escama de Dragón de Fuego',

        // Kulu-Ya-Ku
        'Kulu-Ya-Ku Scale' => 'Escama de Kulu-Ya-Ku',
        'Kulu-Ya-Ku Hide' => 'Piel de Kulu-Ya-Ku',
        'Kulu-Ya-Ku Plume' => 'Pluma de Kulu-Ya-Ku',
        'Kulu-Ya-Ku Beak' => 'Pico de Kulu-Ya-Ku',

        // Nergigante
        'Nergigante Horn' => 'Cuerno de Nergigante',
        'Nergigante Carapace' => 'Coraza de Nergigante',
        'Nergigante Talon' => 'Garra de Nergigante',
        'Nergigante Tail' => 'Cola de Nergigante',
        'Nergigante Gem' => 'Gema de Nergigante',
        'Nergigante Regrowth Plate' => 'Placa Regeneración Nergigante',
        'Immortal Dragonscale' => 'Escama de Dragón Inmortal',

        // Teostra
        'Teostra Claw' => 'Garra de Teostra',
        'Teostra Mane' => 'Crin de Teostra',
        'Teostra Carapace' => 'Coraza de Teostra',
        'Teostra Powder' => 'Polvo de Teostra',
        'Teostra Horn' => 'Cuerno de Teostra',
        'Teostra Tail' => 'Cola de Teostra',
        'Teostra Webbing' => 'Membrana de Teostra',
        'Teostra Gem' => 'Gema de Teostra',

        // Kushala Daora
        'Daora Dragon Scale' => 'Escama Dragoniana de Daora',
        'Daora Carapace' => 'Coraza de Daora',
        'Daora Claw' => 'Garra de Daora',
        'Daora Webbing' => 'Membrana de Daora',
        'Daora Tail' => 'Cola de Daora',
        'Daora Horn' => 'Cuerno de Daora',
        'Daora Gem' => 'Gema de Daora',

        // Kirin
        'Kirin Thunderhorn' => 'Cuerno Rayo de Kirin',
        'Kirin Hide' => 'Piel de Kirin',
        'Kirin Tail' => 'Cola de Kirin',
        'Kirin Azure Horn' => 'Cuerno de Kirin Celeste',
        'Kirin Mane' => 'Crin de Kirin',
    ],
];
