<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

/**
 * Asegura que existan los roles del sistema (guard "web").
 */
function makeRoles(): void
{
    foreach (['admin', 'staff', 'client'] as $role) {
        \Spatie\Permission\Models\Role::findOrCreate($role, 'web');
    }
}

/**
 * Crea un usuario y le asigna el rol indicado.
 */
function userWithRole(string $role): \App\Models\User
{
    makeRoles();

    $user = \App\Models\User::factory()->create();
    $user->assignRole($role);

    return $user;
}

/**
 * Crea un servicio (asignación directa para evitar el mass-assignment).
 */
function makeService(string $name = 'Corte', int $duration = 30): \App\Models\Service
{
    $service = new \App\Models\Service();
    $service->name = $name;
    $service->duration = $duration;
    $service->save();

    return $service;
}

/**
 * Crea un horario de atención para un día concreto.
 */
function makeOpeningHour(int $day, string $open = '09:00:00', string $close = '18:00:00'): void
{
    $openingHour = new \App\Models\OpeningHour();
    $openingHour->day = $day;
    $openingHour->open = $open;
    $openingHour->close = $close;
    $openingHour->save();
}

/** Una franja válida en el futuro (7 días, 10:00). */
function bookingSlot(): array
{
    $from = \Carbon\Carbon::today()->addDays(7)->setTime(10, 0);

    return [$from, (clone $from)->addMinutes(30)];
}

/** Escenario completo y reservable: cliente, personal, servicio y horario. */
function bookableScenario(): array
{
    [$from, $to] = bookingSlot();

    $client = userWithRole('client');
    $staff = userWithRole('staff');
    $service = makeService();
    $staff->services()->attach($service->id);
    makeOpeningHour($from->dayOfWeek);

    return compact('client', 'staff', 'service', 'from', 'to');
}

/** Realiza una reserva como cliente. */
function bookAs($client, $staff, $service, \Carbon\Carbon $from)
{
    return test()->actingAs($client)->post('/my-schedule', [
        'from' => ['date' => $from->format('Y-m-d'), 'time' => $from->format('H:i')],
        'staff_user_id' => $staff->id,
        'service_id' => $service->id,
    ]);
}
