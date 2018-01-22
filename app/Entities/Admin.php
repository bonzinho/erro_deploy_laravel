<?php

namespace App\Entities;

use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $guard_name = 'admin'; // para usar o permisions

    const ROLE = 'admin';
    const GROUP_SU = 0; //Super admin
    const GROUP_GEST = 1; //Gestor
    const GROUP_GEST_SCHE = 2; // Gestor de agenda
    const GROUP_GEST_TEC = 3; // Gestor tecnico
    const GROUP_GEST_FIN = 4; //Gestor financeiro

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'obs',
        'state',
        'role'
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
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events(){
        return $this->hasMany(Event::class);
    }


    /**
     * @param int $id
     * @return mixed
     */
    public static function findById(int $id)
    {
        $admin = static::where('id', $id)->first();
        return $admin;
    }
}
