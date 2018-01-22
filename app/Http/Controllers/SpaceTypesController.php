<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SpaceTypeCreateRequest;
use App\Http\Requests\SpaceTypeUpdateRequest;
use App\Repositories\SpaceTypeRepository;
use App\Validators\SpaceTypeValidator;


class SpaceTypesController extends Controller
{

    /**
     * @var SpaceTypeRepository
     */
    protected $repository;

    /**
     * @var SpaceTypeValidator
     */
    protected $validator;

    public function __construct(SpaceTypeRepository $repository, SpaceTypeValidator $validator)
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
        $spaceTypes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $spaceTypes,
            ]);
        }

        return view('spaceTypes.index', compact('spaceTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SpaceTypeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SpaceTypeCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $spaceType = $this->repository->create($request->all());

            $response = [
                'message' => 'SpaceType created.',
                'data'    => $spaceType->toArray(),
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
        $spaceType = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $spaceType,
            ]);
        }

        return view('spaceTypes.show', compact('spaceType'));
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

        $spaceType = $this->repository->find($id);

        return view('spaceTypes.edit', compact('spaceType'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  SpaceTypeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(SpaceTypeUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $spaceType = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'SpaceType updated.',
                'data'    => $spaceType->toArray(),
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
                'message' => 'SpaceType deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'SpaceType deleted.');
    }
}
