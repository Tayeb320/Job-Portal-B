<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;

class JobController extends Controller
{
    use ApiReturnFormatTrait;
    public function jobs(Request $request)
    {
        try {
            $page = $request->page ?? 1;

            $offset = ( $page * 10 ) - 10;
            $limit  = 10;

            $jobs = Job::where('status',1)
                ->whereHas('jobType', function ($q){
                    $q->where('status',1);
                })
                ->latest()->skip($offset)->take($limit)->get();

            foreach ($jobs as $job){
                $this->formatJobs($job);
            }
            return $this->responseWithSuccess('success', $jobs, 200);
        } catch (\Exception $e){
            return $this->responseWithError('Something went wrong, please try again', [], 500);
        }
    }
    public function formatJobs($job, $description = false){
        $job->job_title = $job->title;
        $job->job_type = $job->jobType->title;
        if (!$description) {
            unset($job->description);
        }
        $job->thumbnail  = @$job->thumbnail['original_image'] ? asset($job->thumbnail['original_image'] ): '';
        unset($job->title);
        unset($job->status);
        unset($job->jobType);
        unset($job->job_type_id);
        unset($job->created_at);
        unset($job->updated_at);
        unset($job->meta_keywords);
        unset($job->meta_description);
        unset($job->meta_title);

        return $job;
    }

    public function jobDetail($slug)
    {
        try {
            $job = Job::where('status',1)->where('slug',$slug)->first();
            if ($job != ''):
                return $this->responseWithSuccess('success', $this->formatJobs($job, true), 200);
            else:
                return $this->responseWithError('Not Found', [], 404);
            endif;
        } catch (\Exception $e){
            return $this->responseWithError('Something went wrong, please try again', [], 500);
        }
    }
}
