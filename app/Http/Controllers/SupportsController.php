<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SupportCreateRequest;
use App\Http\Requests\SupportUpdateRequest;
use App\Repositories\SupportRepository;
use App\Validators\SupportValidator;


class SupportsController extends Controller
{

    /**
     * @var SupportRepository
     */
    protected $repository;

    /**
     * @var SupportValidator
     */
    protected $validator;

    public function __construct(SupportRepository $repository, SupportValidator $validator)
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
        $supports = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $supports,
            ]);
        }

        return view('supports.index', compact('supports'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SupportCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SupportCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $support = $this->repository->create($request->all());

            $response = [
                'message' => 'Support created.',
                'data'    => $support->toArray(),
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
        $support = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $support,
            ]);
        }

        return view('supports.show', compact('support'));
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

        $support = $this->repository->find($id);

        return view('supports.edit', compact('support'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  SupportUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(SupportUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $support = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Support updated.',
                'data'    => $support->toArray(),
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
                'message' => 'Support deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Support deleted.');
    }
}
