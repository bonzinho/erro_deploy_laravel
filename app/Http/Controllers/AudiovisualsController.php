<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AudiovisualCreateRequest;
use App\Http\Requests\AudiovisualUpdateRequest;
use App\Repositories\AudiovisualRepository;
use App\Validators\AudiovisualValidator;


class AudiovisualsController extends Controller
{

    /**
     * @var AudiovisualRepository
     */
    protected $repository;

    /**
     * @var AudiovisualValidator
     */
    protected $validator;

    public function __construct(AudiovisualRepository $repository, AudiovisualValidator $validator)
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
        $audiovisuals = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $audiovisuals,
            ]);
        }

        return view('audiovisuals.index', compact('audiovisuals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AudiovisualCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AudiovisualCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $audiovisual = $this->repository->create($request->all());

            $response = [
                'message' => 'Audiovisual created.',
                'data'    => $audiovisual->toArray(),
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
        $audiovisual = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $audiovisual,
            ]);
        }

        return view('audiovisuals.show', compact('audiovisual'));
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

        $audiovisual = $this->repository->find($id);

        return view('audiovisuals.edit', compact('audiovisual'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  AudiovisualUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(AudiovisualUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $audiovisual = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Audiovisual updated.',
                'data'    => $audiovisual->toArray(),
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
                'message' => 'Audiovisual deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Audiovisual deleted.');
    }
}
