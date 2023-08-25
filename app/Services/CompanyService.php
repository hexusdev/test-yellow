<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;

class CompanyService {

    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository) {
        $this->companyRepository = $companyRepository;
    }

    public function addCompanyForUser(User $user, Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'phone' => 'required|string',
            'description' => 'nullable|string'
        ]);
        return $this->companyRepository->createForUser($user, $data);
    }

}
