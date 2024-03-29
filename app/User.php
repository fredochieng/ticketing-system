<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use DB;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $user_email = Auth::user()->email;
        ~$user_role = $user->getRoleNames()->first();
        if ($user_role == "Admin") {
            $compare_field = "roles.name";
            $compare_operator = "=";
            $compare_value = "Technician";

            $helpdesk_technicians = DB::table('users')->select(DB::raw('users.*'), DB::raw('model_has_roles.*'), DB::raw('roles.name AS role_name'))
                ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                // ->where('roles.name', 'Technician')
                ->where($compare_field, $compare_operator, $compare_value)
                ->get();
            return $helpdesk_technicians;
        } elseif ($user_role == "Systems Manager") {
            $compare_field = "roles.name";
            $compare_operator = "=";
            $compare_value = "Systems & Developers";

            $helpdesk_technicians = DB::table('users')->select(DB::raw('users.*'), DB::raw('model_has_roles.*'), DB::raw('roles.name AS role_name'))
                ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                // ->where('roles.name', 'Technician')
                ->where($compare_field, $compare_operator, $compare_value)
                ->get();
            return $helpdesk_technicians;
        } elseif ($user_role == "Standard User") {
            $compare_field = "roles.name";
            $compare_operator = "=";
            $compare_value = "Technician";

            $helpdesk_technicians = DB::table('users')->select(DB::raw('users.*'), DB::raw('model_has_roles.*'), DB::raw('roles.name AS role_name'))
                ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                // ->where('roles.name', 'Technician')
                ->where($compare_field, $compare_operator, $compare_value)
                ->get();
            return $helpdesk_technicians;
        }
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
        return $this->hasRole('Systems & Developers');
    }
    public function isSysManager()
    {
        return $this->hasRole('Systems Manager');
    }
    public function isCIO()
    {
        return $this->hasRole('Chief Information Officer');
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
