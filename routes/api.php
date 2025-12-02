<?php

// routes/api.php
use Illuminate\Support\Facades\Route;

Route::get('/halo', function () {
    return response()->json([
        'message' => 'Halo, ini API Laravel!'
    ]);
});
