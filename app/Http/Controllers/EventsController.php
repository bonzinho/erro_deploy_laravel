<?php

namespace App\Http\Controllers;

use App\Criteria\FindByInitCriteriaCriteria;
use App\Criteria\FindByYearCriteria;
use App\Entities\Admin;
use App\Entities\Client;
use App\Entities\Collaborator;

use App\Entities\Event;
use App\Entities\Nature;
use App\Events\AfterChangeEventStatusToConcluido;
use App\Events\AfterClientAddEventEvent;
use App\Events\BalanceNotificationEvent;
use App\Events\InternalBalanceCloseEvent;
use App\Events\UploadEventProgramEvent;
use App\Http\Resources\Task;
use App\Listeners\SendEmailToCollaboratorsToSchudlerCorrection;
use App\Mail\EventApproved;
use App\Mail\SendBalanceNotificationToClient;
use App\Repositories\AudiovisualRepository;
use App\Repositories\ClientRepository;
use App\Repositories\GraphicRepository;
use App\Repositories\MaterialRepository;
use App\Repositories\NatureRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\SpaceRepository;

use App\Repositories\SupportRepository;
use App\Repositories\TaskRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Repositories\EventRepository;



class EventsController extends Controller
{

    /**
     * @var EventRepository
     */
    protected $repository;
    /**
     * @var SpaceRepository
     */
    private $space;
    /**
     * @var MaterialRepository
     */
    private $material;
    /**
     * @var GraphicRepository
     */
    private $graphic;
    /**
     * @var AudiovisualRepository
     */
    private $audiovisual;
    /**
     * @var ClientRepository
     */
    private $client;
    /**
     * @var NatureRepository
     */
    private $nature;
    /**
     * @var SupportRepository
     */
    private $suport;
    /**
     * @var ScheduleRepository
     */
    private $scheduleRepository;
    /**
     * @var TaskRepository
     */
    private $taskRepository;


    /**
     * EventsController constructor.
     * @param EventRepository $repository
     * @param SpaceRepository $space
     * @param MaterialRepository $material
     * @param GraphicRepository $graphic
     * @param AudiovisualRepository $audiovisual
     * @param ClientRepository $client
     * @param NatureRepository $nature
     * @param SupportRepository $suport
     * @param ScheduleRepository $scheduleRepository
     * @param TaskRepository $taskRepository
     */
    public function __construct(EventRepository $repository, SpaceRepository $space, MaterialRepository $material, GraphicRepository $graphic, AudiovisualRepository $audiovisual, ClientRepository $client, NatureRepository $nature, SupportRepository $suport, ScheduleRepository $scheduleRepository, TaskRepository $taskRepository)
    {
        $this->repository = $repository;
        $this->space = $space;
        $this->material = $material;
        $this->graphic = $graphic;
        $this->audiovisual = $audiovisual;
        $this->client = $client;
        $this->nature = $nature;
        $this->suport = $suport;
        $this->scheduleRepository = $scheduleRepository;
        $this->taskRepository = $taskRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $events = $this->repository->all();
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $events,
            ]);
        }
        return view('events.index', compact('events'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function create()
    {
        $materials = $this->material->all();
        $spaces = $this->space->all();
        $graphics = $this->graphic->all();
        $audiovisuals = $this->audiovisual->all();

        if (request()->wantsJson()) {

            return response()->json([
                'materials' => $materials,
                'spaces' => $spaces,
                'graphics' => $graphics,
                'audiovisuals' => $audiovisuals
            ]);
        }

        switch (Auth::user()->role){
            case Client::ROLE:
                echo "Cliente";
                break;
            case Admin::ROLE:
                echo "admin";
                break;
            case Collaborator::ROLE;
                echo "collaborador";
                break;
            default:
                echo "default";
                break;
        }

        return view('client.event.index', compact('materials', 'spaces', 'graphs', 'audiovisuals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EventCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EventCreateRequest $request, $type, $login)
    {

        $split = explode('-', $request['date_time_init']);
        $date_init = strtotime(trim($split[0]));
        $date_end = strtotime(trim($split[1]));
        $request['date_time_init'] = date("Y-m-d H:i:s", $date_init);
        $request['date_time_end'] = date("Y-m-d H:i:s", $date_end);

        $dataLogin = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        //verificar se existe um ficheiro
        if(isset($request['doc_program'])){
            $programDocName = md5(trim(time().str_replace(' ','_',$request['denomination']))).'.'.$request['doc_program']->guessExtension();
            //evento para fazer upload do programa se existir
            $uploadProgramEvent = new UploadEventProgramEvent($request['doc_program'], $programDocName);
            event($uploadProgramEvent);
        }else{
            $programDocName = null;
        }

        try{

            if($request['selectAccount'] == 0){ //registar uma conta nova
                $registerArray = [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'address' => $request['address'],
                    'postal_code' => $request['postal_code'],
                    'locality' => $request['locality'],
                    'nif' => $request['nif'],
                    'phone' => $request['phone'],
                    'password' => bcrypt($request['password']),
                    'ac_name' => $request['ac_name'],
                ];

                $client =  $this->client->create($registerArray);


                if($client){
                    $eventToInsert = [
                        'nature_id' => $request['nature_id'],
                        'denomination' => $request['denomination'],
                        'date_time_init' => $request['date_time_init'],
                        'date_time_end' => $request['date_time_end'],
                        'work_plan' => $request['work_plan'],
                        'technical_raider' => $request['technical_raider'],
                        'programme' => $request['programme'],
                        'doc_program' => $programDocName,
                        'notes' => $request['notes'],
                        'number_participants' => $request['number_participants'],
                        'client_id' => $client->id,
                    ];

                    $eventAdded = $this->repository->create($eventToInsert);
                    $event = new AfterClientAddEventEvent($eventAdded, $client);
                    event($event);
                }


                Auth::guard('client')->attempt($dataLogin, false);



            }else{
                ################## LOGIN ########################

                try {
                    $login = Auth::guard('client')->attempt($dataLogin, false);
                    if(!$login) return redirect()->back()->with('message', 'Email ou Senha errados, por favor tente novamente!');
                } catch (ValidatorException $e) {
                    dd($e->getMessage());
                }

                $eventToInsert = [
                    'nature_id' => $request['nature_id'],
                    'denomination' => $request['denomination'],
                    'date_time_init' => $request['date_time_init'],
                    'date_time_end' => $request['date_time_end'],
                    'work_plan' => $request['work_plan'],
                    'technical_raider' => $request['technical_raider'],
                    'programme' => $request['programme'],
                    'doc_program' => $programDocName,
                    'notes' => $request['notes'],
                    'number_participants' => $request['number_participants'],
                    'client_id' => Auth::guard('client')->user()->id,
                ];


                $eventAdded = $this->repository->create($eventToInsert);
                $event = new AfterClientAddEventEvent($eventAdded, Auth::guard('client')->user());
                event($event);
            }

        }catch (Exception $e){
            return redirect()->back()->with('message', $e->getMessage());
        }

        $eventAdded->supports()->sync($request['support_id']); // Adiciona os suportes
        $eventAdded->spaces()->sync($request['space_id']); // Adiciona os suportes
        $eventAdded->graphics()->sync($request['graphic_id']); // Adiciona os suportes
        $eventAdded->audiovisuals()->sync($request['audiovisual_id']); // Adiciona os suportes
        $eventAdded->materials()->sync($this->getIdAndQuantityArray($request['material_id'], $request['material_quantity']));
        return redirect()->route('client.home');

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id, $guard)
    {
        if(!Auth::guard($guard)->check())  return redirect()->back()->with('message', 'Sem permissões');
        $event = $this->repository->find($id);
        $data = ['title' => $event->denomination];
        switch ($guard){
            case Admin::ROLE:
                if(!Auth::guard($guard)->check()) return redirect()->back()->with('message', 'Sem permissões');
                return view('admin.event.show', compact('event', 'data'));
                break;
            case Client::ROLE:
                if(!Auth::guard($guard)->check()) return redirect()->back()->with('message', 'Sem permissões');
                $user = Auth::guard($guard)->user();
                if($event->client_id === $user->id){
                    return view('client.event.show', compact('event', 'data'));
                }else{
                    return redirect()->back()->with('message', 'Sem permissões');
                }
                break;
            case Collaborator::ROLE:
                if(!Auth::guard($guard)->check()) return redirect()->back()->with('message', 'Sem permissões');
                $user = Auth::guard($guard)->user();
                return view('collaborator.event.show', compact('event', 'data'));
                break;
            default:
                break;
        }

        $event = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $event,
            ]);
        }

        return view('events.show', compact('event'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @param string $guard
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $guard)
    {
        if(!Auth::guard($guard)->check())  return redirect()->back()->with('message', 'Sem permissões');
        if($this->repository->find($id)->state_id >= Event::CONCULIDO){
            return redirect()->route('admin.events.show',[$id, $guard]);
        }

        $materiais = $this->material->all();
        $espacos = $this->space->all();
        $graphics = $this->graphic->all();
        $audiovisuals = $this->audiovisual->all();
        $naturezas = $this->nature->all();
        $apoios = $this->suport->all();
        $event = $this->repository->find($id);
        $event['date_time_init'] = \Carbon\Carbon::parse($event['date_time_init'])->format('d/m/Y H:m'). ' - ' . \Carbon\Carbon::parse($event['date_time_end'])->format('d/m/Y H:m');
        $selectedSupports = [];
        $x = 0;
        foreach ($event->supports as $support){
            $selectedSupports[$x] = $support->id;
            $x++;
        }

        $selectedSpaces = [];
        $x = 0;
        foreach ($event->spaces as $space){
            $selectedSpaces[$x] = $space->id;
            $x++;
        }

        $selectedMaterial = [
            'id' => [],
            'quantity' => [],
        ];
        $x = 0;
        foreach ($event->materials as $material){
            $selectedMaterial['id'][$x] = $material->id;
            $selectedMaterial['quantity'][$x] = $material->pivot->quantity;
            $x++;
        }

        $selectedGraphs = [];
        $x = 0;
        foreach ($event->graphics as $graphic){
            $selectedGraphs[$x] = $graphic->id;
            $x++;
        }

        $selectedAudiovisuals = [];
        $x = 0;
        foreach ($event->graphics as $audiovisual){
            $selectedAudiovisuals[$x] = $audiovisual->id;
            $x++;
        }

        $data = ['title' => 'Editar '.$event->denomination];
        switch ($guard){
            case Admin::ROLE:
                return view('admin.event.edit', compact( 'event', 'data', 'materiais', 'selectedMaterial', 'espacos', 'selectedSpaces', 'graphics', 'selectedGraphs', 'audiovisuals', 'selectedAudiovisuals', 'naturezas', 'apoios', 'selectedSupports'));
                break;
            case Client::ROLE:
                break;
            case Collaborator::ROLE:
                break;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EventUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(EventUpdateRequest $request, $id)
    {
        try {
            if(auth(Admin::ROLE)->check()){
                $event = $this->repository->update($request->all(), $id);
                $route = 'admin.events.show';
                $guard = Admin::ROLE;
            }elseif (auth(Client::ROLE)->check()){
                $event = $this->repository->update($request->all(), $id);
                $route = 'client.events.show';
                $guard = Client::ROLE;
            }else{
                return redirect()->back()->with('message', 'Sem permissões');
            }

            $response = [
                'message' => 'Evento editado com sucesso',
                'data'    => $event->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            return redirect()->route($route, ['id' => $event->id, $guard])->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->route($route, ['id' => $event->id, $guard]);
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
                'message' => 'Event deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Event deleted.');
    }


    /**
     * @param string $type
     * @param $guard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function eventList($type = 'pending', $guard){

        //verifica se realmente é o guard indicado

        if(!Auth::guard($guard)->check())  return redirect()->back()->with('message', 'Sem permissões');

        switch ($guard){
            case Client::ROLE:
                $user = Auth::guard($guard)->user();
                switch ($type){
                    case 'pending':
                        $events = $this->repository->findWhere(['client_id' => $user->id, 'state_id' => Event::PENDENTE]);
                        $data = [
                            'title' => 'Eventos Pendentes'
                        ];
                        break;
                    case 'approved':
                        $events = $this->repository->findWhere(['client_id' => $user->id, 'state_id' => Event::PROCESSADO]);
                        $data = [
                            'title' => 'Eventos Aprovados'
                        ];
                        break;
                    case 'completed':
                        $events = $this->repository->findWhere(['client_id' => $user->id, 'state_id' => Event::CONCULIDO]);
                        $data = [
                            'title' => 'Eventos concluídos'
                        ];
                        break;
                    case 'filled':
                        $events = $this->repository->findWhere(['client_id' => $user->id, 'state_id' => Event::ARQUIVADO]);
                        $data = [
                            'title' => 'Eventos Arquivados'
                        ];
                        break;
                    case 'canceled':
                        $events = $this->repository->findWhere(['client_id' => $user->id, 'state_id' => Event::CANCELADO]);
                        $data = [
                            'title' => 'Eventos cancelados'
                        ];
                        break;
                }
                return view('client.event.list', compact('events', 'data'));
                break;
            case Admin::ROLE:
                switch ($type){
                    case 'pending':
                        $events = $this->repository->findWhere(['state_id' => Event::PENDENTE]);
                        $data = [
                            'title' => 'Eventos Pendentes'
                        ];
                        break;
                    case 'approved':
                        $events = $this->repository->findWhere(['state_id' => Event::PROCESSADO]);
                        $data = [
                            'title' => 'Eventos Aprovados'
                        ];
                        break;
                    case 'completed':
                        $events = $this->repository->findWhere(['state_id' => Event::CONCULIDO]);
                        $data = [
                            'title' => 'Eventos Concluídos'
                        ];
                        break;
                    case 'filled':
                        $events = $this->repository->findWhere(['state_id' => Event::ARQUIVADO]);
                        $data = [
                            'title' => 'Eventos Arquivados'
                        ];
                        break;
                    case 'canceled':
                        $events = $this->repository->findWhere(['state_id' => Event::CANCELADO]);
                        $data = [
                            'title' => 'Eventos Cancelados'
                        ];
                        break;
                    default:
                        $events = $this->repository->all();
                        break;
                }
                return view('admin.event.list', compact('events', 'data'));
                break;
            case Collaborator::ROLE:
                if(!Auth::guard($guard)->check()) return redirect()->back()->with('message', 'Não tem autorização');
                switch ($type){
                    case 'approved':
                        $events = $this->repository->findWhere(['state_id' => Event::PROCESSADO]);
                        $data = [
                            'title' => 'Eventos Aprovados'
                        ];
                        break;
                    case 'completed':
                        $events = $this->repository->findWhere(['state_id' => Event::CONCULIDO]);
                        $data = [
                            'title' => 'Eventos Concluídos'
                        ];
                        break;
                    case 'filled':
                        $events = $this->repository->findWhere(['state_id' => Event::ARQUIVADO]);
                        $data = [
                            'title' => 'Eventos Arquivados'
                        ];
                        break;
                    case 'canceled':
                        $events = $this->repository->findWhere(['state_id' => Event::CANCELADO]);
                        $data = [
                            'title' => 'Eventos Cancelados'
                        ];
                        break;
                    case 'pending':
                        return redirect()->back()->with('message', 'Não tem permissões!');
                        break;
                    default:
                        $events = $this->repository->all();
                        break;
                }
                return view('collaborator.event.list', compact('events', 'data'));
                break;
        }
    }

    /**
     * @param $id
     * @param $state
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($id, $state){
        //Permissoes
        $admin = Auth::user();
        switch ($state){
            case Event::PROCESSADO:
                if(!$admin->hasPermissionTo('accept event'))
                    return redirect()->back()->with([
                        'message_type' => 'error',
                        'message' => 'Sem autorização!',
                    ]);
                break;
            case Event::CONCULIDO:
                if(!$admin->hasPermissionTo('finish event'))
                    return redirect()->back()->with([
                        'message_type' => 'error',
                        'message' => 'Sem autorização!',
                    ]);
                break;
            case Event::ARQUIVADO:
                if(!$admin->hasPermissionTo('archive event'))
                    return redirect()->back()->with([
                        'message_type' => 'error',
                        'message' => 'Sem autorização!',
                    ]);
                break;
            case Event::CANCELADO:
                if(!$admin->hasPermissionTo('cancel event'))
                    return redirect()->back()->with([
                        'message_type' => 'error',
                        'message' => 'Sem autorização!',
                    ]);
                break;
        }


        try{
            $event = $this->repository->changeStatus(['state_id' => $state], $id);
            switch ($state){
                case Event::PROCESSADO:
                    Mail::to($event->client->email)->send(New EventApproved($event, $event->client));
                    break;
                case Event::CONCULIDO:
                    $Event = new AfterChangeEventStatusToConcluido($event);
                    event($Event);
                    break;
                case Event::ARQUIVADO:
                    // se no upddate do estado for retornado false significa que existe um balancete por fazer
                    if(!$event){
                        return redirect()->back()->with([
                            'message_type' => 'success',
                            'message' => 'ATENÇÃO!! Falta fechar um balancete.',
                        ]);
                    }

                    $event =  $this->repository->find($id);
                    $task = $event->tasks()->with('collaborators')->get(); //tarefas associadas ao evento
                    // validar horarios dos colaboradores
                    foreach ($task as $c){
                        try{
                            $collabs = $c->collaborators()->get();
                            if(count($collabs) > 0){
                                foreach ($collabs as $collab){
                                    $attributes = [
                                        "init_time_correction" => $c->init,
                                        "end_time_correction" => $c->end,
                                        "task_id" => $collab->pivot->task_id,
                                        "collaborator_id" => $collab->id,
                                    ];
                                    $this->taskRepository->validate_schedule($attributes);
                                }
                            }
                        }catch(Exception $e){
                            return redirect()->back()->with([
                                'message_type' => 'error',
                                'message' => $e->getMessage(),
                            ]);
                        }
                    }
                    break;
                case Event::CANCELADO:
                    //TODO Enviar email para cliente & para colaboradores caso existam
                    break;
                default:
                    back();
            }
            return redirect()->back()->with([
                'message_type' => 'success',
                'message' => 'Estado do evento "'.$event->denomination .'" Alterado com successo',
            ]);



        }catch (Exception $e){
            return redirect()->back()->with([
                'message_type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function spaces($id_evento){
        $event = $this->repository->find($id_evento);
        $data = [
            'title' => 'Agendar espaços - '.$event->denomination,
        ];
        $daysArray = $this->eventDays($event->date_time_init, $event->date_time_end); // array dos vários dias
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $event,
            ]);
        }
        return view('admin.event.spaces.index', compact('data', 'event', 'daysArray'));
    }

    public function eventSpacesCollaborator($id){
        $event = $this->repository->find($id);
        $data = [
            'title' => 'Espaços do evento - '.$event->denomination,
        ];
        $daysArray = $this->eventDays($event->date_time_init, $event->date_time_end); // array dos vários dias
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $event,
            ]);
        }
        return view('collaborator.event.spaces.index', compact('data', 'event', 'daysArray'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function close_sche_balance($id){
        $event = $this->repository->with('recipes')->with('expenses')->find($id);
        //if(!$event->balance_acepted_client){
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => "Atenção Receitas ainda não aprovadas pelo cliente!"
                ]);
            }
        //}
        if($event->technic_balancete == true){ //Verifica se o balancete de agenda já foi fechado
            $data = [
                'total_recipes' => $this->getTotal($event->recipes),
                'total_expenses' => $this->getTotal($event->expenses),
                'schedule_balancete' => true,
            ];
        }else{
            $data = [
                'schedule_balancete' => true,
            ];
        }

        try{
            $update = $this->repository->update($data, $id);
            if (request()->wantsJson()) {
                return response()->json([
                    'data' => $update
                ]);
            }
        }catch (Exception $e){
            return redirect()->back()->with([
                'message_type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function close_tech_balance($id){
        $event = $this->repository->with('recipes')->with('expenses')->find($id);
        //if(!$event->balance_acepted_client){
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => "Atenção Receitas ainda não aprovadas pelo cliente!"
                ]);
            }
        //}
        if($event->schedule_balancete == true){ //Verifica se o balancete de agenda já foi fechado
            $data = [
              'total_recipes' => $this->getTotal($event->recipes),
              'total_expenses' =>  $this->getTotal($event->expenses),
              'technic_balancete' => true,
            ];

        }else{
            // apenas dizer que o baancete tecnico fecha
            $data = [
                'technic_balancete' => true,
            ];
        }

        try{
            $update = $this->repository->update($data, $id);
            if (request()->wantsJson()) {
                return response()->json([
                    'data' => $update
                ]);
            }
        }catch (Exception $e){
            return redirect()->back()->with([
                'message_type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function balance_state($id){
        try{
            $event = $this->repository->find($id);
            $tech = $event->technic_balancete;
            $sche = $event->schedule_balancete;
            if (request()->wantsJson()) {
                return response()->json([
                    'tech' => $tech,
                    'sche' => $sche,
                ]);
            }
        }catch (Exception $e){
            return redirect()->back()->with([
                'message_type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function balance_notify_client($event_id){
        try{
            $event = $this->repository->with(['client', 'recipes'])->find($event_id);
            $recipes_total = $this->getTotal($event->recipes);

            if(!$event->close_internal_tech_balance || ! $event->close_internal_sche_balance){

                return redirect()->back()->with([
                    'message' => 'Atenção falta fechar os balançoes interno (Balanço técnico ou Balanço de agenda)!',
                ]);
            }


            $notifyEvent = new BalanceNotificationEvent($event, $recipes_total);
            event($notifyEvent);
            $data = [
                'balance_notify_client' => 1,
            ];

            $this->repository->update($data, $event_id);

            if (request()->wantsJson()) {
                return response()->json([
                    'msg' => 'Notificação enviada com sucesso!!',
                    'balance_notify_client' => $event->balance_notify_client,
                    'balance_acepted_client' => $event->balance_acepted_client,
                ]);
            }

            return redirect()->back()->with([
                'message' => 'Cliente notificado com sucesso',
            ]);

        }catch (Exception $e){

            return redirect()->back()->with([
                'message_type' => 'error',
                'message' => $e->getMessage(),
            ]);

        }

    }


    public function close_internal_tech_balance($event_id){
        $event = $this->repository->find($event_id);
        try{
            $update = $this->repository->update(['close_internal_tech_balance' => true], $event_id);
            if($event->close_internal_sche_balance){
                //se o balanço interno de agenda tb já estiver fechado enviar email para gestor financeiro a avisar que pode atualizar a sua parte,
                $_event = new InternalBalanceCloseEvent($event);
                event($_event);
            }
            return redirect()->back()->with([
                'message_type' => 'success',
                'message' => 'Balanço interno fechado com sucesso',
            ]);
        }catch (Exception $e){
            return redirect()->back()->with([
                'message_type' => 'error',
                'message' => 'ERRO!! por favor tente novamente',
            ]);
        }
    }

    public function close_internal_sche_balance($event_id){
        $event = $this->repository->find($event_id);
        try{
            $update = $this->repository->update(['close_internal_sche_balance' => true], $event_id);
            if($event->close_internal_tech_balance){
                //se o balanço interno de agenda tb já estiver fechado enviar email para gestor financeiro a avisar que pode atualizar a sua parte,
                $_event = new InternalBalanceCloseEvent($event);
                event($_event);
            }
            return redirect()->back()->with([
                'message_type' => 'success',
                'message' => 'Balanço interno fechado com sucesso',
            ]);
        }catch (Exception $e){
            return redirect()->back()->with([
                'message_type' => 'error',
                'message' => 'ERRO!! por favor tente novamente',
            ]);
        }
    }


    public function currentBalance(){
        $this->repository->pushCriteria(new FindByInitCriteriaCriteria());
        $events = $this->repository->all();
        $expenses = $events->sum('total_expenses');
        $recipes = $events->sum('total_recipes');
        $num_event = $events->count();

        $months = [
            'janeiro' => $this->getNumOfEventsAndBalanceFromMonth(1),
            'fevereiro' => $this->getNumOfEventsAndBalanceFromMonth(2),
            'marco' => $this->getNumOfEventsAndBalanceFromMonth(3),
            'abril' => $this->getNumOfEventsAndBalanceFromMonth(4),
            'maio' => $this->getNumOfEventsAndBalanceFromMonth(5),
            'junho' => $this->getNumOfEventsAndBalanceFromMonth(6),
            'julho' => $this->getNumOfEventsAndBalanceFromMonth(7),
            'agosto' => $this->getNumOfEventsAndBalanceFromMonth(8),
            'setembro' => $this->getNumOfEventsAndBalanceFromMonth(9),
            'outubro' => $this->getNumOfEventsAndBalanceFromMonth(10),
            'novembro' => $this->getNumOfEventsAndBalanceFromMonth(11),
            'dezembro' => $this->getNumOfEventsAndBalanceFromMonth(12),
        ];


        return view('admin.financials.events.current_year', compact('events', 'expenses', 'recipes', 'num_event', 'months'));

    }

    private function getNumOfEventsAndBalanceFromMonth($mes){
        $year = Carbon::now()->format('Y');
        $events = $this->repository->findWhere([
            ['date_time_init', '>', $year.'-'.$mes.'-1'],
            ['date_time_init', '<=', $year.'-'.$mes.'-31'],
        ]);

        $month = [];
        $recipes = 0;
        $expenses = 0;

        foreach ($events as $event){
            $recipes += $event->total_recipes;
            $expenses += $event->total_expenses;
        }

        return $month = [
            'num_evento' => $events->count(),
            'balanco' =>  $recipes - $expenses,
        ];
    }


    /**
     * @param $ids
     * @param $quantitys
     * @return array
     */
    private function getIdAndQuantityArray($ids, $quantitys){
        $quantity = [];
        $x = 0;
        for ($i = 0; $i < count($quantitys); $i++){
            if($quantitys[$i] !== null) {
                $quantity[$x] = $quantitys[$i];
                $x++;
            }
        }
        $returnArray = [];
        for($i = 0; $i < count($ids); $i++){
            $returnArray[$i] = [
                'material_id' => $ids[$i],
                'quantity' => $quantity[$i],
            ];
        }
        return $returnArray;
    }


    /**
     * @param $date_init
     * @param $date_end
     * @return mixed
     */
    private function eventDays($date_init, $date_end){
        $date_init = Carbon::parse($date_init);
        $date_end = Carbon::parse($date_end);

        $diff = $date_end->diffInDays($date_init);

        $days[0] = $date_init->format('d-m-Y');
        $last_date = $date_init;
        for($x = 1; $x <= $diff; $x++){
            $date = $date_init->addDays(1)->format('d-m-Y');
            $days[$x] = $date;
            $last_date = $date;
        }
        return $days;
    }


    /**
     * @param $values
     * @return int
     */
    private function getTotal($values){
        $total = 0;
        foreach ($values as $value){
            $total += $value->value;
        }
        return $total;
    }


}
