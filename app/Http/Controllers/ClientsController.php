<?php

namespace App\Http\Controllers;

use App\Criteria\FindByThisWeekCriteria;
use App\Criteria\OrderByDateCriteria;
use App\Entities\Event;
use App\Repositories\EventRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ClientCreateRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Repositories\ClientRepository;


class ClientsController extends Controller
{

    /**
     * @var ClientRepository
     */
    protected $repository;
    /**
     * @var EventRepository
     */
    private $eventRepository;


    /**
     * ClientsController constructor.
     * @param ClientRepository $repository
     * @param EventRepository $eventRepository
     */
    public function __construct(ClientRepository $repository, EventRepository $eventRepository)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = Auth::guard('client')->user();
        $penddingEvents = $this->eventRepository->findWhere(['state_id' => Event::PENDENTE, 'client_id' => $client->id])->count();
        $aprovedEvents = $this->eventRepository->findWhere(['state_id' => Event::PROCESSADO, 'client_id' => $client->id])->count();
        $completeEvents = $this->eventRepository->findWhere(['state_id' => Event::CONCULIDO, 'client_id' => $client->id])->count();
        $filledEvents = $this->eventRepository->findWhere(['state_id' => Event::ARQUIVADO, 'client_id' => $client->id])->count();
        $data = [
            'title' => 'Bem vindo à plataforma do Centro de Eventos da FEUP',
        ];

        $events = $this->eventRepository->pushCriteria(new FindByThisWeekCriteria())->pushCriteria(New OrderByDateCriteria())->findWhere(['client_id' => $client->id]);
        if (request()->wantsJson()) {

            return response()->json([
                'data' => $data,
                'penddingEvents' => $penddingEvents,
                'aprovedEvents' => $aprovedEvents,
                'completeEvents' => $completeEvents,
                'filledEvents' => $filledEvents
            ]);
        }
        return view('client.home', compact('events', 'penddingEvents', 'aprovedEvents', 'completeEvents', 'filledEvents', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ClientCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $client = $this->repository->create($request->all());

            $response = [
                'message' => 'Client created.',
                'data'    => $client->toArray(),
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
        $client = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $client,
            ]);
        }

        return view('clients.show', compact('client'));
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

        $client = $this->repository->find($id);

        return view('clients.edit', compact('client'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  ClientUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(ClientUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $client = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Client updated.',
                'data'    => $client->toArray(),
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
                'message' => 'Client deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Client deleted.');
    }
}
