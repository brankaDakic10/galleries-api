<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }



       public function register(Request $request){
               $user = new User();
               $validator = Validator::make($request->all(), [
                   'firstName' => 'required|string',
                   'lastName' => 'required|string',
                   'email' => 'required|string|email|unique:users',
                   'password' => 'required|string|min:8',
                   'password_confirmation' => 'required|string|min:8',
                   'terms'=>'required'
               ]);
            //    add in password and password_confirmation
            //    numeric|min:1
           
               if ($validator->fails()) {
                   return new JsonResponse($validator->errors(), 400);
               }
               
               if($request->input('password')!== $request->input('password_confirmation')){
                   return new JsonResponse([['Passwords doesnt match!']], 400);
               }
           
           $user->firstName = $request->input('firstName');
           $user->lastName = $request->input('lastName');
           $user->email = $request->input('email');
           $user->password = bcrypt($request->input('password'));
           $user->terms = $request->input('terms');
           
           $user->save();
        
           return $user;
             
           }
       
}
