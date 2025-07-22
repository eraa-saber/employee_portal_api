<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomTestMail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-email', function () {
    Mail::to('yoyo23mohamed@gmail.com')->send(new CustomTestMail('This is a test!'));
    return 'Email sent!';
});
