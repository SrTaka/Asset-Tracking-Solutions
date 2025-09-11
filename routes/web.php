<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;
use ArielMejiaDev\LarapexCharts\LarapexChart;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/send-test-email', function () {
    Mail::to('recipient@example.com')->send(new TestMail());
    return 'Test email sent!';
});

Route::get('sample', function(){

    $chart = (new Larapexchart()) -> setTitle('Net Profit')
    ->setSubtitle('From January to March')
    ->setType('radialBar')
    ->setLabels(['Product One', 'Product Two', 'Product Three'])
    ->setXAxis(['Jan', 'Feb', 'Mar'])
    -> setDataset([60, 56, 79]);
    return view('sample', compact('chart'));

    });


require __DIR__.'/auth.php';
require __DIR__.'/admin_auth.php';

