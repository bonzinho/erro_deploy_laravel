<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NatureCreateRequest;
use App\Http\Requests\NatureUpdateRequest;
use App\Repositories\NatureRepository;
use App\Validators\NatureValidator;


class NaturesController extends Controller
{

    /**
     * @var NatureRepository
     */
    protected $repository;

    /**
     * @var NatureValidator
     */
    protected $validator;

    public function __construct(NatureRepository $repository, NatureValidator $validator)
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
        $natures = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $natures,
            ]);
        }

        return view('natures.index', compact('natures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NatureCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NatureCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $nature = $this->repository->create($request->all());

            $response = [
                'message' => 'Nature created.',
                'data'    => $nature->toArray(),
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
        $nature = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $nature,
            ]);
        }

        return view('natures.show', compact('nature'));
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

        $nature = $this->repository->find($id);

        return view('natures.edit', compact('nature'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  NatureUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(NatureUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $nature = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Nature updated.',
                'data'    => $nature->toArray(),
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
                'message' => 'Nature deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Nature deleted.');
    }
}
