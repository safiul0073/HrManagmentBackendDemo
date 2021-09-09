<?php

namespace App\Http\Controllers;

use App\Models\Attendence;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendenceController extends Controller
{
    //store the attendance data
    function store (Request $request) {
        $att = Attendence::create($request->all());
        return response()->json(['message'=> "Attendence Added"], 200);
    }

    // function getAll () {
    //     $att = Attendence::all();
        
    //     return response()->json(['message'=> "Attendence Added"], 200);
    // }

    function getAllAttendByEmployee () {
        $employees = User::where('depertment', "em")->get();
        $allAttendees = 0;
        $arr = [];
        $present = 0;
        $holyday = 0;
        foreach ($employees as $employee) {
            $present = Attendence::where("user_id", $employee->id)->whereDate('created_at', Carbon::today())->count();
            $allAttendees = Attendence::where('present', 1)->where('user_id', $employee->id)->count();
            $allWeekends = Attendence::where('present', 1)->where('user_id', $employee->id)->where('weekend', 1)->count();
            $allAbsen = Attendence::where('present', 0)->where('holyday', 0)->where('weekend', 0)->where('user_id', $employee->id)->count();
            $holyday = Attendence::where('user_id', $employee->id)->where('holyday', 1)->count();
            $att_id = Attendence::where('user_id', $employee->id)->latest()->first();
            $arr[] = [
                "id" => $att_id ? $att_id->id : null,
                "user_id" => $employee->id,
                "name" => $employee->name,
                "email" => $employee->email,
                'pesent' => $present,
                "totalPresent" => $allAttendees,
                "totalAbsence" => $allAbsen,
                "weekend" => $allWeekends,
                "holyday" => $holyday
            ];
        }
        ;
        return response()->json(['employees'=> $arr], 200);
    }

    public function update (Request $request) {

            $att = Attendence::find($request->id);
            $att->present = $request->present;
            $att->holyday = $request->holyday;
            $att->weekend = $request->weekend;
            $att->save();
           
        return response()->json(['message' => "success"]);
    }

    function total () {
        $allPresent = Attendence::where('present', 1)->whereDate('created_at', Carbon::today())->count();
        $allabsence = Attendence::where('present', 0)->whereDate('created_at', Carbon::today())->count();
        $allEmployees = User::where('depertment', "em")->count();
        $allLeav = Attendence::where('weekend', 1)->whereDate('created_at', Carbon::today())->count();

        $total = [
            'all_present' => $allPresent,
            'all_absence' => $allabsence,
            'all_employees' => $allEmployees,
            'all_leav' => $allLeav,
        ];

        return response()->json($total);
        
    }
    // get Attendence by Month and
    function getMonth ($id) {

        $users = Attendence::where("user_id", $id)->select('id', 'created_at')
        ->get()
        ->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('m');
        });

        $usermcount = [];
        $userArr = [];

        foreach ($users as $key => $value) {
            $usermcount[(int)$key] = count($value);
        }

        $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $sume_for_year = 0;
        for ($i = 1; $i <= 12; $i++) {
            if (!empty($usermcount[$i])) {
                $userArr[$i]['count'] = $usermcount[$i];
                $sume_for_year += $usermcount[$i];
            } else {
                $userArr[$i]['count'] = 0;
            }
            $userArr[$i]['month'] = $month[$i - 1];
        }

        return response()->json(['Month' =>array_values($userArr),'year' => $sume_for_year]);
    }

    // getting then employee details 
    function getStatus (Request $request) {
        $searchKeyword  = $request->searchKeyword;
        if ($searchKeyword) {
            $allPresent = Attendence::where('user_id', $request->id)->whereDate('created_at', $searchKeyword)->first();
            return response()->json($allPresent);
        }
    }
}
