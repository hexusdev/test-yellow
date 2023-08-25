<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\User;

class CompanyRepository
{
    protected $model;

    public function __construct(Company $company)
    {
        $this->model = $company;
    }

    public function createForUser(User $user, array $data)
    {
        return $user->companies()->create($data);
    }

    public function getByUser(User $user)
    {
        return $user->companies;
    }

}
