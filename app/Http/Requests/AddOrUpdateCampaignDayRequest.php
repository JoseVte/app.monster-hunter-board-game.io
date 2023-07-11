<?php

namespace App\Http\Requests;

use App\Enum\DayType;
use App\Models\Monster;
use App\Enum\MonsterDifficulty;
use Illuminate\Validation\Rule;
use App\Models\DowntimeActivity;
use Illuminate\Foundation\Http\FormRequest;

class AddOrUpdateCampaignDayRequest extends FormRequest
{
    protected $errorBag = 'addOrUpdateCampaignDay';

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
        $rules = [
            'type_day' => ['required', Rule::in(DayType::rule())],
        ];

        if ('DOWNTIME' === $this->input('type_day')) {
            $rules = array_merge([
                'all_hunters_same_activity' => ['sometimes', 'boolean'],
                'day_id' => ['nullable', 'required_if:all_hunters_same_activity,true', Rule::exists(DowntimeActivity::class, 'id')],
                'hunter_day_id' => ['array', 'required_if:all_hunters_same_activity,false'],
                'hunter_day_id.*' => ['required_if:all_hunters_same_activity,false', Rule::exists(DowntimeActivity::class, 'id')],
            ]);
        }
        if ('MONSTER' === $this->input('type_day')) {
            $rules = array_merge([
                'monster_id' => ['required', Rule::exists(Monster::class, 'id')],
                'difficulty' => ['required', Rule::in(MonsterDifficulty::rule())],
                'hunted' => ['sometimes', 'boolean'],
            ]);
        }

        return $rules;
    }
}
