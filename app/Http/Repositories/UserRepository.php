<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @param User $model
     */
    public function __construct(
        protected User $model
    )
    {
    }

    public function getUserEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function getAllUsers()
    {
      return $this->model->all();
    }
}
