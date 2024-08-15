<?php

namespace App\Services\Auth\Repositories;

use App\Services\Auth\Models\User;

class AuthRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
