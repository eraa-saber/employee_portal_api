<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Request;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a user if none exist
        if (User::count() === 0) {
            User::factory()->create([
                'FullName' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $user = User::first();

        // Create some sample requests for the first user
        Request::create([
            'user_id' => $user->id,
            'request_date' => '2021-10-11',
            'salary_year' => 2021,
            'salary_month' => 'أغسطس',
            'status' => 'جاري التنفيذ',
            'voucher_no' => 'VCH-2021-001',
        ]);

        Request::create([
            'user_id' => $user->id,
            'request_date' => '2021-10-11',
            'salary_year' => 2020,
            'salary_month' => 'سبتمبر',
            'status' => 'جاري التنفيذ',
            'voucher_no' => 'VCH-2020-002',
        ]);

        Request::create([
            'user_id' => $user->id,
            'request_date' => '2021-10-11',
            'salary_year' => 2018,
            'salary_month' => 'مارس',
            'status' => 'تم الارسال',
            'voucher_no' => 'VCH-2018-003',
        ]);

        Request::create([
            'user_id' => $user->id,
            'request_date' => '2021-10-11',
            'salary_year' => 2019,
            'salary_month' => 'ابريل',
            'status' => 'تم الارسال',
            'voucher_no' => 'VCH-2019-004',
        ]);
    }
}
