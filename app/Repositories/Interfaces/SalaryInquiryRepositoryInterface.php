<?php

namespace App\Repositories\Interfaces;

interface SalaryInquiryRepositoryInterface
{
    public function getSalaryFor($userId, $month, $year);
} 