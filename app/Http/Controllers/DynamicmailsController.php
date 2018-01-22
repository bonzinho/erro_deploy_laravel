<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\DynamicmailCreateRequest;
use App\Http\Requests\DynamicmailUpdateRequest;
use App\Repositories\DynamicmailRepository;
use App\Validators\DynamicmailValidator;


class DynamicmailsController extends Controller
{

    /**
     * @var DynamicmailRepository
     */
    protected $repository;

    /**
     * @var DynamicmailValidator
     */
    protected $validator;

    public function __construct(DynamicmailRepository $repository, DynamicmailValidator $validator)
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
        $dynamicmails = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $dynamicmails,
            ]);
        }

        return view('dynamicmails.index', compact('dynamicmails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DynamicmailCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(DynamicmailCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $dynamicmail = $this->repository->create($request->all());

            $response = [
                'message' => 'Dynamicmail created.',
                'data'    => $dynamicmail->toArray(),
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
        $dynamicmail = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $dynamicmail,
            ]);
        }

        return view('dynamicmails.show', compact('dynamicmail'));
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

        $dynamicmail = $this->repository->find($id);

        return view('dynamicmails.edit', compact('dynamicmail'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  DynamicmailUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(DynamicmailUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $dynamicmail = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Dynamicmail updated.',
                'data'    => $dynamicmail->toArray(),
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
                'message' => 'Dynamicmail deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Dynamicmail deleted.');
    }
}
