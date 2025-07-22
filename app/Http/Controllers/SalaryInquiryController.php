<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SalaryInquiryService;
use Illuminate\Support\Facades\Auth;

class SalaryInquiryController extends Controller
{
    protected $salaryInquiryService;

    public function __construct(SalaryInquiryService $salaryInquiryService)
    {
        $this->salaryInquiryService = $salaryInquiryService;
    }

    public function inquire(Request $request)
    {
      
        $user = Auth::user();
        $result = $this->salaryInquiryService->inquire($user, $request->all());
        return response()->json($result);
    }
} 