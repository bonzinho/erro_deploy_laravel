<?php

namespace App\Http\Controllers;

use App\Entities\Expense;
use App\Repositories\EventRepository;

use Mockery\Exception;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ExpenseCreateRequest;
use App\Http\Requests\ExpenseUpdateRequest;
use App\Repositories\ExpenseRepository;


class ExpensesController extends Controller
{

    /**
     * @var ExpenseRepository
     */
    protected $repository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * ExpensesController constructor.
     * @param ExpenseRepository $repository
     * @param EventRepository $eventRepository
     */
    public function __construct(ExpenseRepository $repository, EventRepository $eventRepository)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $event = $this->eventRepository->with(['expenses'])->find($event_id);
        $expenses = $event->expenses;

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $expenses,
            ]);
        }
        return view('admin.event.balance.expenses', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ExpenseCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseCreateRequest $request)
    {
        try {
            $expense = $this->repository->create($request->all());
            $response = [
                'message' => 'Despesa adicionada com sucesso',
                'data'    => $expense->toArray(),
            ];

            $event = $this->eventRepository->with(['expenses'])->find($request->event_id);
            $expenses = $event->expenses;

            if ($request->wantsJson()) {
                return response()->json([
                        'data' => $expenses,
                    ]);
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
     * @param  ExpenseUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(ExpenseUpdateRequest $request, $id)
    {
        try {
            $expense = $this->repository->update($request->all(), $id);
            $event = $this->eventRepository->with(['expenses'])->find($expense->event_id);
            $expenses = $event->expenses;

            if ($request->wantsJson()) {
                return response()->json([
                    'data' => $expenses
                ]);
            }


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
    public function destroy($id, $event_id)
    {
        $deleted = $this->repository->delete($id);
        $event = $this->eventRepository->with(['expenses'])->find($event_id);
        $expenses = $event->expenses;
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $expenses
            ]);
        }
        return redirect()->back()->with('message', 'Expense deleted.');
    }

    public function total($event_id){
        $event = $this->eventRepository->with(['expenses'])->find($event_id);
        $expenses = $event->expenses;
        $total = 0;
        foreach ($expenses as $expense){
            $total += $expense->value;
        }
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $total,
            ]);
        }
        return $total;
    }


    /**
     * @param $event_id
     */
    public function addCollabExpenses($event_id){
        try{
            $event = $this->eventRepository->with('tasks')->find($event_id);
            $total = 0;
            $horas = 0;
            $extras = 0;
            foreach ($event->tasks as $task){
                foreach ($task->collaborators as $collab){
                    $total += $collab->pivot->normal_hour_value_total + $collab->pivot->extra_hour_value_total;
                    $horas += $collab->pivot->total_normal_hour;
                    $extras += $collab->pivot->total_extra_hour;
                }
            }
            $attributes = [
                'event_id' => $event->id,
                'description' => 'Apoio técnico/hospedeiros, ('.$horas.' horas + '.$extras.' horas extras )',
                'value' => $total,
                'group' => Expense::GESTAO_TECNICA,
            ];
            $this->repository->create($attributes);
            return redirect()->back()->with([
                'message' => 'Despesas Adicionadas com sucesso',
            ]);
        }catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }
}
