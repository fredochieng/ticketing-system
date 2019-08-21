<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use DB;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public static function getUsers()
    {
        $users = DB::table('users')->orderBy('id', 'asc')->get();
        return $users;
    }

    public static function getHelpdeskTeam()
    {
        $helpdesk_technicians = DB::table('users')->select(DB::raw('users.*'), DB::raw('model_has_roles.*'), DB::raw('roles.name AS role_name'))
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', 'Technician')
            ->get();
        return $helpdesk_technicians;
    }
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }
    public function isITManager()
    {
        return $this->hasRole('IT Manager');
    }
    public function isSysAdmin()
    {
        return $this->hasRole('System Admin');
    }
    public function isTechnician()
    {
        return $this->hasRole('Technician');
    }
    public function isUser()
    {
        return $this->hasRole('Standard User');
    }


}
