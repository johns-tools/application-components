<?php

// Framework
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\JsonStoreController;

/**** Application API Endpoints *****/

// Store the input as a JSON file.
Route::post('/store-json', [JsonStoreController::class, 'store']);
