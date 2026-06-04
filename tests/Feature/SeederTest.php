<?php

use App\Models\User;
use App\Models\Service;
use App\Models\OpeningHour;
use Database\Seeders\DatabaseSeeder;

/**
 * Verifica que los seeders se ejecutan sin errores y crean los datos esperados.
 * (Cubre los bugs de mass-assignment en Service y OpeningHour.)
 */

it('ejecuta el seeder principal y crea los datos de ejemplo', function () {
    $this->seed(DatabaseSeeder::class);

    // admin + personal + cliente
    expect(User::count())->toBe(3);
    expect(Service::count())->toBe(4);       // corte, tinte, maquillaje, barba
    expect(OpeningHour::count())->toBe(6);   // lunes a sábado

    expect(User::where('email', 'personal@demo.com')->exists())->toBeTrue();
    expect(User::where('email', 'cliente@demo.com')->exists())->toBeTrue();
});

it('asigna los roles correctos a las cuentas de demo', function () {
    $this->seed(DatabaseSeeder::class);

    expect(User::where('email', 'admin@demo.com')->first()->hasRole('admin'))->toBeTrue();
    expect(User::where('email', 'personal@demo.com')->first()->hasRole('staff'))->toBeTrue();
    expect(User::where('email', 'cliente@demo.com')->first()->hasRole('client'))->toBeTrue();
});

it('asigna todos los servicios al personal de demo para que pueda atender', function () {
    $this->seed(DatabaseSeeder::class);

    $staff = User::where('email', 'personal@demo.com')->first();
    expect($staff->services()->count())->toBe(4);
});
