<?php

namespace App\Http\Controllers;

use App\Enum\ResponseEnum;
use App\Http\Requests\CreateMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\User;
use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     *
     * @var MessageService
     */
    private $service;

    public function __construct(MessageService $service)
    {
        $this->service = $service;
    }

    /**
     *
     * @param CreateMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateMessageRequest $request)
    {
        $params = (object) [
            'senderId' => $request->user()->id,
            'receiverId' => $request->input('receiver_id'),
            'text' => $request->input('text')
        ];

        $message = $this->service->create($params);

        return response()->json($message->only('id'), ResponseEnum::STATUS_CREATED);
    }

    /**
     *
     * @param Request $request
     * @param Message $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, Message $message)
    {
        $this->authorize('delete', $message);

        $this->service->delete($message);

        return response()->json($message->only('id'), ResponseEnum::STATUS_OK);
    }

    /**
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, User $user)
    {
        $messagesReaded = $this->service->getOld($user->id, $request->user()->id);
        $messagesUnreaded = $this->service->getNew($user->id, $request->user()->id);
        $messages = [
            'read' => MessageResource::collection($messagesReaded),
            'unread' => MessageResource::collection($messagesUnreaded),
        ];
        $this->service->updateState($user->id, $request->user()->id);

        return response()->json($messages, ResponseEnum::STATUS_OK);
    }
}
