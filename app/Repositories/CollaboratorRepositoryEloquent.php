<?php

namespace App\Repositories;

use App\Events\AfterCollaboratorSignInEvent;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CollaboratorRepository;
use App\Entities\Collaborator;


/**
 * Class CollaboratorRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CollaboratorRepositoryEloquent extends BaseRepository implements CollaboratorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Collaborator::class;
    }

    public function create(array $attributes)
    {
        //verificar se existe photo e preparar a mesmo para o evento
        if(isset($attributes['photo'])){
            $photo = $attributes['photo'];
            $attributes['photo'] = env('photo_perfil_default');
        }else{
            $photo = new \Illuminate\Http\UploadedFile(
                storage_path('app/files/collaborator/perfil_photo/photo_perfil_default.jpg'), 'photo_perfil_default.jpg');
            $attributes['photo'] = env('photo_perfil_default');
        }

        //verificar se existe photo e preparar a mesmo para o evento
        if(isset($attributes['cv'])){
            $cv = $attributes['cv'];
            $attributes['cv'] = env('cv_default');
        }

        //crypt password
        $attributes['password'] =  bcrypt($attributes['password']);

        $collaborator = parent::create($attributes);
        $event = new AfterCollaboratorSignInEvent($photo, $cv, $collaborator);
        event($event);
        return $collaborator;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
