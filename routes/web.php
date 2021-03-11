<?php

use App\Http\Controllers\internalController;
use App\Http\Controllers\characterController;
use App\Models\character;
use App\Models\equitment;
use App\Models\floatingModel;
use App\Models\races;
use App\Models\traits;
use App\Models\useful;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
/*
Route::view('/', 'home',
array(
    'races'     => useful::unserializeCollection((new floatingModel('races'))->get()),
    'traits'    => (new floatingModel('traits'))->get(),
));
*/
Route::get('/', [App\Http\Controllers\homeController::class, 'index']);

Route::post('internal/{any}', function ($any) {
    return (new internalController())->{$any}(Request());
});

Route::get('character/{any}', function ($any) {
    return (new characterController())->{$any}(Request());
});

Route::get('test', function () {
    print_r(session('character')->clas());
});
