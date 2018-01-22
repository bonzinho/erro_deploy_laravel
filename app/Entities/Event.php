<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Event extends Model implements Transformable
{
    use TransformableTrait;

    const PENDENTE = 1;
    const PROCESSADO = 2;
    const CONCULIDO = 3;
    const ARQUIVADO = 4;
    const CANCELADO = 5;

    protected $fillable = [
        'client_id',
        'nature_id',
        'denomination',
        'date_time_init',
        'date_time_end',
        'work_plan',
        'technical_raider',
        'programme',
        'notes',
        'budget',
        'total_expenses',
        'total_recipes',
        'final_value',
        'state_id',
        'number_participants',
        'doc_program',
        'doc_procedding',
        'type_id',
        'user_id',
        'technic_balancete',
        'schedule_balancete',
        'total_recipes',
        'total_expenses',
        'balance_notify_client',
        'balance_acepted_client',
        'close_internal_sche_balance',
        'close_internal_tech_balance'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(){
        return $this->belongsTo(Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nature(){
        return $this->belongsTo(Nature::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state(){
        return $this->belongsTo(State::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(){
        return $this->belongsTo(Type::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function spaces(){
        return $this->belongsToMany(Space::class)->withPivot('quantity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(){
        return $this->hasMany(Task::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function materials(){
        return $this->belongsToMany(Material::class)->withPivot('quantity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function graphics(){
        return $this->belongsToMany(Graphic::class)->withPivot('quantity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function audiovisuals(){
        return $this->belongsToMany(Audiovisual::class, 'event_audiovisual')
            ->withPivot('quantity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function supports(){
        return $this->belongsToMany(Support::class)
            ->withPivot('quantity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(){
        return $this->hasMany(Schedule::class)->orderBy('init', 'asc');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipes(){
        return $this->hasMany(Recipe::class)->orderBy('group');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses(){
        return $this->hasMany(Expense::class)->orderBy('group')->orderBy('created_at', 'ASC');
    }

    public function balanceNotification(){
        return $this->hasOne(BalanceNotification::class);
    }


    /**
     * @return string
     */
    public static function programDir(){
        return 'events/programs/';
    }

}
