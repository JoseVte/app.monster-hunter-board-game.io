<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use LevelUp\Experience\Models\Achievement;

class ProfileLevelController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Profile/Level', [
            'achievements' => Achievement::all(),
        ]);
    }
}
