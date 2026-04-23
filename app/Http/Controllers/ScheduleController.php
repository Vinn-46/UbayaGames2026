<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    
    public function show(Request $request)
    {
        $selectedDate = $request->query('date', now()->toDateString());

        $query = Schedule::with('teams')->whereDate('time', $selectedDate);        

        if ($request->filled('filter_by') && $request->filled('search')) {
            $filterBy = $request->filter_by;
            $search   = $request->search;

            if ($filterBy === 'cabang') {
                $query->where('competition', $search);
            } elseif ($filterBy === 'house') {
                $query->whereHas('teams', function ($q) use ($search) {
                    $q->where('name', 'LIKE', substr($search, 9) .'%');
                });
            }
        }

        $schedules = $query->orderBy('time', 'asc')->get();
        $groupedSchedules = $schedules->groupBy('competition');
        
        return view('schedule', [
            'groupedSchedules'    => $groupedSchedules,
            'selectedDate' => $selectedDate
        ]);
    }    
}
