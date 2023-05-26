<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Service;
use App\Models\Scheduler;
use Illuminate\Http\Request;
use App\Notifications\SchedulerUpdated;
use App\Http\Requests\StaffScheduleRequest;

class StaffSchedulerController extends Controller
{
    public function index()
    {
        $date = Carbon::parse(request()->input('date'));

        $dayScheduler = Scheduler::when(!auth()->user()->hasRole('admin'), function ($query){
                $query->where('staff_user_id', auth()->id());
            } )
            ->whereDate('from', $date->format('Y-m-d'))
            ->orderBy('from', 'ASC')
            ->get();
        return view('staff-scheduler.index')
            ->with([
                'date' => $date,
                'dayScheduler' => $dayScheduler,
            ]);
    }

    public function edit(Scheduler $scheduler)
    {
        if(auth()->user()->cannot('update', $scheduler)){
             abort(403, 'Acción no autorizada!');
        }

        return view('staff-scheduler.edit')->with([
            'scheduler' => $scheduler,
        ]);
    }

    public function update(Scheduler $scheduler, StaffScheduleRequest $request)
    {
         if(auth()->user()->cannot('update', $scheduler)){
            abort(403, 'Acción no autorizada!');
        }

        $service = $scheduler->service;
        $client_id = auth()->id();
        $from = Carbon::parse(request('from.date'). ' '. request('from.time'));
        $to = Carbon::parse($from)->addMinutes($service->duration);

        $request->checkReschudleRules($scheduler, $scheduler->staffUser, $scheduler->clientUser, $from, $to, $service);

        $schedulerOldFrom = $scheduler->from;
        
        $scheduler->update([
            'from' => $from,
            'to' => $to,
        ]);

        auth()->user()->notify(new SchedulerUpdated($scheduler, $schedulerOldFrom));

        return redirect(route('staff-scheduler.index', ['date' => $from->format('y-m-d')]));
    }

    public function destroy(Scheduler $scheduler)
    {
        if (auth()->user()->cannot('delete', $scheduler)) {
            return back()->withErrors('No es posible cancelar esta cita');
        }

        $scheduler->delete();

        return back();
    }
}
