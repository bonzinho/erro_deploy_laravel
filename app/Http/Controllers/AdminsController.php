<?php

namespace App\Http\Controllers;

use App\Criteria\FindByThisWeekCriteria;
use App\Criteria\OrderByDateCriteria;
use App\Entities\Event;
use App\Repositories\EventRepository;
use App\Repositories\EventRepositoryEloquent;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AdminCreateRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Repositories\AdminRepository;
use Spatie\Permission\Models\Role;


class AdminsController extends Controller
{

    /**
     * @var AdminRepository
     */
    protected $repository;

    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * AdminsController constructor.
     * @param AdminRepository $repository
     * @param EventRepository $eventRepository
     */
    public function __construct(AdminRepository $repository, EventRepository $eventRepository)
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
        $users[] = Auth::user();
        $users[] = Auth::guard()->user();
        $users[] = Auth::guard('admin')->user();

        $penddingEvents = $this->eventRepository->findWhere(['state_id' => Event::PENDENTE])->count();
        $aprovedEvents = $this->eventRepository->findWhere(['state_id' => Event::PROCESSADO])->count();
        $completeEvents = $this->eventRepository->findWhere(['state_id' => Event::CONCULIDO])->count();
        $filledEvents = $this->eventRepository->findWhere(['state_id' => Event::ARQUIVADO])->count();
        $data = [
            'title' => 'Bem vindo à plataforma do Centro de Eventos da FEUP',
        ];

        $events = $this->eventRepository->pushCriteria(new FindByThisWeekCriteria())->pushCriteria(New OrderByDateCriteria())->all();
        return view('admin.home', compact('events', 'penddingEvents', 'aprovedEvents', 'completeEvents', 'filledEvents', 'data'));
    }

    public function create(){
        $roles = Role::all()->pluck('name', 'id')->toArray();
        return view('admin.configs.admin.add.index', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AdminCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCreateRequest $request)
    {
        try {
            $role = Role::findById($request->role);
            $admin = $this->repository->create($request->all());
            $admin->assignRole($role->name);
            $response = [
                'message' => 'Admin criado com sucesso',
                'data'    => $admin->toArray(),
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
        $admin = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $admin,
            ]);
        }

        return view('admins.show', compact('admin'));
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

        $admin = $this->repository->find($id);

        return view('admins.edit', compact('admin'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  AdminUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(AdminUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $admin = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Admin updated.',
                'data'    => $admin->toArray(),
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
     * @param $admin_id
     */
    public function deactivate(AdminUpdateRequest $request, $id){
        try{
            $admin = $this->repository->update(['state' => 0], $request->admin_id);
            $response = [
                'message' => 'Admin desativado com sucesso',
                'data'    => $admin->toArray(),
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminList(){
        $admins = $this->repository->findWhere(['state' => 1]);
        $roles = Role::all()->pluck('name', 'id')->toArray();
        return view('admin.configs.admin.list', compact('roles', 'admins'));
    }
}
