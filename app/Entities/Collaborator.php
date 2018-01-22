<?php

namespace App\Entities;

use App\Notifications\CollaboratorResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Collaborator extends Authenticatable
{
    use Notifiable;

    CONST ROLE = 'collaborator';
    CONST TECNICO = 0;
    CONST HOSPEDEIRO = 1;
    CONST MIX = 2;

    CONST RECIBO = 0;
    CONST ACT_UNICO = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'student_number',
        'locker',
        'email',
        'password',
        'genre',
        'phone',
        'type_id',
        'address',
        'postal_code',
        'locality',
        'cc',
        'nif',
        'iban',
        'photo',
        'cv',
        'state'
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
        $this->notify(new CollaboratorResetPassword($token));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function collaboratorTypes(){
        return $this->belongsTo(CollaboratorType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tasks(){
        return $this->belongsToMany(Task::class)
            ->withPivot('collaborator_id','allocation', 'accepted', 'init_time_correction', 'end_time_correction', 'normal_hour_value_total', 'extra_hour_value_total', 'confirm_allocation', 'validate_confirm_schedule', 'total_extra_hour', 'total_normal_hour', 'payment')
            ->withTimestamps();
    }

    /**
     * @return mixed
     */
    public function financials(){
        return $this->hasMany(Financial::class);
    }

    /**
     * @return string
     */
    public static function photoDir(){
        return 'collaborator/perfil_photo';
    }

    /**
     * @return string
     */
    public static function cvDir(){
        return 'collaborator/cv';
    }


}
