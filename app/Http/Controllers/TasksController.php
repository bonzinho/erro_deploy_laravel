<?php

namespace App\Http\Controllers;

use App\Entities\Collaborator;
use App\Events\AfterAddNewTaskEvent;
use App\Events\AfterCancelTaskAllocateEvent;
use App\Events\AfterTaskAllocateEvent;
use App\Events\AfterValidateAllSchedules;
use App\Http\Resources\Event;
use App\Repositories\CollaboratorRepository;
use App\Repositories\EventRepository;

use Carbon\Carbon;
use Hamcrest\Thingy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Repositories\TaskRepository;


class TasksController extends Controller
{

    /**
     * @var TaskRepository
     */
    protected $repository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(TaskRepository $repository, EventRepository $eventRepository)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_evento)
    {
        $event = $this->eventRepository->find($id_evento);
        $tasks = $this->repository->findWhere(['event_id' => $id_evento]);
        $data = [
            'title' => 'Tarefas do evento - '.$event->denomination,
            'edit' => $this->verifyEdition($event->state_id),
        ];
        $daysArray = $this->taskDays($event->date_time_init, $event->date_time_end); // array dos vários dias
        //$shiftsSchedules = $this->shiftsSchedules($event->date_time_init, $event->date_time_end); //array com a hora inicio e a hora fim
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $data,
            ]);
        }

        //se for admin
        if(Auth::guard('admin')->check()){
            $tasks = $event->tasks;
            $collaborators = [];
            $allCollaborators = Collaborator::all()->where('state', '=', 1);
            foreach ($tasks as $task){
                if($event->state_id == \App\Entities\Event::CONCULIDO || $event->state_id == \App\Entities\Event::ARQUIVADO){
                    // apenas apresenta os alocados
                    if($task->collaborators()->wherePivot('accepted', '1')->wherePivot('confirm_allocation', '1')->get()->count() > 0){
                        $collaborators[$task->id] = $task->collaborators()->wherePivot('accepted', '1')->wherePivot('confirm_allocation', '1')->get()->toArray();
                    }
                }else{
                    if($task->collaborators()->wherePivot('accepted', '1')->get()->count() > 0){
                        $collaborators[$task->id] = $task->collaborators()->wherePivot('accepted', '1')->get()->toArray();
                    }
                }
            }
            return view('admin.event.tasks.index', compact('tasks', 'data', 'event', 'daysArray', 'collaborators', 'allCollaborators'));
        }

        //se for collaborador
        if(Auth::guard('collaborator')->check()){
            $collaborator = Auth::guard('collaborator')->user();
            $teste = $collaborator->tasks()->wherePivot('collaborator_id', $collaborator->id)->get(); //array com disponibilidade sim nao
            $tarefas = [];
            foreach ($teste as $t){
                $tarefas[$t->id] = $t;
            }
            $collaboratorTasks = $collaborator->tasks()->wherePivot('collaborator_id', $collaborator->id)->pluck('accepted', 'task_id'); //array com disponibilidade sim nao
            $collaboratorAllocation = $collaborator->tasks()->wherePivot('collaborator_id', $collaborator->id)->pluck('allocation', 'task_id'); //array com allocação sim nao
            $collaboratorAllocationAcept = $collaborator->tasks()->wherePivot('collaborator_id', $collaborator->id)->pluck('confirm_allocation', 'task_id'); //array com allocação sim nao
            $collaboratorConfirm = $collaborator->tasks()->wherePivot('collaborator_id', $collaborator->id)->wherePivot('allocation', 1)->pluck('confirm_allocation', 'task_id'); //array com confirmação da alocação apos cofirmar disponibilidade e estar alocado
            return view('collaborator.event.tasks.index', compact('tasks', 'tarefas', 'data', 'event', 'daysArray', 'collaboratorTasks', 'collaboratorAllocation', 'collaboratorConfirm', 'collaboratorAllocationAcept'));
        }
    }

    /**
     * @param $event_status
     * @return bool
     */
    private function verifyEdition($event_status){
        if($event_status == \App\Entities\Event::CONCULIDO || $event_status == \App\Entities\Event::ARQUIVADO || $event_status == \App\Entities\Event::CANCELADO){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TaskCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TaskCreateRequest $request)
    {
        try {
            $task = $this->repository->create($request->all());
            if($request->notify){
               $event = new AfterAddNewTaskEvent($task);
               event($event);
            }
            $response = [
                'message' => 'Task created.',
                'data'    => $task->toArray(),
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
     * Update the specified resource in storage.
     *
     * @param  TaskUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(TaskUpdateRequest $request, $id)
    {
        try {
            $task = $this->repository->update($request->all(), $id);
            $response = [
                'message' => 'Tarefa editada com sucesso!',
                'data'    => $task->toArray(),
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
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function taskResponse(Request $request){
        $collaborator = Auth::guard('collaborator')->user();
        $task = $this->repository->find($request->task);
        $accepted = $request->value;
        // verificar se já foi respondido
        $verify = $collaborator->tasks()->wherePivot('task_id', $task->id)->get();
        if(count($verify) > 0){
            $response = [
                'message' => 'Atenção já marcou a sua disponibilidade para esta tarefa',
                'data'    => $task->toArray(),
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        }

        $insert = [
          $task->id => [
              'collaborator_id' => $collaborator->id,
              'accepted' => $accepted
          ]
        ];
        try{
            $task->collaborators()->attach($insert);
            $response = [
                'message' => 'Disponibilidade respondida com sucesso!',
                'data'    => $task->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        }catch (Exception $e){
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
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function taskResponseUpdate(Request $request){
        $collaborator = Auth::guard('collaborator')->user();
        $task = $this->repository->find($request->task);
        $accepted = $request->value;
        if($accepted == 1){
            $update = [
                'accepted' => 0,
                'allocation' => 0,
                'confirm_allocation' => 0
            ];
        }else{
            $update = [
                'accepted' => 1,
            ];
        }
        try{
            $task->collaborators()->updateExistingPivot(['collaborator_id' => $collaborator->id, 'task_id' => $request->id], $update);
            $response = [
                'message' => 'Disponibilidade editada com sucesso!',
                'data'    => $task->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        }catch (Exception $e){
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
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function confirmAllocation(Request $request){
        $collaborator = Auth::guard('collaborator')->user();
        $task = $task = $this->repository->find($request->task);
        $update = [
            'confirm_allocation' => 1
        ];
        try{
            $task->collaborators()->updateExistingPivot(['collaborator_id' => $collaborator->id, 'task_id' => $request->id], $update);
            $response = [
                'message' => 'Obrigado! <br/> Alocação confirmada com sucesso!',
                'data'    => $task->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        }catch (Exception $e){
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
                'message' => 'Task deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Task deleted.');
    }


    /**
     * @param $state
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function changeStatus($state, $id){
       if($state > 1){
           return redirect()->back();
       }elseif($state == 1){
            $state = 0;
        }else{
            $state = 1;
        }
        $task = ['state' => $state];
        try{
            $task = $this->repository->update($task, $id);
            if($state === 1){
                $message = "Tarefa aberta com sucesso";
            }else{
                $message = "Tarefa fechada com sucesso";
            }
            $response = [
                'message' => $message,
                'data'    => $task->toArray(),
            ];
            return redirect()->back()->with('message', $response['message']);
        }catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|string
     */
    public function allocate(Request $request){
        try{
            $allocate = $this->repository->allocate($request->all());

            $response = [
                'message' => 'Alocação cancelada com sucesso!',
            ];
            if ($request->wantsJson()) {
                return json_encode($allocate);
            }
            return redirect()->back()->with('message', $response['message']);


        }catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|string
     */
    public function deallocate(Request $request){
        try{
            $allocate = $this->repository->deallocate($request->all());
            $response = [
                'message' => 'Alocação cancelada com sucesso!',
            ];
            if ($request->wantsJson()) {
                return json_encode($allocate);
            }
            return redirect()->back()->with('message', $response['message']);

        }catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function open_tasks(){
        try{
            $events = $this->eventRepository->with('tasks')->findWhere(['state_id' => \App\Entities\Event::PROCESSADO]);
            return view('collaborator.tasks.open_tasks', compact('events'));
        }catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * @param $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){
        try{
            $task = $this->repository->find($id);
            $collaboratorTasks = $task->collaborators()->wherePivot('task_id', $task->id)->orderBy('date_time_init', 'desc')->pluck('accepted', 'task_id');
            return view('collaborator.tasks.show', compact('task', 'collaboratorTasks'));
        }catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }

    }

    public function confirm_schedule(Request $request){

    }

    //validação por parte da administração, poderá ser uma confirmação caso colaborador nao o tenha feito, assim a confirmação e validação é feita em simultaneo pelo admn
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function validate_schedule(Request $request){
        try{
            $update = $this->repository->validate_schedule($request->all());
            $response = [
                'message' => 'Validação dos hórarios submetida com sucesso!',
                'data'    => $update,
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        }catch (Exception $e){
            dd($e);
        }
    }

    /**
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allocations_not_responded(){
        try{
            $user = Auth::guard('collaborator')->user();
            $collaborator_id = $user->id;
            $pending_tasks = \App\Entities\Task::whereDoesntHave('collaborators', function($q) use($collaborator_id){
                $q->where('collaborator_id', $collaborator_id);
            })->get();
            return view('collaborator.tasks.allocations_not_responded', compact('pending_tasks'));
        }catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * @param Request $request
     */
    public function change_collaborator(Request $request){
        //VERIFICA SE O UTILIZADOR TENTOU ALTERAR PARA O MESMO COLABORADOR
        if($request->collaborator_id == $request->old_id_collaborator){
            $response = [
                'message' => 'Selecione um colaborador diferente do que pretende substituir',
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        }

        $task = $this->repository->with('collaborators')->find($request->task_id);
        $collab = $task->collaborators->where('id', $request->old_id_collaborator);
        $collabToChange = $collab->first();

        try{
            $collabToChange->pivot->delete();
            $newCollabToChange = $collabToChange->pivot;
            $newCollabToChange->collaborator_id = (int)$request->collaborator_id;

            $insert = [
                $task->id => $newCollabToChange->toArray()
            ];
            $task->collaborators()->attach($insert);
            $response = [
                'message' => 'Colaborador substituido com sucesso',
            ];
            //TODO ENVIAR EMAIL COM PEDIDO PARA CONFIRMAR HORARIO
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        }catch (Exception $e){
            return redirect()->back()->with('message', $e->getMessage());
        }

    }

    public function validateAllSchedules($event_id){
        $event =  $this->eventRepository->find($event_id);
        $tasks = $event->tasks()->with('collaborators')->get(); //tarefas associadas ao evento
        // validar horarios dos colaboradores
        try{
            if($tasks->count() > 0){
                foreach ($tasks as $c){

                        $collabs = $c->collaborators()->get();
                        if(count($collabs) > 0){
                            foreach ($collabs as $collab){
                                $attributes = [
                                    "init_time_correction" => $c->init,
                                    "end_time_correction" => $c->end,
                                    "task_id" => $collab->pivot->task_id,
                                    "collaborator_id" => $collab->id,
                                ];
                                $this->repository->validate_schedule($attributes);
                            }
                        }
                }
                $event = new AfterValidateAllSchedules($collabs, $event);
                event($event);
                return redirect()->back()->with('message', 'Todos os horários foram validados');
            }else{
                return redirect()->back()->with('message', 'Não existem hórarios a serem validados');
            }
        }catch(Exception $e){
            return redirect()->back()->with([
                'message_type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }



    private function taskDays($date_init, $date_end){
        $date_init = Carbon::parse($date_init);
        $date_end = Carbon::parse($date_end);
        $diff = $date_end->diffInDays($date_init);
        $days[0] = $date_init->format('Y-m-d');
        for($x = 1; $x <= $diff; $x++){
            $date = $date_init->addDays(1)->format('Y-m-d');
            $days[$x] = $date;
        }
        return $days;
    }

    private function shiftsSchedules($date_time_init, $date_time_end){
        $date_time_init = Carbon::parse($date_time_init);
        $date_time_end = Carbon::parse($date_time_end);
        $time_init = $date_time_init->format('H:i');
        $time_end = $date_time_end->format('H:i');
        return [$time_init, $time_end];
    }
}
