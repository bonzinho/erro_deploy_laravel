<?php

namespace App\Http\Controllers;

use App\Criteria\FindByThisWeekCriteria;
use App\Criteria\FindByYearCriteria;
use App\Criteria\OnlyShowActiveCriteriaCriteria;
use App\Criteria\OrderByDateCriteria;
use App\Entities\Collaborator;
use App\Entities\Financial;
use App\Events\AfterCollaboratorSignInEvent;
use App\Events\SendDynamicEmailEvent;
use App\Mail\SendMsgToCollaborator;
use App\Repositories\EventRepository;
use App\Repositories\FinancialRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CollaboratorCreateRequest;
use App\Http\Requests\CollaboratorUpdateRequest;
use App\Repositories\CollaboratorRepository;
use App\Validators\CollaboratorValidator;


class CollaboratorsController extends Controller
{

    /**
     * @var CollaboratorRepository
     */
    protected $repository;
    /**
     * @var Financial
     */
    private $financial;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(CollaboratorRepository $repository, FinancialRepository $financial, EventRepository $eventRepository)
    {
        $this->repository = $repository;
        $this->financial = $financial;
        $this->eventRepository = $eventRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users[] = Auth::user();
        $users[] = Auth::guard()->user();
        $users[] = Auth::guard('collaborator')->user();
        $data = [
            'title' => 'Bem Vindo à plataforma Centro de Eventos da FEUP'
        ];

        $collaborator_id = $users[0]['id'];
        $tasks = \App\Entities\Task::with(['*'])->where('state', 1)->count();
        $events = $this->eventRepository->pushCriteria(new FindByThisWeekCriteria())->pushCriteria(New OrderByDateCriteria())->all();
        //verificar quantas tasks existem em que o colaborador ainda não respondeu
        $pending_tasks = \App\Entities\Task::whereDoesntHave('collaborators', function($q) use($collaborator_id){
            $q->where('collaborator_id', $collaborator_id);
        })->get()->count();
        return view('collaborator.home', compact('data', 'pending_tasks', 'tasks', 'events'));
    }

    /**
     *
     */
    public function create(){
        return view('admin.collaborators.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CollaboratorCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CollaboratorCreateRequest $request)
    {
        try {
            $collaborator = $this->repository->create($request->all());
            $response = [
                'message' => 'Collaborator created.',
                'data'    => $collaborator->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::guard('collaborator')->user()){
            return redirect()->back();
        }
        $collaborator = $this->repository->find($id);
        $collaborator = $this->repository->with(['tasks'])->find($id);

        //verifica o valor total do pagamentos pendente
        $tasksWithoutPayment = $collaborator->tasks()
            ->wherePivot('collaborator_id', $id)
            ->wherePivot('accepted', 1)
            ->wherePivot('confirm_allocation', 1)
            ->wherePivot('validate_confirm_schedule', 1)
            ->wherePivot('payment', 0)
            ->wherePivot('allocation', 1)->get();

        $x = 0;
        $arrayToCalculeValue = [];
        foreach ($tasksWithoutPayment as $task){
            $arrayToCalculeValue[$x]['payment'] = $task->pivot->normal_hour_value_total + $task->pivot->extra_hour_value_total;
            $x++;
        }
        $totalPaymentPending = $this->getTotalPayments($arrayToCalculeValue);
        //total pagamento feitos de sempre
        $total =  $this->getTotalPayments($this->financial->all()->toArray());
        //total dos pagamentos feitos este ano
        $totalYear = $this->getTotalPayments($this->financial->pushCriteria(new FindByYearCriteria())->all()->toArray(9));

        $collaborator->totalPaymentPending = $totalPaymentPending;
        $collaborator->total = $total;
        $collaborator->totalYear = $totalYear;
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $collaborator,
            ]);
        }
        return view('collaborator.settings.show', compact('collaborator'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function showAdmin($id)
    {
        if(!Auth::guard('admin')->user()){
            return redirect()->back();
        }

        $collaborator = $this->repository->with(['tasks'])->find($id);

        //verifica o valor total do pagamentos pendente
        $tasksWithoutPayment = $collaborator->tasks()
            ->wherePivot('collaborator_id', $id)
            ->wherePivot('accepted', 1)
            ->wherePivot('confirm_allocation', 1)
            ->wherePivot('validate_confirm_schedule', 1)
            ->wherePivot('payment', 0)
            ->wherePivot('allocation', 1)->get();

        $x = 0;
        $arrayToCalculeValue = [];
        foreach ($tasksWithoutPayment as $task){
            $arrayToCalculeValue[$x]['payment'] = $task->pivot->normal_hour_value_total + $task->pivot->extra_hour_value_total;
            $x++;
        }
        $totalPaymentPending = $this->getTotalPayments($arrayToCalculeValue);
        //total pagamento feitos de sempre
        $total =  $this->getTotalPayments($this->financial->all()->toArray());
        //total dos pagamentos feitos este ano
        $totalYear = $this->getTotalPayments($this->financial->pushCriteria(new FindByYearCriteria())->all()->toArray(9));

        $collaborator->totalPaymentPending = $totalPaymentPending;
        $collaborator->total = $total;
        $collaborator->totalYear = $totalYear;

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $collaborator,
            ]);
        }
        return view('admin.collaborators.show', compact('collaborator'));
    }

    private function getTotalPayments($arrayWithValues){
        $total = 0;
        for($x = 0; $x < count($arrayWithValues); $x++){
            $total += $arrayWithValues[$x]['payment'];
        }
        return $total;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $collaborator = $this->repository->find($id);
        return view('collaborators.edit', compact('collaborator'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  CollaboratorUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(CollaboratorUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $collaborator = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Collaborator updated.',
                'data'    => $collaborator->toArray(),
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
                'message' => 'Collaborator deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Collaborator deleted.');
    }

    /**
     * @param $id
     */
    public function deactivate($id){
        try{
            $collab = $this->repository->update(['state' => 0], $id);
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'Colaborador desativado com sucesso',
                    'deleted' => $collab,
                ]);
            }

            return redirect()->back()->with('message', 'Colaborador desativado com sucesso');

        }catch (Exception $e){
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request, $id){
        $collaborator = $this->repository->find($id);
        try{
            Mail::to($collaborator->email)->send(new SendMsgToCollaborator($request->subject, $request->message));
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'Mensagem enviada com sucesso',
                    'deleted' => $collaborator,
                ]);
            }
            return redirect()->back()->with('message', 'Mensagem enviada com sucesso!!');
        }catch (Exception $e){
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     */
    public function activate($id){
        try{
            $collab = $this->repository->update(['state' => 1], $id);
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'Colaborador desativado com sucesso',
                    'deleted' => $collab,
                ]);
            }

            return redirect()->back()->with('message', 'Colaborador desativado com sucesso');

        }catch (Exception $e){
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function listActive(){
        $collaborators = $this->repository->pushCriteria(new OnlyShowActiveCriteriaCriteria())->all();
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $collaborators,
            ]);
        }
        return view('admin.collaborators.list', compact('collaborators'));
    }

    public function dynamicEmail(){
        return view('admin.collaborators.dynamic-email');
    }

    public function dynamicEmailSend(Request $request){
        $event = new SendDynamicEmailEvent($request->all());
        event($event);
        return view('admin.collaborators.dynamic-email');
    }
}
