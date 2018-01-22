<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CollaboratorTypeCreateRequest;
use App\Http\Requests\CollaboratorTypeUpdateRequest;
use App\Repositories\CollaboratorTypeRepository;
use App\Validators\CollaboratorTypeValidator;


class CollaboratorTypesController extends Controller
{

    /**
     * @var CollaboratorTypeRepository
     */
    protected $repository;

    /**
     * @var CollaboratorTypeValidator
     */
    protected $validator;

    public function __construct(CollaboratorTypeRepository $repository, CollaboratorTypeValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $collaboratorTypes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $collaboratorTypes,
            ]);
        }

        return view('collaboratorTypes.index', compact('collaboratorTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CollaboratorTypeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CollaboratorTypeCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $collaboratorType = $this->repository->create($request->all());

            $response = [
                'message' => 'CollaboratorType created.',
                'data'    => $collaboratorType->toArray(),
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
        $collaboratorType = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $collaboratorType,
            ]);
        }

        return view('collaboratorTypes.show', compact('collaboratorType'));
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

        $collaboratorType = $this->repository->find($id);

        return view('collaboratorTypes.edit', compact('collaboratorType'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  CollaboratorTypeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(CollaboratorTypeUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $collaboratorType = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'CollaboratorType updated.',
                'data'    => $collaboratorType->toArray(),
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
                'message' => 'CollaboratorType deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'CollaboratorType deleted.');
    }
}
