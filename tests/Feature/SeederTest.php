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

    // 10 clientes + admin (Guali) + staff (Franco)
    expect(User::count())->toBe(12);
    expect(Service::count())->toBe(4);       // corte, tinte, maquillaje, barba
    expect(OpeningHour::count())->toBe(6);   // lunes a sábado

    expect(User::where('email', 'guali@example.com')->exists())->toBeTrue();
    expect(User::where('email', 'franco@example.com')->exists())->toBeTrue();
});

it('asigna los roles correctos a las cuentas sembradas', function () {
    $this->seed(DatabaseSeeder::class);

    expect(User::where('email', 'guali@example.com')->first()->hasRole('admin'))->toBeTrue();
    expect(User::where('email', 'franco@example.com')->first()->hasRole('staff'))->toBeTrue();
});
