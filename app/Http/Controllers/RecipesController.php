<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RecipeCreateRequest;
use App\Http\Requests\RecipeUpdateRequest;
use App\Repositories\RecipeRepository;
use App\Validators\RecipeValidator;


class RecipesController extends Controller
{

    /**
     * @var RecipeRepository
     */
    protected $repository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * RecipesController constructor.
     * @param RecipeRepository $repository
     * @param EventRepository $eventRepository
     */
    public function __construct(RecipeRepository $repository, EventRepository $eventRepository)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {

        $event = $this->eventRepository->with(['recipes'])->find($event_id);
        $recipes = $event->recipes;

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $recipes,
            ]);
        }

        return view('admin.event.balance.recipes', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RecipeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RecipeCreateRequest $request)
    {
        try {
            $recipe = $this->repository->create($request->all());

            $response = [
                'message' => 'Recipe created.',
                'data'    => $recipe->toArray(),
            ];

            $event = $this->eventRepository->with(['recipes'])->find($request->event_id);
            $recipes = $event->recipes;

            if ($request->wantsJson()) {
                return response()->json([
                    'data' => $recipes
                ]);
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
     * Update the specified resource in storage.
     *
     * @param  RecipeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(RecipeUpdateRequest $request, $id)
    {
        try {
            $recipe = $this->repository->update($request->all(), $id);
            $event = $this->eventRepository->with(['recipes'])->find($recipe->event_id);
            $recipes = $event->recipes;
            if ($request->wantsJson()) {
                return response()->json([
                    'data' => $recipes
                ]);
            }


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
    public function destroy($id, $event_id)
    {
        $this->repository->delete($id);
        $event = $this->eventRepository->with(['recipes'])->find($event_id);
        $recipes = $event->recipes;
        if (request()->wantsJson()) {
            return response()->json([
                'data' =>  $recipes
            ]);
        }
    }

    public function total($event_id){
        $event = $this->eventRepository->with(['recipes'])->find($event_id);
        $recipes = $event->recipes;
        $total = 0;
        foreach ($recipes as $recipe){
            $total += $recipe->value;
        }
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $total,
            ]);
        }
        return $total;
    }
}
