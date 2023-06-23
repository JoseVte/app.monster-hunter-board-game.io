<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Armor;
use App\Models\Weapon;
use App\Models\Monster;
use App\Models\ArmorSkill;
use App\Models\WeaponType;
use App\Models\WeaponAttack;
use Illuminate\Console\Command;
use App\Models\DowntimeActivity;

class ScoutImportAllCommand extends Command
{
    protected $signature = 'scout:import-all';

    protected $description = 'Command description';

    public function handle(): void
    {
        $command = 'scout:import';
        $this->call($command, ['model' => Armor::class]);
        $this->call($command, ['model' => ArmorSkill::class]);
        $this->call($command, ['model' => DowntimeActivity::class]);
        $this->call($command, ['model' => Item::class]);
        $this->call($command, ['model' => Monster::class]);
        $this->call($command, ['model' => Weapon::class]);
        $this->call($command, ['model' => WeaponAttack::class]);
        $this->call($command, ['model' => WeaponType::class]);
    }
}
