<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['applicants'] = User::where('user_type','user')->count();
        $data['total_jobs'] = Job::all()->count();
        return view('admin.dashboard',compact('data'));
    }
}
