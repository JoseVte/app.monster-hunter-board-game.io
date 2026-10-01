<?php

namespace App\Rules;

use Closure;
use App\Enum\MonsterExpansion;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * A campaign is played out of the Ancient Forest, the Wildspire Waste, or both.
 * Everything else in `App\Enum\MonsterExpansion` is an add-on that needs one of
 * those underneath it, so a set of expansions with neither is not a campaign
 * anybody could sit down and play.
 *
 * Written as a rule rather than repeated in the two form requests that need it,
 * and deliberately not as `required_with` or an `in` on the first element: the
 * two base games can appear at any position, and either one alone is enough.
 */
class IncludesABaseGame implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (array_intersect((array) $value, MonsterExpansion::baseGameNames()) === []) {
            $fail(__('Pick at least one of the base games.'));
        }
    }
}
