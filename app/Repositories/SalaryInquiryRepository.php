<?php

namespace App\Repositories;

use App\Repositories\Interfaces\SalaryInquiryRepositoryInterface;
use App\Models\SalaryRequest; // Use the new model

class SalaryInquiryRepository implements SalaryInquiryRepositoryInterface
{
    public function getSalaryFor($userId, $month, $year)
    {
        // Query the 'requests' table for a matching record
        $salaryRequest = SalaryRequest::where('user_id', $userId)
            ->where('salary_year', $year)
            ->where('salary_month', $month)
            ->first();

        // If a request is found, return its data, otherwise return null or a default
        if ($salaryRequest) {
            // You might want to return the whole object or just specific fields
            return [
                'salary' => 'Data from DB', // Replace with actual salary field if you add one
                'status' => $salaryRequest->status,
                'details' => $salaryRequest->toArray() // Return all details from the request
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
} 