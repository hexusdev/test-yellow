<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class CompanyController extends BaseController
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }


    public function index(Request $request)
    {
        $user = $request->user();
        $companies = $this->companyService->getByUser($user);

        return response()->json(['companies' => $companies]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $company = $this->companyService->addCompanyForUser($user, $request);

        return response()->json(['message' => 'Company added successfully', 'company' => $company], 201);
    }


}

