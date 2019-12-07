<?php

Route::get('/', \App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');

Route::resource('clients', \App\Http\Controllers\Admin\ClientController::class, ['except' => 'show']);
