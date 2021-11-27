<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobRequest;
use App\Models\Job;
use App\Models\JobType;
use App\Traits\ResourceTrait;
use App\Traits\SlugTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class JobController extends Controller
{
    use SlugTrait, ResourceTrait;
    public function index()
    {
        $jobs = Job::latest()->paginate(15);

        return view('admin.jobs.index',compact('jobs'));
    }

    public function create()
    {
        $job_types = JobType::all();
        return view('admin.jobs.form', compact('job_types'));
    }

    public function store(JobRequest $request)
    {
//        dd($request->all());
        try {
            $job = new Job();
            $this->save($request, $job);
            Toastr::success('Added successfully');
            return redirect()->route('jobs');
        } catch (\Exception $e){
            Toastr::error('Something went wrong, please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function edit($id, Request $request)
    {
        $job_types = JobType::all();
        $job = Job::findOrfail($id);
        return view('admin.jobs.form', compact('job','job_types'));
    }

    public function update(JobRequest $request)
    {
//        dd($request->all());
        $job = Job::findOrfail($request->id);
        try {
            $this->save($request, $job, true);
            Toastr::success('Updated successfully');
            return redirect()->route('jobs');
        } catch (\Exception $e){
            Toastr::error('Something went wrong, please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function save($request, $job, $update = false)
    {
        $job->title = $request->title;
        $job->slug  = $this->getSlug($request->title, $request->slug);
        $job->job_type_id  = $request->job_type;
        $job->description = $request->description;
        if (!blank($request->file('thumbnail'))) :
            if ($update):
                $this->deleteImage($job->thumbnail);
            endif;
            $requestImage   = $request->file('thumbnail');
            $job->thumbnail = $this->saveImage($requestImage) ?? [];
        endif;
        $job->meta_title        = $request->meta_title;
        $job->meta_description  = $request->meta_description;
        $job->meta_keywords     = $request->meta_keywords;
        $job->save();
    }
}
