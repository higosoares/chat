<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Support\Collection;
use stdClass;

class MessageRepository
{
    public function create(stdClass $params): Message
    {
        $message = new Message();
        $message->sender_id = $params->senderId;
        $message->receiver_id = $params->receiverId;
        $message->text = $params->text;
        $message->is_read = false;
        $message->save();

        return $message;
    }

    public function updateState(int $senderId, int $receiverId)
    {
        return Message::where(['sender_id' => $senderId, 'receiver_id' => $receiverId, 'is_read' => false])
        ->update(['is_read' => true]);
    }

    public function delete(Message $message)
    {
        $message->delete();
    }

    public function getNew(int $senderId, int $receiverId): Collection
    {
        return Message::withTrashed()
            ->where(['sender_id' => $senderId, 'receiver_id' => $receiverId])
            ->where('is_read', false)
            ->orderBy('id')
            ->get();
    }

    public function getOld(int $senderId, int $receiverId): Collection
    {
        return Message::withTrashed()
            ->where(['sender_id' => $senderId, 'receiver_id' => $receiverId])
            ->orWhere('sender_id', '=', $receiverId)
            ->where('receiver_id', '=', $senderId)
            ->where('is_read', true)
            ->orderBy('id')
            ->get();
    }
}
