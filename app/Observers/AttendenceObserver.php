<?php

namespace App\Observers;

use App\Models\Attendence;

class AttendenceObserver
{
    /**
     * Handle the Attendence "created" event.
     *
     * @param  \App\Models\Attendence  $attendence
     * @return void
     */
    public function creating(Attendence $attendence)
    {   $allAttendees = 0;
        $allAbsen = 0;
        $allWeekends = 0;
        $allAttendees = Attendence::where('present', 1)->where('user_id', $attendence->user_id)->count();
        $allWeekends = Attendence::where('present', 1)->where('user_id', $attendence->user_id)->where('weekend', 1)->count();
        $allAbsen = Attendence::where('present', 0)->where('holyday', 0)->where('weekend', 0)->where('user_id', $attendence->user_id)->count();
        $attendence->totalPresent = $allAttendees;
        $attendence->totalAbsence = $allAbsen;
        $attendence->weekend = $allWeekends;
    }

    public function created(Attendence $attendence)
    {
        //
    }

    /**
     * Handle the Attendence "updated" event.
     *
     * @param  \App\Models\Attendence  $attendence
     * @return void
     */
    public function updated(Attendence $attendence)
    {
        //
    }

    /**
     * Handle the Attendence "deleted" event.
     *
     * @param  \App\Models\Attendence  $attendence
     * @return void
     */
    public function deleted(Attendence $attendence)
    {
        //
    }

    /**
     * Handle the Attendence "restored" event.
     *
     * @param  \App\Models\Attendence  $attendence
     * @return void
     */
    public function restored(Attendence $attendence)
    {
        //
    }

    /**
     * Handle the Attendence "force deleted" event.
     *
     * @param  \App\Models\Attendence  $attendence
     * @return void
     */
    public function forceDeleted(Attendence $attendence)
    {
        //
    }
}
