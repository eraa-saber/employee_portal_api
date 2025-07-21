<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'request_date',
        'salary_year',
        'salary_month',
        'status',
        'voucher_no',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
