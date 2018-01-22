<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\GraphicCreateRequest;
use App\Http\Requests\GraphicUpdateRequest;
use App\Repositories\GraphicRepository;
use App\Validators\GraphicValidator;


class GraphicsController extends Controller
{

    /**
     * @var GraphicRepository
     */
    protected $repository;

    /**
     * @var GraphicValidator
     */
    protected $validator;

    public function __construct(GraphicRepository $repository, GraphicValidator $validator)
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
        $graphics = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $graphics,
            ]);
        }

        return view('graphics.index', compact('graphics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GraphicCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(GraphicCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $graphic = $this->repository->create($request->all());

            $response = [
                'message' => 'Graphic created.',
                'data'    => $graphic->toArray(),
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
        $graphic = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $graphic,
            ]);
        }

        return view('graphics.show', compact('graphic'));
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

        $graphic = $this->repository->find($id);

        return view('graphics.edit', compact('graphic'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  GraphicUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(GraphicUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $graphic = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Graphic updated.',
                'data'    => $graphic->toArray(),
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
                'message' => 'Graphic deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Graphic deleted.');
    }
}
