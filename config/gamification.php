<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Monster Experience
    |--------------------------------------------------------------------------
    |
    | Experience awarded for hunting a monster on the easiest difficulty. The
    | harder difficulties multiply it, see App\Enum\MonsterDifficulty.
    |
    */

    'monster_experience' => env('MONSTER_EXPERIENCE', 5),

];
