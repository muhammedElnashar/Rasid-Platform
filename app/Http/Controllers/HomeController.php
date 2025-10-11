<?php

namespace App\Http\Controllers;

use App\Enum\StatusEnum;
use App\Models\RedemptionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $schoolId = Auth::user()->school_id;
        $users = null;
        $students = null;
        $parents = null ;
        $teachers = null;
        $moderators = null;
        $redemptionRequests = null;
        $approvedRedemptionRequests = null;
        if (Auth::user()->isSuperAdmin()){
            $users = User::where('role_id', 2)->count();

        }
        if (Auth::user()->isSchoolAdmin()){
            $students = User::where('school_id',$schoolId)->where('role_id', 3)->count();
            $teachers = User::where('school_id',$schoolId)->where('role_id', 4)->count();
            $parents = User::where('school_id',$schoolId)->where('role_id', 5)->count();
            $moderators = User::where('school_id',$schoolId)->where('role_id', 6)->count();
            $redemptionRequests  = RedemptionRequest::where('school_id',$schoolId)->where('status',StatusEnum::Pending)->count();
            $approvedRedemptionRequests  = RedemptionRequest::where('school_id',$schoolId)->where('status',StatusEnum::Approved)->count();
        }
        if (Auth::user()->isModerator() || Auth::user()->isStudent()||Auth::user()->isTeacher() || Auth::user()->isGuardian()){
            $students = User::where('school_id',$schoolId)->where('role_id', 3)->count();
            $teachers = User::where('school_id',$schoolId)->where('role_id', 4)->count();
            $parents = User::where('school_id',$schoolId)->where('role_id', 5)->count();
            $moderators = User::where('school_id',$schoolId)->where('role_id', 6)->count();
        }


        return view('home',compact('users','students','parents','teachers','moderators','approvedRedemptionRequests','redemptionRequests'));
    }
}
