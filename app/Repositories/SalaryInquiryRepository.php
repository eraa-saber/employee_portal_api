<?php

namespace App\Repositories;

use App\Repositories\Interfaces\SalaryInquiryRepositoryInterface;
use App\Models\Request; // Use the correct model

class SalaryInquiryRepository implements SalaryInquiryRepositoryInterface
{
    public function getSalaryFor($userId, $month, $year)
    {
        \Log::info('Salary query:', ['user_id' => $userId, 'month' => $month, 'year' => $year]);

        // Normalize Arabic month names to a consistent format
        $arabicMonthMap = [
            'يناير' => 'يناير',
            'فبراير' => 'فبراير',
            'مارس' => 'مارس',
            'إبريل' => 'إبريل',
            'أبريل' => 'إبريل',
            'مايو' => 'مايو',
            'يونيو' => 'يونيو',
            'يوليو' => 'يوليو',
            'أغسطس' => 'أغسطس',
            'اغسطس' => 'أغسطس',
            'سبتمبر' => 'سبتمبر',
            'أكتوبر' => 'أكتوبر',
            'اكتوبر' => 'أكتوبر',
            'نوفمبر' => 'نوفمبر',
            'ديسمبر' => 'ديسمبر',
        ];

        $normalizedMonth = $arabicMonthMap[$month] ?? $month;

        // Query the 'requests' table for a matching record
        $request = Request::where('user_id', $userId)
            ->where('salary_year', $year)
            ->where('salary_month', $normalizedMonth)
            ->first();

        // If a request is found, return its data, otherwise return null or a default
        if ($request) {
            // You might want to return the whole object or just specific fields
            return [
                'salary' => 'Data from DB', // Replace with actual salary field if you add one
                'status' => $request->status,
                'details' => $request->toArray() // Return all details from the request
            ];
        }

        // Return a specific structure if no data is found
        return [
            'salary' => 'N/A',
            'status' => 'not_found',
            'details' => [
                'note' => 'No salary data found for the selected period.'
            ]
        ];
    }

    public function createSalaryRequest($userId, $month, $year, $status = 'pending')
    {
        // Map English status to Arabic as per user feedback
        $statusMap = [
            'pending' => 'جاري التنفيذ',
            'sent' => 'تم الإرسال',
            'approved' => 'موافق عليه',
            'rejected' => 'مرفوض',
        ];
        $arabicStatus = $statusMap[$status] ?? $status;

        return Request::create([
            'user_id' => $userId,
            'request_date' => now(),
            'salary_year' => $year,
            'salary_month' => $month,
            'status' => $arabicStatus,
            // Add other fields if needed
        ]);
    }
}
