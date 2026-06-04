<?php

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Scheduler;
use App\Models\OpeningHour;
use App\Notifications\SchedulerCreated;
use App\Notifications\SchedulerDeleted;
use Illuminate\Support\Facades\Notification;

/**
 * Flujo de reserva de citas (área de cliente).
 *
 * Reglas de negocio (ver App\Http\Requests\ManageReservationRules):
 *  1. El personal debe estar libre en esa franja.
 *  2. El cliente no puede tener otra cita en esa franja.
 *  3. El personal debe prestar el servicio solicitado.
 *  4. La cita debe caer dentro del horario de atención.
 */

// --- Helpers locales ---

function makeService(string $name = 'Corte', int $duration = 30): Service
{
    // Asignación directa para evitar el mass-assignment del modelo Service.
    $service = new Service();
    $service->name = $name;
    $service->duration = $duration;
    $service->save();

    return $service;
}

function makeOpeningHour(int $day, string $open = '09:00:00', string $close = '18:00:00'): void
{
    $openingHour = new OpeningHour();
    $openingHour->day = $day;
    $openingHour->open = $open;
    $openingHour->close = $close;
    $openingHour->save();
}

/** Una franja válida en el futuro (7 días, 10:00). */
function bookingSlot(): array
{
    $from = Carbon::today()->addDays(7)->setTime(10, 0);

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

function bookAs($client, $staff, $service, Carbon $from)
{
    return test()->actingAs($client)->post('/my-schedule', [
        'from' => ['date' => $from->format('Y-m-d'), 'time' => $from->format('H:i')],
        'staff_user_id' => $staff->id,
        'service_id' => $service->id,
    ]);
}

// --- Creación ---

it('permite a un cliente reservar una cita', function () {
    Notification::fake();
    ['client' => $client, 'staff' => $staff, 'service' => $service, 'from' => $from] = bookableScenario();

    bookAs($client, $staff, $service, $from)
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('scheduler', [
        'client_user_id' => $client->id,
        'staff_user_id' => $staff->id,
        'service_id' => $service->id,
    ]);

    Notification::assertSentTo($staff, SchedulerCreated::class);
});

it('reserva la cita con la duración del servicio', function () {
    Notification::fake();
    [$from] = bookingSlot();
    $client = userWithRole('client');
    $staff = userWithRole('staff');
    $service = makeService('Tinte', 180);
    $staff->services()->attach($service->id);
    makeOpeningHour($from->dayOfWeek);

    bookAs($client, $staff, $service, $from)->assertSessionHasNoErrors();

    $appointment = Scheduler::first();
    expect($appointment->to->format('H:i'))->toBe('13:00'); // 10:00 + 180 min
});

// --- Validaciones de negocio ---

it('rechaza una reserva fuera del horario de atención', function () {
    ['client' => $client, 'staff' => $staff, 'service' => $service, 'from' => $from] = bookableScenario();
    $outside = (clone $from)->setTime(20, 0); // cierra a las 18:00

    bookAs($client, $staff, $service, $outside)->assertSessionHasErrors();

    $this->assertDatabaseCount('scheduler', 0);
});

it('rechaza la reserva si el personal no presta ese servicio', function () {
    [$from] = bookingSlot();
    $client = userWithRole('client');
    $staff = userWithRole('staff');
    $service = makeService(); // NO se asigna al personal
    makeOpeningHour($from->dayOfWeek);

    bookAs($client, $staff, $service, $from)->assertSessionHasErrors();

    $this->assertDatabaseCount('scheduler', 0);
});

it('rechaza la reserva si el personal ya está ocupado en esa franja', function () {
    ['client' => $client, 'staff' => $staff, 'service' => $service, 'from' => $from, 'to' => $to] = bookableScenario();

    // Cita previa del mismo personal, en la misma franja, con otro cliente.
    Scheduler::create([
        'from' => $from,
        'to' => $to,
        'status' => 'pendig',
        'staff_user_id' => $staff->id,
        'client_user_id' => userWithRole('client')->id,
        'service_id' => $service->id,
    ]);

    bookAs($client, $staff, $service, $from)->assertSessionHasErrors();

    $this->assertDatabaseCount('scheduler', 1); // solo la cita previa
});

it('requiere servicio y personal válidos', function () {
    $client = userWithRole('client');
    [$from] = bookingSlot();

    $this->actingAs($client)->post('/my-schedule', [
        'from' => ['date' => $from->format('Y-m-d'), 'time' => $from->format('H:i')],
        // sin staff_user_id ni service_id
    ])->assertSessionHasErrors(['staff_user_id', 'service_id']);
});

// --- Cancelación ---

it('permite a un cliente cancelar su cita próxima', function () {
    Notification::fake();
    ['client' => $client, 'staff' => $staff, 'service' => $service, 'from' => $from, 'to' => $to] = bookableScenario();

    $appointment = Scheduler::create([
        'from' => $from,
        'to' => $to,
        'status' => 'pendig',
        'staff_user_id' => $staff->id,
        'client_user_id' => $client->id,
        'service_id' => $service->id,
    ]);

    $this->actingAs($client)->delete('/my-schedule/' . $appointment->id)->assertRedirect();

    $this->assertDatabaseMissing('scheduler', ['id' => $appointment->id]);
    Notification::assertSentTo($staff, SchedulerDeleted::class);
});

it('impide cancelar una cita con menos de 24 horas de antelación', function () {
    ['client' => $client, 'staff' => $staff, 'service' => $service] = bookableScenario();
    $soon = Carbon::now()->addHours(2);

    $appointment = Scheduler::create([
        'from' => $soon,
        'to' => (clone $soon)->addMinutes(30),
        'status' => 'pendig',
        'staff_user_id' => $staff->id,
        'client_user_id' => $client->id,
        'service_id' => $service->id,
    ]);

    $this->actingAs($client)->delete('/my-schedule/' . $appointment->id)->assertSessionHasErrors();

    $this->assertDatabaseHas('scheduler', ['id' => $appointment->id]);
});

it('impide a un cliente cancelar la cita de otra persona', function () {
    ['client' => $owner, 'staff' => $staff, 'service' => $service, 'from' => $from, 'to' => $to] = bookableScenario();

    $appointment = Scheduler::create([
        'from' => $from,
        'to' => $to,
        'status' => 'pendig',
        'staff_user_id' => $staff->id,
        'client_user_id' => $owner->id,
        'service_id' => $service->id,
    ]);

    $intruder = userWithRole('client');

    $this->actingAs($intruder)->delete('/my-schedule/' . $appointment->id)->assertSessionHasErrors();

    $this->assertDatabaseHas('scheduler', ['id' => $appointment->id]);
});
