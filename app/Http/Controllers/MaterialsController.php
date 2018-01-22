<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MaterialCreateRequest;
use App\Http\Requests\MaterialUpdateRequest;
use App\Repositories\MaterialRepository;
use App\Validators\MaterialValidator;


class MaterialsController extends Controller
{

    /**
     * @var MaterialRepository
     */
    protected $repository;

    /**
     * @var MaterialValidator
     */
    protected $validator;

    public function __construct(MaterialRepository $repository, MaterialValidator $validator)
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
        $materials = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $materials,
            ]);
        }

        return view('materials.index', compact('materials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MaterialCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $material = $this->repository->create($request->all());

            $response = [
                'message' => 'Material created.',
                'data'    => $material->toArray(),
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
        $material = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $material,
            ]);
        }

        return view('materials.show', compact('material'));
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

        $material = $this->repository->find($id);

        return view('materials.edit', compact('material'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  MaterialUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(MaterialUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $material = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Material updated.',
                'data'    => $material->toArray(),
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
                'message' => 'Material deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Material deleted.');
    }
}
