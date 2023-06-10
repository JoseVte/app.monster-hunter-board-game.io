<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Hunter;
use App\Models\Campaign;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateItemCountRequest;

class CampaignHunterItemController extends Controller
{
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
