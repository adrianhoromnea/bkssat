<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname', 'email', 'password','admin','erpuser_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //roles functions

    public function authorizeRoles($roles){
        if(is_array($roles)){
            return $this ->hasAnyRole($role) ||
                abort(401, 'Nu ai dreptul de a face aceasta operatiune. Contacteaza administratorul de sistem.');
        }

        return $this->hasRole($roles) ||
            abort(401, 'Nu ai dreptul de a face aceasta operatiune. Contacteaza administratorul de sistem.');
    }

    public function hasAnyRole($roles){
        return null !== $this->roles()->whereIn('name', $roles)->first();
        }

    public function hasRole($role)
        {
          return null !== $this->roles()->where('name', $role)->first();
        }



    //relationships
    public function roles(){
        return $this -> belongsToMany('App\Role');
    }

    public function tuser(){
        return $this -> belongsTo('App\tuser','erpuser_id','IdUser');
    }

    public function programare_plata_c(){
        $this->hasMany('App\ProgramarePlata','created_by','id');
    }

    public function programare_plata_u(){
        $this->hasMany('App\ProgramarePlata','updated_by','id');
    }

    public function programare_plata_s(){
        $this->hasMany('App\ProgramarePlata','status_by','id');
    }

}
