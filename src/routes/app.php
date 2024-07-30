<?php
use App\Support\Route;

Route::get("/", "MonController@index");
Route::get("/register", "MonController@register");
Route::post("/create-user", "MonController@createUser");
Route::get("/connection", "MonController@loginPage");
Route::post("/login", "MonController@login");
Route::get("/logout", "MonController@logout");



