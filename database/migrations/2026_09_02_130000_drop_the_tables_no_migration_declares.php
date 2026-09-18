<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

// armor_abilities and armor_ability were superseded by armor_skills and
// armor_skill, and mail_switcher_credentials belonged to a package that is no
// longer installed. No migration creates any of the three any more, so they only
// exist on databases old enough to predate the removals.
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('armor_ability');
        Schema::dropIfExists('armor_abilities');
        Schema::dropIfExists('mail_switcher_credentials');
    }
};
