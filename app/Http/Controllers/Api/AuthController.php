<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApplicantProfile;
use App\Models\Job;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\ResourceTrait;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;

class AuthController extends Controller
{
    use ApiReturnFormatTrait, ResourceTrait;

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
//                'phone' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->responseWithError('Required filed missing', $validator->errors(), 422);
                // return response()->json($validator->errors(), 422);
            }

            $user = User::wherePhone($request->email)->where('user_type','user')->first();

            if (blank($user)) :
                return $this->responseWithError( 'User not fount', [], 422);
            endif;

            if($user->status == 0) :
                return $this->responseWithError('Your account is invalid', [], 401);
            elseif($user->status == 2):
                return $this->responseWithError( 'Your account is banned', [], 401);
            endif;

            if (!Hash::check($request->get('password'), $user->password)) :
                return $this->responseWithError('Invalid credential', $validator->errors(), 422);
            endif;

            $credentials = ['phone'=>$request->email, 'password'=>$request->password];

//            try {
//                if (!$token = Auth::attempt($credentials)) {
//                    return $this->responseWithError('Unable to create token', [], 401);
//                }
//            } catch (JWTException $e) {
//                return $this->responseWithError('Could not create token', [] , 422);
//
//            }catch (\Exception $e) {
//                return $this->responseWithError('Something went wrong, please try again', [], 500);
//            }
//
//            $data = $this->getProfile($user);
//            $data['token'] = $token;

            if (Auth::attempt($credentials)) {
                return redirect()->route('dashboard');
            }

            return $this->responseWithSuccess('Login successfully', $data, 200);
        } catch (\Exception $e){
            return $this->responseWithError('Something went wrong, please try again', [], 500);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'phone' => 'required|max:15|min:11|unique:users,phone,'.\Request()->id,
            'email' => 'required|email|max:40|unique:users,email,'.\Request()->id,
            'password' => 'required|min:6',
            'image' => 'mimes:jpg,JPG,JPEG,jpeg,png,PNG|max:5120',
            'cv' => 'mimes:pdf,PDF|max:5120',
            'about' => 'max:250',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError('Required field missing', $validator->errors(), 422);
        }
        DB::beginTransaction();
        try {
            $user = new User();
            $this->save($request, $user);

            $credentials = ['phone'=>$request->phone, 'password'=>$request->password];

            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->responseWithError('Unable to create token', [], 401);
            }

            $data = $this->getProfile($user);
            DB::commit();
            $data['token'] = $token;
            return $this->responseWithSuccess('Successfully registered', $data, 200);
        } catch (\Exception $e){
            DB::rollback();
            return $this->responseWithError('Something went wrong, please try again', [], 500);
        }

    }

    public function save($request, $user, $update = false)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        if (!blank($request->file('image'))) :
            if ($update):
                $this->deleteImage($user->image);
            endif;
            $requestImage   = $request->file('image');
            $user->image = $this->saveImage($requestImage) ?? [];
        endif;

        $user->save();

        $profile = $update ? $user->profile : new ApplicantProfile();
        $this->saveProfile($request, $user, $profile, $update);
    }

    public function saveProfile($request, $user, $profile, $update = false)
    {
        if (!blank($request->file('cv'))) :
            if ($update):
                $this->deleteFile($profile->cv);
            endif;
            $requestfile   = $request->file('cv');
            $profile->cv = $this->saveFile($requestfile) ?? [];
        endif;
        $profile->user_id = $user->id;
        $profile->about = $request->about;
        $profile->save();
    }

    public function getProfile($user)
    {
        $data['id'] = $user->id;

        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['phone'] = $user->phone;
        return $data;
    }

    public function applyJob(Request $request){
        try{
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return $this->responseWithError('Unauthorized user', '' , 422);
            }

            $job = Job::where('status',1)->where('id',$request->job_id)->first();
            if ($job != ''):
                if ($user->jobs()->find($request->job_id) == ''):
                    $user->jobs()->attach($request->job_id);
                    return $this->responseWithSuccess('Applied successfully', [], 200);
                else:
                    return $this->responseWithError('Already Applied', [], 422);
                endif;
            else:
                return $this->responseWithError('Not Found', [], 404);
            endif;

        } catch (\Exception $e){
            DB::rollback();
            return $this->responseWithError('Something went wrong, please try again', [], 500);
        }
    }
}
