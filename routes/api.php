<?php

use App\Models\Monster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', fn (Request $request) => $request->user());

Route::post('locale', static function () {
    // Validate
    $validated = request()->validate([
        'language' => ['required'],
    ]);
    // Set locale
    App::setLocale($validated['language']);
    // Session
    session()->put('locale', $validated['language']);
    // Response
    return redirect()->back();
});

Route::prefix('monsters')->name('monster.')->group(function (): void {
    Route::get('filter', static function (Illuminate\Http\Request $request): JsonResponse {
        $query = Monster::query();

        if ($request->has('name')) {
            $query->searchTranslate('name', $request->get('name'));
        }
        if ($request->has('category')) {
            $query->whereCategory($request->get('category'));
        }
        if ($request->has('expansion')) {
            $query->whereExpansion($request->get('category'));
        }

        return response()->json($query->paginate(5));
    })->name('filter');
});
