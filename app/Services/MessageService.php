<?php

namespace App\Services;

use App\Models\Message;
use App\Repositories\MessageRepository;
use Illuminate\Support\Collection;
use stdClass;

class MessageService
{
    /**
     *
     * @var MessageRepository
     */
    private $repository;

    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     * @param stdClass $params
     * @return Message
     */
    public function create(stdClass $params): Message
    {
        return $this->repository->create($params);
    }

    /**
     *
     * @param integer $senderId
     * @param integer $receiverId
     */
    public function updateState(int $senderId, int $receiverId)
    {
        return $this->repository->updateState($senderId, $receiverId);
    }

    /**
     *
     * @param Message $message
     */
    public function delete(Message $message)
    {
        return $this->repository->delete($message);
    }

    /**
     *
     * @param integer $senderId
     * @param integer $receiverId
     * @return Collection
     */
    public function getNew(int $senderId, int $receiverId): Collection
    {
        return $this->repository->getNew($senderId, $receiverId);
    }

    /**
     *
     * @param integer $senderId
     * @param integer $receiverId
     * @return Collection
     */
    public function getOld(int $senderId, int $receiverId): Collection
    {
        return $this->repository->getOld($senderId, $receiverId);
    }
}
