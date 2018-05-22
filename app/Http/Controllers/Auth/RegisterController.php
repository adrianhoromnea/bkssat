<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\tuser;

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
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'erpusers' =>'required|unique:users,erpuser_id',
            'roles' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */



    public function createAdmin(Request $request)
    {
        
        //**validate data */
          
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'erpusers' =>'required|unique:users,erpuser_id',
            'roles' => 'required',      
        ]);
        
        $user =  User::create([
            'firstname' => $request->name,
            'lastname' => $request->lastname,
            'admin' => false,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'erpuser_id' => $request->erpusers
        ]);
        
        $user->roles()
            ->attach($request->roles);

        //return redirect()->route('userslist');
    }

    protected function update($id){

    }

    protected function showRegister(){
        return view('auth.register')->with(
            ['roles'=>Role::all(),
             'erpusers'=>tuser::all()->where('Inactiv','0')->sortBy('Nume')
            ]);
    }

    protected function showUpdate(){
        //
    }

}
