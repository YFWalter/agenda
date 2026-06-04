<?php

use App\Models\User;
use App\Models\OpeningHour;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Support\Facades\Notification;

/**
 * Área de administración (rol admin).
 *
 * Rutas (ver routes/web.php):
 *  - PUT /opening-hours/update      -> actualizar horarios de atención
 *  - PUT /users/{user}/services     -> asignar servicios a un usuario
 *  - POST /users/store              -> crear usuario
 */

it('permite al administrador actualizar los horarios de atención', function () {
    $open = [];
    $close = [];
    for ($day = 1; $day <= 6; $day++) {
        makeOpeningHour($day); // por defecto 09:00 - 18:00
        $open[$day] = '08:00';
        $close[$day] = '17:00';
    }

    $this->actingAs(userWithRole('admin'))
        ->put('/opening-hours/update', ['open' => $open, 'close' => $close])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    expect(OpeningHour::where('day', 1)->first()->open)->toBe('08:00');
});

it('permite al administrador asignar servicios a un usuario', function () {
    $admin = userWithRole('admin');
    $staff = userWithRole('staff');
    $corte = makeService('Corte', 30);
    $barba = makeService('Barba', 20);

    $this->actingAs($admin)
        ->put('/users/' . $staff->id . '/services', [
            'services_ids' => [$corte->id, $barba->id],
        ])
        ->assertRedirect(route('users.index'));

    $this->assertDatabaseHas('service_user', ['user_id' => $staff->id, 'service_id' => $corte->id]);
    $this->assertDatabaseHas('service_user', ['user_id' => $staff->id, 'service_id' => $barba->id]);
});

it('permite al administrador crear un usuario', function () {
    Notification::fake();
    $admin = userWithRole('admin'); // crea los roles (admin=1, staff=2, client=3)

    $this->actingAs($admin)
        ->post('/users/store', [
            'name' => 'Nuevo Empleado',
            'email' => 'empleado@example.com',
            'roles_ids' => [2], // staff
        ])
        ->assertRedirect(route('users.index'));

    $this->assertDatabaseHas('users', ['email' => 'empleado@example.com']);

    $newUser = User::where('email', 'empleado@example.com')->first();
    expect($newUser->hasRole('staff'))->toBeTrue();
    Notification::assertSentTo($newUser, WelcomeEmailNotification::class);
});
