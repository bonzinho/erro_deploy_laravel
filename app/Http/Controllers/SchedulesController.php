<?php

namespace App\Http\Controllers;

use App\Entities\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ScheduleCreateRequest;
use App\Http\Requests\ScheduleUpdateRequest;
use App\Repositories\ScheduleRepository;


class SchedulesController extends Controller
{

    /**
     * @var ScheduleRepository
     */
    protected $repository;

    public function __construct(ScheduleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ScheduleCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleCreateRequest $request)
    {
        try {
            $schedule = $this->repository->create($request->all());
            if($schedule){
                $response = [
                    'message' => 'Schedule created.',
                    'data'    => $schedule->toArray(),
                ];
                if ($request->wantsJson()) {
                    return response()->json($response);
                }
            }else{
                $response = [
                    'message' => 'Atenção já existe um hórario igual para este dia, por favor edite o mesmo caso seja necessário',
                ];
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  ScheduleUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(ScheduleUpdateRequest $request, $id)
    {
        try {
            $schedule = $this->repository->update($request->all(), $id);
            $response = [
                'message' => 'Schedule updated.',
                'data'    => $schedule->toArray(),
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Horário Apagado.',
                'deleted' => $deleted,
            ]);
        }
        return redirect()->back()->with('message', 'Hórario do espaço apagado com sucesso');
    }

    /**
     * @param $date
     * @param $init
     * @param $end
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpacesFromSchedules($date, $init, $end, $event_id){
        try{
            $date = Carbon::parse($date)->format('Y-m-d');
            $spaces = $this->repository->findWhere(['date' => $date, 'init' => $init, 'end' => $end, 'event_id' => $event_id]);
            return response()->json($spaces->toArray());
        }catch (Exception $e){
            return response()->json($e->getMessage()->toArray());
        }
    }
}
