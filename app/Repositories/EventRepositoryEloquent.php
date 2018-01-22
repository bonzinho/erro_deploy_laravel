<?php

namespace App\Repositories;

use App\Events\UploadEventProgramEvent;
use Carbon\Carbon;
use Mockery\Exception;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EventRepository;
use App\Entities\Event;
use App\Validators\EventValidator;

/**
 * Class EventRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EventRepositoryEloquent extends BaseRepository implements EventRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Event::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return EventValidator::class;
    }


    public function update(array $attributes, $id)
    {
        //Arranjo de materials e quantidade
        if (!empty($attributes['material_id'])) {
            $material = [];
            $y = 0;
            for ($x = 0; $x < count($attributes['material_quantity']); $x++) {
                if ($attributes['material_quantity'][$x] !== null) {
                    $material += [$attributes['material_id'][$y] => ['quantity' => $attributes['material_quantity'][$x]]];
                    $y++;
                }
            }
        }
        if(!empty($attributes['date_time_init'])){
            $split = explode(' - ', $attributes['date_time_init']);
            $attributes['date_time_init'] = date('Y-m-d H:i', strtotime(trim($split[0])));
            $attributes['date_time_end'] = date('Y-m-d H:i', strtotime(trim($split[1])));
        }

        if(isset($attributes['doc_program'])){
            $file = $attributes['doc_program'];
            $programName = $this->find($id)->doc_program;
            // se não existir fcheiro na edição cria o nome
            if(!$programName) $programName = md5(trim(time().str_replace(' ','_',$attributes['denomination']))).'.'.$attributes['doc_program']->guessExtension();
            $attributes['doc_program'] = $programName;
            //remover ficheiro antigo para depois voltar a fazer upload
            if(file_exists(Event::programDir().$programName)) unlink(Event::programDir().$programName);
            $updateUploadEvent =  new UploadEventProgramEvent($file, $programName);
            event($updateUploadEvent);
        }

        try{
            $event =  parent::update($attributes, $id);
            if (empty($material)) {
                $event->materials()->detach();
            } else {
                $event->materials()->sync($material);
            }

            if (empty($attributes['space_id'])) {
                $event->spaces()->detach();
            } else {
                $event->spaces()->sync($attributes['space_id']);
            }

            if (empty($attributes['support_id'])) {
                $event->supports()->detach();
            } else {
                $event->supports()->sync($attributes['support_id']);
            }

            if (empty($attributes['graphic_id'])) {
                $event->graphics()->detach();
            } else {
                $event->graphics()->sync($attributes['graphic_id']);
            }

            if (empty($attributes['graphic_id'])) {
                $event->audiovisuals()->detach();
            } else {
                $event->audiovisuals()->sync($attributes['audiovisual_id']);
            }
            return $event;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function changeStatus($state, $id){
        //verificação se o balancete está fechado
        if($state['state_id'] == Event::ARQUIVADO){
            $event = $this->find($id);
            if($event->schedule_balancete == 0 || $event->technic_balancete == 0){
                return false;
            }
        }
        $event = parent::update($state, $id);
        return $event;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
