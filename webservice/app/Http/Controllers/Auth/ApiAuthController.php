<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Project;
use App\Task;
use App\UsersProject;

class ApiAuthController extends Controller
{
    /*** public __construct()
    {
        $this->middleware('api:auth', ['except' => 'authenticate', 'register']);
    }***/
    public function authenticate()
    {
        // grab credentials from the request
        $credentials = request()->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = auth()->user();
        $count = UsersProject::where('user_id','=', $user->id)->count();
        $count2 = $user->projects()->where('done', '=', '0')->count();
        // all good so return the token
        return response()->json(compact('token', 'user', 'count', 'count2'));
    }

        public function getAuthenticatedUser()
    {
        $response = $this->getUser();
        if($response['status'] != 200)
        return response()->json([$response['response']], $response['status']);

        $user = $response['response'];
        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function register(Request $request, User $user)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user->create($data);
        return $this->authenticate();
    }

    public function update(Request $request, User $user)
    {
        $response = $this->getUser();
        if($response['status'] != 200)
        return response()->json([$response['response']], $response['status']);

     /***   if(isset($request['image'])){
            $time = time();
            $directory = 'profiles';
            $imageDirectory = $directory.DIRECTORY_SEPARATOR.'profile_id'.$user->id;
            $ext = substr($request['image'], 11, strpos($request['image'], ';') - 11);
            $urlImage = $imageDirectory.DIRECTORY_SEPARATOR.$time.'.'.$ext;

            $file = str_replace('data:image/'.$ext.';base64','',$request['image']);
            $file = base64_decode($file);

            if(!file_exists($imageDirectory)){
                mkdir($imageDirectory, 0700);
            }

            file_put_contents($urlImage, $file);
            $user->image = $urlImage;
        }
        $user->save();
        $user->image = asset($user->image); ***/
        $user = $response['response'];
        $request['password'] = bcrypt($request['password']);
        $user->update($request->all());

        return response()->json(compact('user'));
    }

    public function getUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                //return response()->json(['user_not_found'], 404);
                return [
                    'response' => 'user_not_found',
                    'status'   => 404
                ];
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            //return response()->json(['token_expired'], $e->getStatusCode());
            return [
                'response' => 'token_expired',
                'status'   => $e->getStatusCode()
            ];
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            //return response()->json(['token_invalid'], $e->getStatusCode());
            return [
                'response' => 'token_invalid',
                'status'   => $e->getStatusCode()
            ];
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

           // return response()->json(['token_absent'], $e->getStatusCode());
           return [
            'response' => 'token_absent',
            'status'   => $e->getStatusCode()
           ];
        }

        return [
            'response' => $user,
            'status'   => 200
           ];
    }
}
