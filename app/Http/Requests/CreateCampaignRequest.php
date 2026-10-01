<?php

namespace App\Http\Requests;

use App\Enum\MonsterExpansion;
use Illuminate\Validation\Rule;
use App\Rules\IncludesABaseGame;
use Illuminate\Foundation\Http\FormRequest;

class CreateCampaignRequest extends FormRequest
{
    protected $errorBag = 'createCampaign';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'team_id' => ['required', Rule::exists('teams', 'id')->where('user_id', auth()->id())],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            // `max_days` is what `max_days_automatic` decides, so it is only
            // asked for when the campaign is on manual. On automatic the
            // number the form shows is a preview: `Campaign::booted()`
            // recomputes it on save, so whatever arrives here is overwritten.
            'max_days' => [Rule::requiredIf(fn (): bool => ! $this->boolean('max_days_automatic')), 'integer', 'min:0'],
            'max_days_automatic' => ['sometimes', 'boolean'],
            'expansions' => ['sometimes', 'array', new IncludesABaseGame],
            'expansions.*' => ['distinct', Rule::in(MonsterExpansion::rule())],
        ];
    }
}
