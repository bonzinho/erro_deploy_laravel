<?php

namespace App\Repositories;

use Carbon\Carbon;
use Mockery\Exception;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ScheduleRepository;
use App\Entities\Schedule;

/**
 * Class ScheduleRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ScheduleRepositoryEloquent extends BaseRepository implements ScheduleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Schedule::class;
    }

    public function create(array $attributes)
    {

        $addSpaces = []; // array para guardar espaços que ainda não existam com o meesmo horario
        foreach ($attributes['space_id'] as $space){
            //verifica se o horario para o espaço já existe
            if(count($this->findWhere(
                    [
                        'event_id' => $attributes['event_id'],
                        'date' => Carbon::parse($attributes['date'])->format('Y-m-d'),
                        'init' => $attributes['init'],
                        'end' => $attributes['end'],
                        'space_id' => $space,
                    ])) == 0) array_push($addSpaces, $space);
        }
        if(count($addSpaces) === 0){
            return false; // se todos os espaços selecionados já existe horario igual retorna falso
        }else{
            $attributes['space_id'] = $addSpaces;
        }

        ##TURNOS##
        $turnos = $this->convertEnvTurnos(env('TURNO1'), env('TURNO2'), env('TURNO3'));
        $turno1 = $turnos['turno_1'];
        $turno2 = $turnos['turno_2'];
        $turno3 = $turnos['turno_3'];

        ##Array com espaços selecionados###
        $espacos = $attributes['space_id'];
        ##CONVERTER DATA PARA MYSQL
        $attributes['date'] = Carbon::parse($attributes['date'])->format('Y-m-d');
        ##CONVERTER DATA##
        $attributes['init'] = Carbon::parse($attributes['init'])->format('H:i:s');
        $attributes['end'] = Carbon::parse($attributes['end'])->format('H:i:s');
        ##VERIFICAR A QUE TURNO PERTENCE
        if($attributes['init'] < $turno1[1]){
            if($attributes['end'] < $turno1[1]) $attributes['turno'] = '1';
            if($attributes['end'] < $turno2[1] && $attributes['end'] > $turno1[1]) $attributes['turno'] = '1;2';
            if($attributes['end'] < $turno3[1] && $attributes['end'] > $turno2[1]) $attributes['turno'] = '1;2;3';
        }elseif ($attributes['init'] < $turno2[1] && $attributes['init'] > $turno1[1]){
            if($attributes['end'] < $turno2[1] && $attributes['end'] > $turno1[1]) $attributes['turno'] = '2';
            if($attributes['end'] < $turno3[1] && $attributes['end'] > $turno2[1]) $attributes['turno'] = '2;3';
        }elseif ($attributes['init'] < $turno3[1] && $attributes['init'] > $turno2[1]){
            if($attributes['end'] < $turno3[1] && $attributes['end'] > $turno2[1]) $attributes['turno'] = '3';
        }
        try{
            for ($x=0; $x < count($espacos); $x++){
                $attributes['space_id'] = $espacos[$x];
                if($x === count($espacos)-1){
                    return parent::create($attributes); // TODO: Change the autogenerated stub
                }else{
                    parent::create($attributes); // TODO: Change the autogenerated stub
                }
            }
        }catch (Exception $e){
            return $e->getMessage();
        }

    }

    public function update(array $attributes, $id)
    {
        $spaces = $attributes['space_id'];
        $schedules = $this->deleteWhere([
            'event_id' => $attributes['event_id'],
            'date' => $attributes['date'],
            'init' => $attributes['init'],
            'end' => $attributes['end'],
        ]); //apaga todos os registos deste horario
        return $this->create($attributes);
    }

    /*public function delete($id)
    {
        //aceder a data, init e end para selecionar todos os espaços com este horario
        $get = $this->find(['id' => $id])->toArray();
        return parent::delete($id);
        $get = $get[0];
        //todos os espaços com o horario selecionado
        $spaces = $this->findWhere(['date' => $get['date'], 'init' => $get['init'], 'end' => $get['end']]);
        $spaces = $spaces->toArray();
        for($x = 0; $x < count($spaces); $x++){
            if($x+1 < count($spaces)) parent::delete($spaces[$x]['id']);
            else return parent::delete($spaces[$x]['id']);
        }
    }*/


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    private function convertEnvTurnos($turno1, $turno2, $turno3){
        $first = explode("-", $turno1);
        $second = explode("-", $turno2);
        $third = explode("-", $turno3);

        $return['turno_1'][0] = Carbon::parse(trim($first[0]))->format('H:i:s');
        $return['turno_1'][1] = Carbon::parse(trim($first[1]))->format('H:i:s');
        $return['turno_2'][0] = Carbon::parse(trim($second[0]))->format('H:i:s');
        $return['turno_2'][1] = Carbon::parse(trim($second[1]))->format('H:i:s');
        $return['turno_3'][0] = Carbon::parse(trim($third[0]))->format('H:i:s');
        $return['turno_3'][1] = Carbon::parse(trim($third[1]))->format('H:i:s');

        return $return;
    }
}
