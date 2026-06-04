<?php

use Carbon\Carbon;
use App\Models\Scheduler;
use App\Notifications\SchedulerUpdated;
use Illuminate\Support\Facades\Notification;

/**
 * Reprogramación de citas (cliente y personal).
 *
 * Reglas (App\Policies\SchedulerPolicy + ManageReservationRules):
 *  - Solo se puede reprogramar con 24h o más de antelación.
 *  - Se revalidan disponibilidad y horario de atención (ignorando la propia cita).
 */

function makeAppointment($client, $staff, $service, Carbon $from): Scheduler
{
    return Scheduler::create([
        'from' => $from,
        'to' => (clone $from)->addMinutes($service->duration),
        'status' => 'pendig',
        'staff_user_id' => $staff->id,
        'client_user_id' => $client->id,
        'service_id' => $service->id,
    ]);
}

// --- Cliente ---

it('permite a un cliente reprogramar su cita', function () {
    Notification::fake();
    ['client' => $client, 'staff' => $staff, 'service' => $service, 'from' => $from] = bookableScenario();
    $appointment = makeAppointment($client, $staff, $service, $from);

    $newFrom = (clone $from)->setTime(11, 0);

    $this->actingAs($client)->put('/my-schedule/' . $appointment->id, [
        'from' => ['date' => $newFrom->format('Y-m-d'), 'time' => $newFrom->format('H:i')],
        'staff_user_id' => $staff->id,
        'service_id' => $service->id,
    ])->assertSessionHasNoErrors()->assertRedirect();

    expect($appointment->fresh()->from->format('H:i'))->toBe('11:00');
    Notification::assertSentTo($staff, SchedulerUpdated::class);
});

it('impide reprogramar una cita con menos de 24 horas de antelación', function () {
    ['client' => $client, 'staff' => $staff, 'service' => $service] = bookableScenario();
    $soon = Carbon::now()->addHours(2);
    $appointment = makeAppointment($client, $staff, $service, $soon);

    $newFrom = (clone bookingSlot()[0])->setTime(11, 0);

    $this->actingAs($client)->put('/my-schedule/' . $appointment->id, [
        'from' => ['date' => $newFrom->format('Y-m-d'), 'time' => $newFrom->format('H:i')],
        'staff_user_id' => $staff->id,
        'service_id' => $service->id,
    ])->assertForbidden();

    expect($appointment->fresh()->from->format('H:i'))->toBe($soon->format('H:i'));
});

it('rechaza la reprogramación fuera del horario de atención', function () {
    ['client' => $client, 'staff' => $staff, 'service' => $service, 'from' => $from] = bookableScenario();
    $appointment = makeAppointment($client, $staff, $service, $from);

    $outside = (clone $from)->setTime(20, 0);

    $this->actingAs($client)->put('/my-schedule/' . $appointment->id, [
        'from' => ['date' => $outside->format('Y-m-d'), 'time' => $outside->format('H:i')],
        'staff_user_id' => $staff->id,
        'service_id' => $service->id,
    ])->assertSessionHasErrors();

    expect($appointment->fresh()->from->format('H:i'))->toBe('10:00');
});

// --- Personal ---

it('permite al personal reprogramar una cita que atiende', function () {
    Notification::fake();
    ['client' => $client, 'staff' => $staff, 'service' => $service, 'from' => $from] = bookableScenario();
    $appointment = makeAppointment($client, $staff, $service, $from);

    $newFrom = (clone $from)->setTime(12, 0);

    $this->actingAs($staff)->put('/staff-scheduler/' . $appointment->id, [
        'from' => ['date' => $newFrom->format('Y-m-d'), 'time' => $newFrom->format('H:i')],
    ])->assertSessionHasNoErrors()->assertRedirect();

    expect($appointment->fresh()->from->format('H:i'))->toBe('12:00');
});
