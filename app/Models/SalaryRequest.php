<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryRequest extends Model
{
    protected $fillable = [
        'user_id',
        'request_date',
        'salary_year',
        'salary_month',
        'status',
        'voucher_no',
    ];
}
