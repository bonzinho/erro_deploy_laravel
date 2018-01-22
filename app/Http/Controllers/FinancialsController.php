<?php

namespace App\Http\Controllers;

use App\Events\PaymentEvent;
use App\Http\Requests\FinancialUpdateRequest;
use App\Repositories\CollaboratorRepository;
use App\Repositories\EventRepository;
use App\Repositories\TaskRepository;
use Mockery\Exception;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FinancialCreateRequest;
use App\Repositories\FinancialRepository;
use App\Validators\FinancialValidator;


class FinancialsController extends Controller
{

    /**
     * @var FinancialRepository
     */
    protected $repository;
    /**
     * @var CollaboratorRepository
     */
    private $collaboratorRepository;
    /**
     * @var TaskRepository
     */
    private $taskRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * FinancialsController constructor.
     * @param FinancialRepository $repository
     * @param CollaboratorRepository $collaboratorRepository
     * @param TaskRepository $taskRepository
     */
    public function __construct(FinancialRepository $repository, CollaboratorRepository $collaboratorRepository, TaskRepository $taskRepository, EventRepository $eventRepository)
    {
        $this->repository = $repository;
        $this->collaboratorRepository = $collaboratorRepository;
        $this->taskRepository = $taskRepository;
        $this->eventRepository = $eventRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $financials = $this->repository->with('collaborator')->all();
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $financials,
            ]);
        }
        return view('admin.financials.list', compact('financials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FinancialCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(FinancialCreateRequest $request)
    {
        $tasks =  $this->collaboratorRepository->with('tasks')->all();
        $collab = $this->collaboratorRepository->find($request->collaborator_id);
        try {
            $financial = $this->repository->create($request->all());
            $event = new PaymentEvent($request->receipt, $financial, $tasks, $collab);
            event($event);
            $response = [
                'message' => 'Pagamento processado com sucesso',
                'data'    => $financial->toArray(),
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

    public function payments(){
        $collaborators = $this->collaboratorRepository->with('tasks')->all();
        foreach ($collaborators as $c){
            $total = 0;
            $horasExtras = 0;
            $horasNormais = 0;
            $pay = 0;
            $tasks = $c->tasks()->wherePivot('allocation', 1)
                ->wherePivot('accepted', 1)
                ->wherePivot('confirm_allocation', 1)
                ->wherePivot('payment', 0)
                ->get();
            for($y = 0; $y < count($tasks); $y++){
                $horasExtras += $tasks[$y]->pivot->total_extra_hour;
                $horasNormais += $tasks[$y]->pivot->total_normal_hour;
                $total += $tasks[$y]->pivot->normal_hour_value_total;
                $total += $tasks[$y]->pivot->extra_hour_value_total;
            }
            $c->toPay = $total;
            $c->horasExtras = $horasExtras;
            $c->horasNormais = $horasNormais;

            $tasks = $c->tasks()->wherePivot('allocation', 1)
                ->wherePivot('accepted', 1)
                ->wherePivot('confirm_allocation', 1)
                ->wherePivot('payment', 1)
                ->get();
            for($y = 0; $y < count($tasks); $y++){
                $pay += $tasks[$y]->pivot->normal_hour_value_total;
                $pay += $tasks[$y]->pivot->extra_hour_value_total;
            }
            $c->pay = $pay;
        }
        return view('admin.financials.payments', compact('collaborators'));
    }


    public function update(FinancialUpdateRequest $request, $id){
       try{
           $this->repository->update($request->all(), $id);
           $response = [
               'message' => 'Recibo adicionado com sucesso',
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

}
