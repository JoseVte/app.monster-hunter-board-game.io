<?php

namespace App\Http\Requests;

use App\Enum\DayType;
use App\Models\Monster;
use App\Models\Campaign;
use App\Enum\MonsterDifficulty;
use Illuminate\Validation\Rule;
use App\Models\DowntimeActivity;
use Illuminate\Validation\Validator;
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
     * A downtime day used to carry exactly one activity per hunter, so both
     * `day_id` (the whole party's activity) and each entry of `hunter_day_id`
     * arrived as a single id. A hunter picks up to three now, which makes both
     * of them lists.
     *
     * The scalar form is widened into a one-entry list here rather than handled
     * at each of the three places that read it. Everything downstream, the
     * rules below and the controller, then sees one shape, and a caller that
     * still sends the old one keeps working.
     */
    protected function prepareForValidation(): void
    {
        if ($this->input('type_day') !== DayType::DOWNTIME->name) {
            return;
        }

        $this->merge([
            'day_id' => $this->activityList($this->input('day_id')),
            'hunter_day_id' => collect((array) $this->input('hunter_day_id', []))
                ->map(fn (mixed $activities): array => $this->activityList($activities))
                ->all(),
        ]);
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

        if ($this->input('type_day') === DayType::DOWNTIME->name) {
            // Asserted here rather than trusted to the form, which is the
            // only thing stopping a hand-built request from parking a hunter
            // on half the activity list for one day.
            $max = Campaign::MAX_DOWNTIME_ACTIVITIES;

            $rules = array_merge($rules, [
                'all_hunters_same_activity' => ['sometimes', 'boolean'],
                'day_id' => ['array', 'required_if:all_hunters_same_activity,true', "max:$max"],
                'day_id.*' => ['distinct', Rule::exists(DowntimeActivity::class, 'id')],
                'hunter_day_id' => ['array', 'required_if:all_hunters_same_activity,false'],
                'hunter_day_id.*' => ['array', 'required_if:all_hunters_same_activity,false', "max:$max"],
                'hunter_day_id.*.*' => [Rule::exists(DowntimeActivity::class, 'id')],
            ]);
        }

        if ($this->input('type_day') === DayType::MONSTER->name) {
            $rules = array_merge($rules, [
                'monster_id' => ['required', Rule::exists(Monster::class, 'id')],
                'difficulty' => ['required', Rule::in(MonsterDifficulty::rule())],
                'hunted' => ['sometimes', 'boolean'],
            ]);
        }

        return $rules;
    }

    /**
     * The three activities have to be different ones, and that is checked by
     * hand rather than with the `distinct` rule.
     *
     * `distinct` on `hunter_day_id.*.*` compares every entry against every
     * other one across the whole array, so it would also refuse two hunters
     * choosing the same activity, which the rules allow and which is the
     * common case. It is correct on `day_id.*`, a flat list, and is used there.
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                foreach ((array) $this->input('hunter_day_id', []) as $hunter => $activities) {
                    $activities = (array) $activities;

                    if (count($activities) !== count(array_unique($activities))) {
                        $validator->errors()->add(
                            "hunter_day_id.$hunter",
                            __('A hunter cannot perform the same activity twice in one day.'),
                        );
                    }
                }
            },
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'day_id.max' => __('A hunter may perform at most :max activities in one day.'),
            'hunter_day_id.*.max' => __('A hunter may perform at most :max activities in one day.'),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    private function activityList(mixed $activities): array
    {
        return array_values(array_filter(
            is_array($activities) ? $activities : [$activities],
            fn (mixed $activity): bool => $activity !== null && $activity !== '',
        ));
    }
}
