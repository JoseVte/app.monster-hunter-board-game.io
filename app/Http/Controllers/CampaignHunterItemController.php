<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Hunter;
use App\Models\Campaign;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateItemCountRequest;
use App\Http\Requests\StoreHunterItemsRequest;

class CampaignHunterItemController extends Controller
{
    /**
     * Several parts in one go. Each count replaces what the hunter had of that
     * part, the same as updating one on its own.
     */
    public function storeMany(StoreHunterItemsRequest $request, Campaign $campaign, Hunter $hunter): RedirectResponse
    {
        $this->authorize('update', [$campaign, $hunter]);

        DB::transaction(function () use ($request, $hunter): void {
            foreach ($request->validated('items') as $item) {
                $hunter->items()->syncWithoutDetaching([
                    $item['item_id'] => ['number' => $item['number']],
                ]);
            }
        });

        return back(303);
    }

    public function updateCount(UpdateItemCountRequest $request, Campaign $campaign, Hunter $hunter, Item $item): RedirectResponse
    {
        if ($hunter->items()->where('items.id', $item->id)->exists()) {
            $hunter->items()->updateExistingPivot($item->id, ['number' => $request->get('count_item')]);
        } else {
            $hunter->items()->attach($item->id, ['number' => $request->get('count_item')]);
        }

        return back(303);
    }
}
