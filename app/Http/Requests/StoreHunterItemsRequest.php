<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHunterItemsRequest extends FormRequest
{
    /**
     * A hunt yields a handful of parts at once, so the request carries a list
     * rather than one part and a count.
     */
    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_id' => ['required', 'integer', 'exists:items,id'],
            'items.*.number' => ['required', 'integer', 'min:0'],
        ];
    }
}
