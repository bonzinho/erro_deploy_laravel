<?php

namespace App\Http\Controllers;

use App\Events\ClientAcceptFinalValueEvent;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Mockery\Exception;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BalanceNotificationCreateRequest;
use App\Http\Requests\BalanceNotificationUpdateRequest;
use App\Repositories\BalanceNotificationRepository;
use App\Validators\BalanceNotificationValidator;


class BalanceNotificationsController extends Controller
{

    /**
     * @var BalanceNotificationRepository
     */
    protected $repository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(BalanceNotificationRepository $repository, EventRepository $eventRepository)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $balanceNotifications = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $balanceNotifications,
            ]);
        }

        return view('balanceNotifications.index', compact('balanceNotifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BalanceNotificationCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BalanceNotificationCreateRequest $request)
    {

        try {

            $balanceNotification = $this->repository->create($request->all());

            $response = [
                'message' => 'BalanceNotification created.',
                'data'    => $balanceNotification->toArray(),
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
     * Update the specified resource in storage.
     *
     * @param  BalanceNotificationUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(BalanceNotificationUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $balanceNotification = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'BalanceNotification updated.',
                'data'    => $balanceNotification->toArray(),
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
     * @param $token
     */
    public function verify($token){
        try{
            $find = $this->repository->findWhere(['token' => base64_decode($token)])->first();
            if(count($find) == 1){
                if($find->read_at == null){
                    $update = [
                        'read_at' => Carbon::now()
                    ];
                    $this->repository->update($update, $find->id);

                    $updateEvent = [
                        'balance_acepted_client' => 1,
                        'technic_balancete' => 1,
                        'schedule_balancete' => 1,
                    ];

                    $event = $this->eventRepository->update($updateEvent, $find->event_id);
                    $msg = "Obrigado, o valor final do evento ".$event->denomination." foi aceite, o evento será agora arquivado com sucesso.<br/>
                        Alguma dúvida não hesite em nos contactar.";
                    $_event = new ClientAcceptFinalValueEvent($event);
                    event($_event);
                    return view('balance_acepted', compact('event', 'msg'));
                }else{
                    $event = $this->eventRepository->find($find->event_id);
                    $msg = "O valor do evento ".$event->denomination.", já foi confirmado anteriormente";
                    return view('balance_acepted', compact('event', 'msg'));
                }



            }else{
                $event = $this->eventRepository->find($find->event_id);
                $msg = "Evento não encontrado, por favor entre em contacto com o centro de eventos";
                return view('balance_acepted', compact('event', 'msg'));
            }
        }catch (Exception $e){
            return $e->getMessage();
        }


    }
}
