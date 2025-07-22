<?php

namespace App\Services;

use App\Repositories\Interfaces\SalaryInquiryRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SalaryInquiryService
{
    protected $salaryInquiryRepository;

    public function __construct(SalaryInquiryRepositoryInterface $salaryInquiryRepository)
    {
        $this->salaryInquiryRepository = $salaryInquiryRepository;
    }

    public function inquire($user, $input)
    {
        $errors = [];
        // Validate month
        $month = $input['month'] ?? null;
        $year = $input['year'] ?? null;
        $password = $input['password'] ?? null;

        // Month validation (1-12 or Arabic month name)
        $arabicMonths = [
            'يناير', 'فبراير', 'مارس', 'ابريل', 'أبريل', 'مايو', 'يونيو',
            'يوليو', 'اغسطس', 'أغسطس', 'سبتمبر', 'اكتوبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
        ];
        if (!$month || !(is_numeric($month) && $month >= 1 && $month <= 12) && !in_array($month, $arabicMonths)) {
            $errors['month'] = 'يرجى اختيار الشهر';
        }
        // Year validation
        $currentYear = Carbon::now()->year;
        if (!$year || !is_numeric($year) || $year < 2000 || $year > $currentYear) {
            $errors['year'] = 'يرجى اختيار السنة';
        }
        // Password validation
        if (!$password || !is_string($password) || trim($password) === '') {
            $errors['password'] = 'يرجى إدخال كلمة المرور';
        }
        // Business rule: password must match user's password
        if (empty($errors) && !Hash::check($password, $user->password)) {
            $errors['password'] = 'كلمة المرور غير صحيحة';
        }
        if (!empty($errors)) {
            return ['errors' => $errors];
        }
        // Mock salary data
        $salaryData = $this->salaryInquiryRepository->getSalaryFor($user->id, $month, $year);
        return ['data' => $salaryData];
    }
} 