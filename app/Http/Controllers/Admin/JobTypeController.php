<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobTypeRequest;
use App\Models\JobType;
use App\Traits\SlugTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class JobTypeController extends Controller
{
    use SlugTrait;

    public function index()
    {
        $job_types = JobType::latest()->paginate(10);

        return view('admin.jobtypes.index',compact('job_types'));
    }

    public function create()
    {
        return view('admin.jobtypes.form');
    }

    public function store(JobTypeRequest $request)
    {
        try {
            $job_type = new JobType();
            $this->save($request, $job_type);
            Toastr::success('Added successfully');
            return redirect()->route('job-types');
        } catch (\Exception $e){
            Toastr::error('Something went wrong, please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function edit($id, Request $request)
    {
        $job_type = JobType::findOrfail($id);
        return view('admin.jobtypes.form', compact('job_type'));
    }

    public function update(JobTypeRequest $request)
    {
        $job_type = JobType::findOrfail($request->id);
        try {
            $this->save($request, $job_type);
            Toastr::success('Updated successfully');
            return redirect()->route('job-types');
        } catch (\Exception $e){
            Toastr::error('Something went wrong, please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function save($request, $job_type)
    {
        $job_type->title = $request->title;
        $job_type->slug  = $this->getSlug($request->title, $request->slug);
        $job_type->save();
    }
}
