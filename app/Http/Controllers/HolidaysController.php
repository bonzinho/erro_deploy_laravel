<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\HolidaysCreateRequest;
use App\Http\Requests\HolidaysUpdateRequest;
use App\Repositories\HolidaysRepository;
use App\Validators\HolidaysValidator;


class HolidaysController extends Controller
{

    /**
     * @var HolidaysRepository
     */
    protected $repository;

    public function __construct(HolidaysRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holidays = $this->repository->all();
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $holidays,
            ]);
        }
        return view('admin.configs.hollidays.index', compact('holidays'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  HolidaysCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(HolidaysCreateRequest $request)
    {
        try {
            $holiday = $this->repository->create($request->all());
            if($holiday){
                $response = [
                    'message' => 'Ano já tem feriados inseridos, caso pretenda alterar por favor contacte o programador!',
                    'data'    => false,
                ];
            }else{
                $response = [
                    'message' => 'Holidays created.',
                    'data'    => $holiday->toArray(),
                ];
            }

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
        $holiday = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $holiday,
            ]);
        }

        return view('holidays.show', compact('holiday'));
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

        $holiday = $this->repository->find($id);

        return view('holidays.edit', compact('holiday'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  HolidaysUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(HolidaysUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $holiday = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Holidays updated.',
                'data'    => $holiday->toArray(),
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
                'message' => 'Holidays deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Holidays deleted.');
    }
}
