<?php

use App\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Route;

// crud controller 
Route::resource('/', CrudController::class);


Route::prefix('/')->group(function(){
    Route::get('dashboard', [App\Http\Controllers\Backend\DashboardController::class, 'index']);
});


require __DIR__.'/auth.php';
