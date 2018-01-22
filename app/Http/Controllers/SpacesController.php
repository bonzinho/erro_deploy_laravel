<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SpaceCreateRequest;
use App\Http\Requests\SpaceUpdateRequest;
use App\Repositories\SpaceRepository;
use App\Validators\SpaceValidator;


class SpacesController extends Controller
{

    /**
     * @var SpaceRepository
     */
    protected $repository;

    /**
     * @var SpaceValidator
     */
    protected $validator;

    public function __construct(SpaceRepository $repository, SpaceValidator $validator)
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
        $spaces = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $spaces,
            ]);
        }

        return view('spaces.index', compact('spaces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SpaceCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SpaceCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $space = $this->repository->create($request->all());

            $response = [
                'message' => 'Space created.',
                'data'    => $space->toArray(),
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
        $space = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $space,
            ]);
        }

        return view('spaces.show', compact('space'));
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

        $space = $this->repository->find($id);

        return view('spaces.edit', compact('space'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  SpaceUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(SpaceUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $space = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Space updated.',
                'data'    => $space->toArray(),
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
                'message' => 'Space deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Space deleted.');
    }
}
