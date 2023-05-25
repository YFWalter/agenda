<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Service;
use App\Models\Scheduler;
use Illuminate\Http\Request;
use App\Business\StaffServiceChecker;
use App\Notifications\SchedulerCreated;
use App\Notifications\SchedulerDeleted;
use App\Notifications\SchedulerUpdated;
use App\Http\Requests\MyScheduleRequest;
use App\Business\StaffAvailabilityChecker;
use App\Business\ClientAvailabilityChecker;

class MyScheduleController extends Controller
{
    public function index()
    {
        $date = Carbon::parse(request()->input('date'));

        $dayScheduler = Scheduler::where('client_user_id', auth()->id())
            ->whereDate('from', $date->format('Y-m-d'))
            ->orderBy('from', 'ASC')
            ->get();
        return view('my-schedule.index')
            ->with([
                'date' => $date,
                'dayScheduler' => $dayScheduler,
            ]);
    }

    public function create()
    {
        $services = Service::all();
        $staffUsers = User::role('staff')->get();
        return view('my-schedule.create', [
            'services' => $services,
            'staffUsers' => $staffUsers,
        ]);
    }

    public function store(MyScheduleRequest $request)
    {
        $service = Service::find(request('service_id'));
        $staffUser = User::find(request('staff_user_id'));
        $client_id = auth()->id();
        $from = Carbon::parse(request('from.date'). ' '. request('from.time'));
        $to = Carbon::parse($from)->addMinutes($service->duration);

        $request->checkReservationRules($staffUser, auth()->user(), $from, $to, $service);

        $scheduler = Scheduler::create([
            'from' => $from,
            'to' => $to,
            'status' => 'pendig',
            'staff_user_id' => $staffUser->id,
            'client_user_id' => $client_id,
            'service_id' => $service->id,
        ]);

        $staffUser->notify(new SchedulerCreated($scheduler));

        return redirect(route('my-schedule', ['date' => $from->format('y-m-d')]));
    }

    public function update(Scheduler $scheduler, MyScheduleRequest $request)
    {
        if(auth()->user()->cannot('update', $scheduler)){
            abort(403, 'Acción no autorizada!');
        }

        $service = Service::find(request('service_id'));
        $staffUser = User::find(request('staff_user_id'));
        $client_id = auth()->id();
        $from = Carbon::parse(request('from.date'). ' '. request('from.time'));
        $to = Carbon::parse($from)->addMinutes($service->duration);

        $request->checkReschudleRules($scheduler ,$staffUser, auth()->user(), $from, $to, $service);

        $schedulerOldFrom = $scheduler->from;
        
        $scheduler->update([
            'from' => $from,
            'to' => $to,
            'staff_user_id' => $staffUser->id,
            'service_id' => $service->id,
        ]);

        $staffUser->notify(new SchedulerUpdated($scheduler, $schedulerOldFrom));

        return redirect(route('my-schedule', ['date' => $from->format('y-m-d')]));
    }

    public function edit(Scheduler $scheduler)
    {
        if(auth()->user()->cannot('update', $scheduler)){
            abort(403, 'Acción no autorizada!');
        }

        $services = Service::all();
        $staffUsers = User::role('staff')->get();

        return view('my-schedule.edit')->with([
            'scheduler' => $scheduler,
            'services' => $services,
            'staffUsers' => $staffUsers,
        ]);
    }

    public function destroy(Scheduler $scheduler)
    {
        if(auth()->user()->cannot('delete', $scheduler)){
            return back()->withErrors('No se posible cancelar esta cita.');
        }

        $staffUser = User::find($scheduler->staff_user_id);

        $staffUser->notify(new SchedulerDeleted($scheduler));

        $scheduler->delete();

        return back();
    }
}