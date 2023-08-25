<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Find a user by email.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return $this->model->create($data);
    }

    /**
     * Update the user's password.
     *
     * @param User $user
     * @param string $password
     * @return bool
     */
    public function updatePassword(User $user, $password)
    {
        $user->password = Hash::make($password);

        return $user->save();
    }

    /**
     * Retrieve all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|User[]
     */
    public function all()
    {
        return $this->model->all();
    }
}
