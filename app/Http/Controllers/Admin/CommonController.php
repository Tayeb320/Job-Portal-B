<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class CommonController extends Controller
{
    public function delete($id)
    {
        $urlArray    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $segments    = explode('/', $urlArray);
        $numSegments = count($segments);
        $table       = $segments[$numSegments - 2];

        try {
            if ($table == 'applicant'):
                $user = User::find($id);
                $user->jobs()->detach();
                $user->delete();
            elseif ($table == 'jobs'):
                $job = Job::find($id);
                $job->applicants()->detach();
                $job->delete();
            elseif ($table == 'job_types'):
                $jobType = JobType::find($id);
                $jobs    = $jobType->jobs();
                foreach ($jobs as $job):
                    $job->applicants()->detach();
                    $job->delete();
                endforeach;
                $jobType->delete();
            endif;

            $response['message'] = 'Deleted Successfully!';
            $response['status']  = 'success';
            $response['title']   = 'Deleted';
            return response()->json($response);
        } catch (\Exception $e){
            $response['message'] = 'Something went wrong, please try again';
            $response['status']  = 'error';
            $response['title']   = 'Ops..!';
            return response()->json($response);
        }
    }

    public function statusChange(Request $request)
    {
        try {
            $table  = $request['data']['status_for'];
            $id     = $request['data']['id'];
            $status = $request['data']['status'];

            if ($table == 'applicants'):
                $table = 'users';
            endif;

            DB::table($table)->where('id',$id)->update(['status' => $status]);

            $response['message'] = __('Updated Successfully');
            $response['title']   = __('Success');
            $response['status']  = 'success';
            return response()->json($response);
        } catch (\Exception $e){
            $response['message'] = __('Something went wrong, please try again');
            $response['title']   = __('Ops..!');
            $response['status']  = 'error';
            return response()->json($response);
        }
    }
}
