<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Service::create([
            'name' => 'corte de pelo',
            'duration' => 30,
        ]);
        Service::create([
            'name' => 'Teñir el pelo',
            'duration' => 180,
        ]);
        Service::create([
            'name' => 'maquillaje',
            'duration' => 40,
        ]);
        Service::create([
            'name' => 'barba',
            'duration' => 20,
        ]);
    }
}
