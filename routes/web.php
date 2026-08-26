<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test-status', function () {
    return response()->json([
        "status" => "active" ,
        "student" => "Omar bikai "
    ]);

});

Route::get('/greeting/{name}' , function ($name){
return "Hello, " . htmlspecialchars($name) . "! Welcome to the Laravel application. ";

});
