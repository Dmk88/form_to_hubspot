<?php

namespace App\Http\Controllers;

use Adldap;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use League\Flysystem\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;


class AuthController extends Controller
{
    
    protected $userRole = '';
    
    public function login(){
        echo"<pre>";
        var_dump(34234);exit;
    }
    
    public function access(Request $request)
    {
        echo"<pre>";
        var_dump($request);exit;
        $json = file_get_contents('php://input');
        $req = json_decode($json);
        
        $username = (string)$req->username;
        $password = (string)$req->password;
        
        try {
            if (!Adldap::auth()->attempt($username, $password)) {
                return $this->responseFailAuth();
            }
            
            if (User::where('username', $username)->first()) {
                $user = User::where('username', $username)->first();
                $this->userRole = $user->role;
                $user->token = Str::random(40);
                $user->expiration = Carbon::now()->addDay(30);
                if (!$user->save()) {
                    throw new \Exception('Undefined Error', Response::HTTP_UNAUTHORIZED);
                }
            } else {
                $user = new User();
                $user->username = $username;
                $user->token = Str::random(40);
                $user->expiration = Carbon::now()->addDay(30);
                $this->userRole = 'user';
                if (!$user->save()) {
                    throw new \Exception('Undefined Error', Response::HTTP_UNAUTHORIZED);
                }
            }
            
            $responseCode = Response::HTTP_OK;
            $responseMsg = [
                'status' => $responseCode,
                'message' => 'Ok',
                'token' => User::where('username', $username)->first()->token,
                'role' => $this->userRole,
            ];
        } catch (\Exception $ex) {
            $responseCode = $ex->getCode();
            $responseMsg = ['status' => $responseCode, 'message' => $ex->getMessage()];
        }
        
        return response(json_encode($responseMsg), $responseCode);
    }
    
    public function showLogin()
    {
        echo"<pre>";
        var_dump($request);exit;
        return view('auth.login');
    }
    
    public function checkAdmin(Request $request)
    {
        
        $username = (string)$request->input('username');
        $password = (string)$request->input('password');
        
        if (!Adldap::auth()->attempt($username, $password)) {
            return $this->responseFailAuth();
        }
        
        if ($this->isAdmin($username)) {
            return redirect('/admin');
        }
        return redirect()->route('showLogin');
        
        
    }
    
}
