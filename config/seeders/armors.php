<?php

use App\Enum\ArmorType;

return [
    'skills' => [
        [
            'name' => [
                'en' => 'Poison Resistance',
                'es' => 'Anti Veneno',
            ],
            'description' => [
                'en' => "This hunter can't suffer the :poison_icon: status ailment.",
                'es' => 'Este cazador no puede sufrir el :poison_icon: dolencia de estado.',
            ],
        ],
        [
            'name' => [
                'en' => 'Speed Eating',
                'es' => 'Velocidad al Comer',
            ],
            'description' => [
                'en' => 'Once per quest, this hunter may use combat actions and preparation actions during the same turn.',
                'es' => 'Una vez por misión, este cazador puede utilizar acciones de combate y acciones de preparación durante el mismo turno.',
            ],
        ],
        [
            'name' => [
                'en' => 'Slugger',
                'es' => 'Bonus al Aturdir',
            ],
            'description' => [
                'en' => 'Once per quest, when this hunter uses a :stun_icon: status ailment attack card, place +1 :stun_icon: token.',
                'es' => 'Una vez por misión, cuando este cazador usa una :stun_icon: carta de ataque de afección de estado, coloca +1 :stun_icon: ficha.',
            ],
        ],
        [
            'name' => [
                'en' => 'Palico Rally',
                'es' => 'Mejora de Camarada',
            ],
            'description' => [
                'en' => 'This hunter may use their Palico ability twice per quest.',
                'es' => 'Este cazador puede usar su habilidad Palico dos veces por misión.',
            ],
        ],
        [
            'name' => [
                'en' => 'Constitution',
                'es' => 'Bonus Evasión',
            ],
            'description' => [
                'en' => 'Once per quest when this hunter successfully dodges a monster attack, discard your attack cards instead of placing them on your stamina board.',
                'es' => 'Una vez por misión, cuando este cazador esquive con éxito el ataque de un monstruo, descarta tus cartas de ataque en lugar de colocarlas en tu tablero de resistencia.',
            ],
        ],
        [
            'name' => [
                'en' => 'Evade Extender',
                'es' => 'Distancia de Evasión',
            ],
            'description' => [
                'en' => 'When this hunter successfully dodges a monster attack, they may move 1 additional node.',
                'es' => 'Cuando este cazador esquiva con éxito el ataque de un monstruo, puede mover 1 nodo adicional.',
            ],
        ],
        [
            'name' => [
                'en' => 'Thunder Attack',
                'es' => 'Ataque de Rayo',
            ],
            'description' => [
                'en' => 'When this hunter plays a :thunder_icon: elemental attack, draw +1 :damage_attack_icon:.',
                'es' => 'Cuando este cazador juega un :thunder_icon: ataque elemental, obtiene +1 :damage_attack_icon:.',
            ],
        ],
        [
            'name' => [
                'en' => 'Fire Attack',
                'es' => 'Ataque de Fuego',
            ],
            'description' => [
                'en' => 'When this hunter plays a :fire_icon: elemental attack, draw +1 :damage_attack_icon:.',
                'es' => 'Cuando este cazador juega un :fire_icon: ataque elemental, obtiene +1 :damage_attack_icon:.',
            ],
        ],
        [
            'name' => [
                'en' => 'Marathon Runner',
                'es' => 'Bonus Esprint',
            ],
            'description' => [
                'en' => 'When this hunter walks, they move up to 2 nodes instead of 1.',
                'es' => 'Cuando este cazador camina, se mueven hasta 2 nodos en lugar de 1.',
            ],
        ],
        [
            'name' => [
                'en' => 'Weakness Exploit',
                'es' => 'Bonus Punto Débil',
            ],
            'description' => [
                'en' => 'When you play an attack card with :combo_attack_icon: of 2 or more, draw +1 :damage_attack_icon:.',
                'es' => 'Cuando juegas una carta de ataque con :combo_attack_icon: de 2 o más, roba +1 :damage_attack_icon:.',
            ],
        ],
        [
            'name' => [
                'en' => 'Sleep Resistance',
                'es' => 'Anti Sueño',
            ],
            'description' => [
                'en' => "This hunter can't suffer the :sleep_icon: status ailment.",
                'es' => 'Este cazador no puede sufrir el :sleep_icon: dolencia de estado.',
            ],
        ],
        [
            'name' => [
                'en' => 'Intimidator',
                'es' => 'Intimidador',
            ],
            'description' => [
                'en' => "This hunter can't suffer damage during the gathering phase.",
                'es' => 'Este cazador no puede sufrir daños durante la fase de recolección.',
            ],
        ],
        [
            'name' => [
                'en' => 'Focus',
                'es' => 'Tiempo de Carga',
            ],
            'description' => [
                'en' => 'When this hunter uses an attack card with :combo_attack_icon:, reduce the :combo_attack_icon: value by 1 to a minimum of 1.',
                'es' => 'Cuando este cazador usa una carta de ataque con :combo_attack_icon:, reduce el valor de :combo_attack_icon: en 1 hasta un mínimo de 1.',
            ],
        ],
        [
            'bonus-set' => ['Rathalos Helm', 'Rathalos Mail', 'Rathalos Greaves'],
            'name' => [
                'en' => 'Rathalos Mastery',
                'es' => 'Maestría de Rathalos',
            ],
            'description' => [
                'en' => "When this hunter plays a :fire_icon: elemental attack card, instead of placing an elemental token draw 1 elemental damage card. This doesn't effect monsters with immunity :fire_icon:.",
                'es' => 'Cuando este cazador juega una carta de ataque elemental :fire_icon:, en lugar de colocar una ficha elemental, roba 1 carta de daño elemental. Esto no afecta a los monstruos con inmunidad :fire_icon:.',
            ],
        ],
        [
            'bonus-set' => ['Rath Soul Helm', 'Rath Soul Mail', 'Rath Soul Greaves'],
            'name' => [
                'en' => 'Azure Rathalos Mastery',
                'es' => 'Maestría de Rathalos Celeste',
            ],
            'description' => [
                'en' => 'When this hunter would draw an elemental damage card, draw 3 cards before choosing 1 to resolve.',
                'es' => 'Cuando este cazador robara una carta de daño elemental, roba 3 cartas antes de elegir 1 para resolver.',
            ],
        ],
        [
            'name' => [
                'en' => 'Guard',
                'es' => 'Escudo',
            ],
            'description' => [
                'en' => 'When this hunter plays an attack card that grants additional armour, the card gains +1 :defense_icon:.',
                'es' => 'Cuando este cazador juega una carta de ataque que otorga armadura adicional, la carta gana +1 :defense_icon:.',
            ],
        ],
        [
            'name' => [
                'en' => 'Stun Resistance',
                'es' => 'Anti Aturdimiento',
            ],
            'description' => [
                'en' => "This hunter can't suffer the :stun_icon: status ailment.",
                'es' => 'Este cazador no puede sufrir el :stun_icon: dolencia de estado.',
            ],
        ],
        [
            'name' => [
                'en' => 'Sporepuff Expert',
                'es' => 'Experto en Esporas',
            ],
            'description' => [
                'en' => "When this hunter recovers health from anything that isn't a potion, recover 1 additional health.",
                'es' => 'Cuando este cazador recupere salud de cualquier cosa que no sea una poción, recupera 1 salud adicional.',
            ],
        ],
        [
            'name' => [
                'en' => 'Botanist',
                'es' => 'Experto en Recursos',
            ],
            'description' => [
                'en' => 'During the gathering phase, when the hunters gain a potion they may all immediately recover to full health without spending a potion.',
                'es' => 'Durante la fase de recolección, cuando los cazadores obtienen una poción, todos pueden recuperar inmediatamente su salud completa sin gastar una poción.',
            ],
        ],
        [
            'name' => [
                'en' => 'Aquatic Expert',
                'es' => 'Experto Acuático',
            ],
            'description' => [
                'en' => "When this hunter moves onto pond nodes they don't discard damage cards.",
                'es' => 'Cuando este cazador se mueve hacia los nodos del estanque, no descarta cartas de daño.',
            ],
        ],
        [
            'name' => [
                'en' => 'Water Attack',
                'es' => 'Ataque de Agua',
            ],
            'description' => [
                'en' => 'When this hunter plays a :water_icon: elemental attack, draw +1 :damage_attack_icon:.',
                'es' => 'Cuando este cazador juega un :water_icon: ataque elemental, obtiene +1 :damage_attack_icon:.',
            ],
        ],
        [
            'name' => [
                'en' => 'Heroics',
                'es' => 'Bonus Salud Baja',
            ],
            'description' => [
                'en' => 'While this hunter has 2 health or less, when this hunter plays an attack card without an elemental damage symbol, draw +1 :damage_attack_icon:.',
                'es' => 'Mientras este cazador tenga 2 de salud o menos, cuando este cazador juegue una carta de ataque sin un símbolo de daño elemental, roba +1 :damage_attack_icon:.',
            ],
        ],
        [
            'name' => [
                'en' => 'Resentment',
                'es' => 'Bonus Daño Temporal',
            ],
            'description' => [
                'en' => 'If this hunter recovered health during your previous turn, the first attack card you play this turn gains +2 :damage_attack_icon:.',
                'es' => 'Si este cazador recuperó salud durante tu turno anterior, la primera carta de ataque que juegues este turno gana +2 :damage_attack_icon:.',
            ],
        ],
        [
            'name' => [
                'en' => 'Part Breaker',
                'es' => 'Bonus Rompe-partes',
            ],
            'description' => [
                'en' => 'When this hunter plays an attack card with 1 or more :break_icon:, the card gains +1 :break_icon:.',
                'es' => 'Cuando este cazador juega una carta de ataque con 1 o más :break_icon:, la carta gana +1 :break_icon:.',
            ],
        ],
        [
            'bonus-set' => ['Diablos Helm', 'Diablos Mail', 'Diablos Greaves'],
            'name' => [
                'en' => 'Diablos Mastery',
                'es' => 'Maestría de Diablos',
            ],
            'description' => [
                'en' => 'When this hunter plays an attack card without an elemental damage symbol, draw +1 :damage_attack_icon:.',
                'es' => 'Cuando este cazador juega una carta de ataque sin un símbolo de daño elemental, roba +1 :damage_attack_icon:.',
            ],
        ],
        [
            'bonus-set' => ['Diablos Nero Helm', 'Diablos Nero Mail', 'Diablos Nero Greaves'],
            'name' => [
                'en' => 'Black Diablos Mastery',
                'es' => 'Maestría de Diablos Negra',
            ],
            'description' => [
                'en' => 'When this hunter plays an attack card without an elemental damage symbol, draw +1 :damage_attack_icon:.',
                'es' => 'Cuando este cazador juega una carta de ataque sin un símbolo de daño elemental, roba +1 :damage_attack_icon:.',
            ],
        ],
        [
            'name' => [
                'en' => 'Critical Eye',
                'es' => 'Bonus Afinidad',
            ],
            'description' => [
                'en' => 'When you draw :damage_attack_icon:, draw +1 :damage_attack_icon:, then choose 1 :damage_attack_icon: to place on top of your damage deck before inflicting damage to the monster.',
                'es' => 'Cuando robas :damage_attack_icon:, robas +1 :damage_attack_icon:, luego elige 1 :damage_attack_icon: para colocarlo encima de tu mazo de daño antes de infligir daño al monstruo.',
            ],
        ],
        [
            'name' => [
                'en' => 'Maximun Might',
                'es' => 'Bonus de Afinidad',
            ],
            'description' => [
                'en' => '',
                'es' => '',
            ],
        ],
        [
            'name' => [
                'en' => 'Agitator',
                'es' => 'Instigador',
            ],
            'description' => [
                'en' => '',
                'es' => '',
            ],
        ],
        [
            'bonus-set' => ['Nergigante Helm', 'Nergigante Mail', 'Nergigante Greaves'],
            'name' => [
                'en' => 'Nergigante Hunger',
                'es' => 'Hambre de Nergigante',
            ],
            'description' => [
                'en' => '',
                'es' => '',
            ],
        ],
        [
            'name' => [
                'en' => 'Latent Power',
                'es' => 'Poder Latente',
            ],
            'description' => [
                'en' => '',
                'es' => '',
            ],
        ],
        [
            'bonus-set' => ['Kaiser Crown', 'Kaiser Mail', 'Kaiser Greaves'],
            'name' => [
                'en' => 'Teostra Technique',
                'es' => 'Técnica de Teostra',
            ],
            'description' => [
                'en' => '',
                'es' => '',
            ],
        ],
        [
            'name' => [
                'en' => 'Ice Attack',
                'es' => 'Ataque de Hielo',
            ],
            'description' => [
                'en' => 'When this hunter plays a :ice_icon: elemental attack, draw +1 :damage_attack_icon:.',
                'es' => 'Cuando este cazador juega un :ice_icon: ataque elemental, obtiene +1 :damage_attack_icon:.',
            ],
        ],
        [
            'bonus-set' => ['Kushala Glare', 'Kushala Cista', 'Kushala Crus'],
            'name' => [
                'en' => 'Kushala Daora Flight',
                'es' => 'Vuelo de Kushala Daora',
            ],
            'description' => [
                'en' => '',
                'es' => '',
            ],
        ],
        [
            'name' => [
                'en' => 'Handicraft',
                'es' => 'Artesano',
            ],
            'description' => [
                'en' => '',
                'es' => '',
            ],
        ],
    ],

    ArmorType::HEAD->name => [
        'Alloy Helm' => [
            'name' => 'Yelmo de Aleación',
            'items' => [
                'Machalite Ore' => 2,
                'Carbalite Ore' => 1,
                'Dragonite Ore' => 1,
            ],
            'defense' => 1,
            'branch' => 'mineral',
            'rarity' => 2,
        ],
        'Bone Helm' => [
            'name' => 'Yelmo de Hueso',
            'items' => [
                'Monster Bone Small' => 2,
                'Ancient Bone' => 2,
            ],
            'defense' => 1,
            'branch' => 'bone',
            'rarity' => 2,
        ],
        'Jagras Helm' => [
            'name' => 'Yelmo de Jagras',
            'items' => [
                'Great Jagras Hide' => 1,
                'Great Jagras Mane' => 1,
                'Great Jagras Claw' => 1,
                'Ancient Bone' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'skill' => 'Speed Eating',
            'branch' => 'Great Jagras',
            'rarity' => 3,
        ],
        'Kadachi Helm' => [
            'name' => 'Yelmo de Kadachi',
            'items' => [
                'Tobi-Kadachi Pelt' => 1,
                'Tobi-Kadachi Claw' => 1,
                'Electro Sac' => 1,
            ],
            'defense_thunder' => 2,
            'skill' => 'Constitution',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
        ],
        'Anja Helm' => [
            'name' => 'Yelmo de Anja',
            'items' => [
                'Anjanath Pelt' => 1,
                'Anjanath Scale' => 1,
                'Anjanath Tail' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'skill' => 'Fire Attack',
            'branch' => 'Anjanath',
            'rarity' => 3,
        ],
        'Rathalos Helm' => [
            'name' => 'Yelmo de Rathalos',
            'items' => [
                'Rathalos Scale' => 1,
                'Rathalos Shell' => 1,
                'Rathalos Marrow' => 1,
            ],
            'defense' => 2,
            'defense_fire' => 1,
            'skill' => 'Rathalos Mastery',
            'branch' => 'Rathalos',
            'rarity' => 4,
        ],
        'Rath Soul Helm' => [
            'name' => 'Yelmo Alma Rath',
            'items' => [
                'Azure Rathalos Scale' => 1,
                'Azure Rathalos Carapace' => 1,
                'Azure Rathalos Marrow' => 1,
            ],
            'defense' => 2,
            'defense_fire' => 1,
            'skill' => 'Intimidator',
            'branch' => 'Azure Rathalos',
            'rarity' => 4,
        ],
        'Barroth Helm' => [
            'name' => 'Yelmo de Barroth',
            'items' => [
                'Barroth Ridge' => 1,
                'Barroth Claw' => 1,
                'Fertile Mud' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'skill' => 'Guard',
            'branch' => 'Barroth',
            'rarity' => 3,
        ],
        'Pukei Hood' => [
            'name' => 'Capucha de Pukei',
            'items' => [
                'Pukei-Pukei Carapace' => 1,
                'Pukei-Pukei Tail' => 1,
                'Pukei-Pukei Wing' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'skill' => 'Sporepuff Expert',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
        ],
        'Jyura Helm' => [
            'name' => 'Yelmo de Jyura',
            'items' => [
                'Jyuratodus Scale' => 1,
                'Jyuratodus Carapace' => 1,
                'Jyuratodus Fin' => 1,
                'Gajau Scale' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'skill' => 'Aquatic Expert',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
        ],
        'Diablos Helm' => [
            'name' => 'Yelmo de Diablos',
            'items' => [
                'Diablos Ridge' => 1,
                'Diablos Fang' => 2,
                'Majestic Horn' => 1,
                'Wyvern Gem' => 2,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'skill' => 'Heroics',
            'branch' => 'Diablos',
            'rarity' => 4,
        ],
        'Diablos Nero Helm' => [
            'name' => 'Yelmo Diablos Negra',
            'items' => [
                'Black Diablos Ridge' => 2,
                'Majestic Horn' => 1,
                'Black Spiral Horn' => 1,
                'Novacrystal' => 2,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'skill' => 'Black Diablos Mastery',
            'branch' => 'Black Diablos',
            'rarity' => 4,
        ],
        'Kulu Headpiece' => [
            'name' => 'Defensa de Kulu',
            'items' => [
                'Kulu-Ya-Ku Scale' => 1,
                'Kulu-Ya-Ku Hide' => 1,
                'Kulu-Ya-Ku Plume' => 1,
            ],
            'defense' => 1,
            'defense_ice' => 1,
            'skill' => 'Weakness Exploit',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 5,
        ],
        'Nergigante Helm' => [
            'name' => 'Yelmo de Nergigante',
            'items' => [
                'Nergigante Horn' => 1,
                'Nergigante Carapace' => 1,
                'Immortal Dragonscale' => 2,
                'Nergigante Gem' => 1,
            ],
            'defense' => 2,
            'defense_fire' => 2,
            'skill' => 'Maximun Might',
            'branch' => 'Nergigante',
            'rarity' => 5,
        ],
        'Kaiser Crown' => [
            'name' => 'Corona del Káiser',
            'items' => [
                'Teostra Carapace' => 1,
                'Teostra Horn' => 1,
                'Teostra Tail' => 1,
                'Firecell Stone' => 2,
            ],
            'defense' => 2,
            'defense_fire' => 1,
            'skill' => 'Latent Power',
            'branch' => 'Teostra',
            'rarity' => 5,
        ],
        'Kushala Glare' => [
            'name' => 'Mirada de Kushala',
            'items' => [
                'Daora Dragon Scale' => 2,
                'Daora Carapace' => 1,
                'Daora Webbing' => 1,
                'Elder Dragon Bone' => 2,
            ],
            'defense' => 1,
            'defense_ice' => 2,
            'skill' => 'Ice Attack',
            'branch' => 'Kushala Daora',
            'rarity' => 5,
        ],
    ],

    ArmorType::BODY->name => [
        'Alloy Mail' => [
            'name' => 'Cota de Aleación',
            'items' => [
                'Machalite Ore' => 1,
                'Carbalite Ore' => 2,
                'Dragonite Ore' => 1,
            ],
            'defense' => 1,
            'branch' => 'mineral',
            'rarity' => 2,
        ],
        'Bone Mail' => [
            'name' => 'Cota de Hueso',
            'items' => [
                'Monster Bone Small' => 1,
                'Ancient Bone' => 1,
            ],
            'skill' => 'Slugger',
            'branch' => 'bone',
            'rarity' => 2,
        ],
        'Jagras Mail' => [
            'name' => 'Cota de Jagras',
            'items' => [
                'Great Jagras Hide' => 1,
                'Great Jagras Claw' => 1,
                'Great Jagras Scale' => 1,
                'Monster Bone Small' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'skill' => 'Palico Rally',
            'branch' => 'Great Jagras',
            'rarity' => 3,
        ],
        'Kadachi Mail' => [
            'name' => 'Cota de Kadachi',
            'items' => [
                'Tobi-Kadachi Pelt' => 1,
                'Tobi-Kadachi Electrode' => 1,
                'Tobi-Kadachi Membrane' => 2,
                'Wingdrake Hide' => 1,
            ],
            'defense' => 1,
            'defense_thunder' => 1,
            'skill' => 'Evade Extender',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
        ],
        'Anja Mail' => [
            'name' => 'Cota de Anja',
            'items' => [
                'Anjanath Pelt' => 1,
                'Anjanath Fang' => 1,
                'Anjanath Nosebone' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'skill' => 'Marathon Runner',
            'branch' => 'Anjanath',
            'rarity' => 3,
        ],
        'Rathalos Mail' => [
            'name' => 'Cota de Rathalos',
            'items' => [
                'Rathalos Scale' => 1,
                'Rathalos Webbing' => 1,
                'Rathalos Plate' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'skill' => 'Weakness Exploit',
            'branch' => 'Rathalos',
            'rarity' => 4,
        ],
        'Rath Soul Mail' => [
            'name' => 'Cota Alma Rath',
            'items' => [
                'Azure Rathalos Scale' => 1,
                'Azure Rathalos Wing' => 1,
                'Azure Rathalos Plate' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'skill' => 'Azure Rathalos Mastery',
            'branch' => 'Azure Rathalos',
            'rarity' => 4,
        ],
        'Barroth Mail' => [
            'name' => 'Cota de Barroth',
            'items' => [
                'Barroth Carapace' => 1,
                'Barroth Ridge' => 2,
                'Barroth Claw' => 1,
                'Quality Bone' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'branch' => 'Barroth',
            'rarity' => 3,
        ],
        'Pukei Mail' => [
            'name' => 'Cota de Pukei',
            'items' => [
                'Pukei-Pukei Scale' => 2,
                'Pukei-Pukei Carapace' => 1,
                'Carbalite Ore' => 3,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'skill' => 'Botanist',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
        ],
        'Jyura Mail' => [
            'name' => 'Cota de Jyura',
            'items' => [
                'Jyuratodus Scale' => 1,
                'Jyuratodus Fin' => 1,
                'Jyuratodus Fang' => 1,
                'Torrent Sac' => 2,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'skill' => 'Water Attack',
            'branch' => 'Jyuratodus',
            'rarity' => 3,
        ],
        'Diablos Mail' => [
            'name' => 'Cota de Diablos',
            'items' => [
                'Diablos Carapace' => 2,
                'Diablos Ridge' => 1,
                'Majestic Horn' => 1,
                'Lightcrystal' => 2,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'skill' => 'Slugger',
            'branch' => 'Diablos',
            'rarity' => 4,
        ],
        'Diablos Nero Mail' => [
            'name' => 'Cota Diablos Negra',
            'items' => [
                'Black Diablos Carapace' => 2,
                'Black Spiral Horn' => 2,
                'Blos Medulla' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'skill' => 'Resentment',
            'branch' => 'Black Diablos',
            'rarity' => 4,
        ],
        'Kulu Mail' => [
            'name' => 'Cota de Kulu',
            'items' => [
                'Kulu-Ya-Ku Hide' => 2,
                'Kulu-Ya-Ku Plume' => 1,
                'Kulu-Ya-Ku Beak' => 1,
                'Bird Wyvern Gem' => 1,
            ],
            'defense' => 1,
            'defense_ice' => 1,
            'skill' => 'Critical Eye',
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 5,
        ],
        'Nergigante Mail' => [
            'name' => 'Cota de Nergigante',
            'items' => [
                'Immortal Dragonscale' => 2,
                'Nergigante Talon' => 2,
                'Elder Dragon Bone' => 2,
            ],
            'defense' => 2,
            'defense_ice' => 2,
            'skill' => 'Agitator',
            'branch' => 'Nergigante',
            'rarity' => 5,
        ],
        'Kaiser Mail' => [
            'name' => 'Cota de Káiser',
            'items' => [
                'Teostra Webbing' => 2,
                'Teostra Powder' => 2,
                'Rathalos Plate' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 2,
            'skill' => 'Teostra Technique',
            'branch' => 'Teostra',
            'rarity' => 5,
        ],
        'Kushala Cista' => [
            'name' => 'Quiste de Kushala',
            'items' => [
                'Daora Carapace' => 1,
                'Daora Horn' => 1,
                'Daora Claw' => 1,
                'Daora Gem' => 1,
            ],
            'defense' => 2,
            'defense_ice' => 1,
            'skill' => 'Kushala Daora Flight',
            'branch' => 'Kushala Daora',
            'rarity' => 5,
        ],
    ],

    ArmorType::LEG->name => [
        'Alloy Greaves' => [
            'name' => 'Grebas de Aleación',
            'items' => [
                'Machalite Ore' => 1,
                'Carbalite Ore' => 2,
                'Dragonite Ore' => 1,
            ],
            'skill' => 'Poison Resistance',
            'branch' => 'mineral',
            'rarity' => 2,
        ],
        'Bone Greaves' => [
            'name' => 'Grebas de Hueso',
            'items' => [
                'Monster Bone Small' => 1,
                'Ancient Bone' => 1,
            ],
            'defense' => 1,
            'branch' => 'bone',
            'rarity' => 2,
        ],
        'Jagras Greaves' => [
            'name' => 'Grebas de Jagras',
            'items' => [
                'Great Jagras Scale' => 1,
                'Great Jagras Hide' => 1,
                'Great Jagras Mane' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'branch' => 'Great Jagras',
            'rarity' => 3,
        ],
        'Kadachi Greaves' => [
            'name' => 'Grebas de Kadachi',
            'items' => [
                'Tobi-Kadachi Scale' => 2,
                'Tobi-Kadachi Pelt' => 1,
                'Warm Pelt' => 1,
            ],
            'defense_thunder' => 1,
            'skill' => 'Thunder Attack',
            'branch' => 'Tobi-Kadachi',
            'rarity' => 3,
        ],
        'Anja Greaves' => [
            'name' => 'Grebas de Anja',
            'items' => [
                'Anjanath Scale' => 1,
                'Anjanath Pelt' => 1,
                'Flame Sac' => 1,
                'Machalite Ore' => 2,
            ],
            'defense' => 1,
            'defense_fire' => 2,
            'branch' => 'Anjanath',
            'rarity' => 3,
        ],
        'Rathalos Greaves' => [
            'name' => 'Grebas de Rathalos',
            'items' => [
                'Rathalos Shell' => 1,
                'Rathalos Wingtalon' => 1,
                'Rathalos Tail' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'skill' => 'Sleep Resistance',
            'branch' => 'Rathalos',
            'rarity' => 4,
        ],
        'Rath Soul Greaves' => [
            'name' => 'Grebas Alma Rath',
            'items' => [
                'Azure Rathalos Carapace' => 1,
                'Azure Rathalos Wingtalon' => 1,
                'Azure Rathalos Tail' => 1,
            ],
            'defense' => 1,
            'defense_fire' => 1,
            'skill' => 'Focus',
            'branch' => 'Azure Rathalos',
            'rarity' => 4,
        ],
        'Barroth Greaves' => [
            'name' => 'Grebas de Barroth',
            'items' => [
                'Barroth Ridge' => 1,
                'Barroth Carapace' => 2,
                'Fertile Mud' => 1,
                'Monster Keenbone' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'skill' => 'Stun Resistance',
            'branch' => 'Barroth',
            'rarity' => 3,
        ],
        'Pukei Greaves' => [
            'name' => 'Grebas de Pukei',
            'items' => [
                'Pukei-Pukei Carapace' => 2,
                'Pukei-Pukei Sac' => 2,
                'Pukei-Pukei Scale' => 1,
                'Monster Keenbone' => 1,
            ],
            'defense' => 1,
            'defense_water' => 1,
            'skill' => 'Poison Resistance',
            'branch' => 'Pukei-Pukei',
            'rarity' => 3,
        ],
        'Jyura Greaves' => [
            'name' => 'Grebas de Jyura',
            'items' => [
                'Jyuratodus Carapace' => 1,
                'Jyuratodus Fang' => 1,
                'Jyuratodus Fin' => 1,
                'Wyvern Gem' => 1,
            ],
            'defense' => 1,
            'defense_water' => 2,
            'branch' => 'Jyuratodus',
            'rarity' => 3,
        ],
        'Diablos Greaves' => [
            'name' => 'Grebas de Diablos',
            'items' => [
                'Diablos Ridge' => 1,
                'Diablos Carapace' => 2,
                'Blos Medulla' => 1,
            ],
            'defense' => 2,
            'defense_fire' => 1,
            'skill' => 'Diablos Mastery',
            'branch' => 'Diablos',
            'rarity' => 4,
        ],
        'Diablos Nero Greaves' => [
            'name' => 'Grebas Diablos Negra',
            'items' => [
                'Black Diablos Ridge' => 1,
                'Black Diablos Carapace' => 2,
                'Black Spiral Horn' => 1,
                'Wyvern Gem' => 1,
            ],
            'defense' => 2,
            'defense_fire' => 1,
            'skill' => 'Part Breaker',
            'branch' => 'Black Diablos',
            'rarity' => 4,
        ],
        'Kulu Greaves' => [
            'name' => 'Grebas de Kulu',
            'items' => [
                'Kulu-Ya-Ku Hide' => 1,
                'Kulu-Ya-Ku Scale' => 2,
                'Wingdrake Hide' => 3,
                'Earth Crystal' => 1,
            ],
            'defense' => 1,
            'defense_ice' => 2,
            'branch' => 'Kulu-Ya-Ku',
            'rarity' => 5,
        ],
        'Nergigante Greaves' => [
            'name' => 'Grebas de Nergigante',
            'items' => [
                'Nergigante Carapace' => 1,
                'Immortal Dragonscale' => 1,
                'Nergigante Regrowth Plate' => 2,
                'Elder Dragon Blood' => 2,
            ],
            'defense' => 2,
            'defense_water' => 2,
            'skill' => 'Nergigante Hunger',
            'branch' => 'Nergigante',
            'rarity' => 5,
        ],
        'Kaiser Greaves' => [
            'name' => 'Grebas de Káiser',
            'items' => [
                'Fire Dragon Scale' => 2,
                'Teostra Mane' => 1,
            ],
            'defense' => 2,
            'defense_fire' => 1,
            'skill' => 'Weakness Exploit',
            'branch' => 'Teostra',
            'rarity' => 5,
        ],
        'Kushala Crus' => [
            'name' => 'Perneras de Kushala',
            'items' => [
                'Daora Carapace' => 1,
                'Daora Dragon Scale' => 1,
                'Daora Webbing' => 2,
                'Elder Dragon Blood' => 2,
            ],
            'defense' => 2,
            'defense_ice' => 1,
            'skill' => 'Handicraft',
            'branch' => 'Kushala Daora',
            'rarity' => 5,
        ],
    ],
];
