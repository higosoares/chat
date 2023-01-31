<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Collection;

class UserService
{
    /**
     *
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     * @param integer $userId
     * @return Collection
     */
    public function list(int $userId): Collection
    {
        return $this->repository->list($userId);
    }
}
