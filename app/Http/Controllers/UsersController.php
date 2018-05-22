<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\tuser;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    //**shoow users list */
    public function index(){
        $users = User::all()->sortBy('lastname');
        $usersList = array();

        foreach($users as $user){
            $id = $user->id;
            $user->roles =  $this->getRolesString($id);
        }

        return view('auth.userslist')
            ->with('userslist',$users);
    }

    //**add new user entry + associated roles */
    public function create(Request $request)
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

        return redirect()->route('userslist');
    }

    //**update user data */
    public function update(Request $request,$id)
    {
        
        //**validate data */    
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'password' => 'sometimes|nullable|string|min:6|confirmed',
            'roles' => 'required',      
        ]);

        //**get user */
        $user = User::find($id);

        //**get values from form */
        $user->firstname = $request->name;
        $user->lastname = $request->lastname;
        if($request->password != null || trim($request->password) != "")
            {
                $user->password = bcrypt($request->password);
            }

        //**validate data - erp users */
        if($user->erpuser_id !== $request->erpusers){
            $this->validate($request,[
                'erpusers' =>'required|unique:users,erpuser_id',        
            ]);
        }

        //**get calues from form 2 - after second validation */
        $user->erpuser_id = $request->erpusers;

        //**save data */
        $user->save();
        $user->roles()
            ->sync($request->roles);

        //**return to users list */
        return redirect()->route('userslist');
    }

    //**delete user */
    public function delete($id){
        //**get user */
        $user = User::find($id);
        $user->delete();

        //**return with confirmation button */
        return redirect()->back()
                        ->with('success','Member deleted');
    }

    //** makes roles string for each user */
    protected function getRolesString($id){
        //define array
        $list = array();

        //query
        $roles = DB::select("
            select
                r.name as rolename
            from
                dbo.users u inner join dbo.role_user ru
                    on u.id = ru.user_id
                inner join roles r
                    on r.id = ru.role_id
            where 
                u.id = $id");
        $rList = "";
        if($roles){
            foreach($roles as $role){
                $rList .= " " . $role->rolename . ";";
            }
        }
        
        //return data
        return isset($rList) ? $rList : "nu este asociat unui grup";
    }

    //**redirect to create users form */
    public function showCreate(){
        return view('auth.createuser')->with(
                ['roles'=>Role::all(),
                'erpusers'=>tuser::all()->where('Inactiv','0')->sortBy('Nume')
            ]);
        }

    //**redirect to update users form */
    public function showUpdate($id){
        return view('auth.updateuser')->with(
            ['roles'=>Role::all(),
            'erpusers'=>tuser::all()->where('Inactiv','0')->sortBy('Nume'),
            'user' => User::find($id),
            ]);
        }

    
    }

