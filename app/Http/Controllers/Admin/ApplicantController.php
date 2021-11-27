<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index()
    {
        $applicants = User::where('user_type','user')->paginate(15);
        return view('admin.applicants.index', compact('applicants'));
    }
    public function detail($id)
    {
        $applicant = User::where('user_type', 'user')->where('id', $id)->first();
        return view('admin.applicants.profile', compact('applicant'));
    }
}
