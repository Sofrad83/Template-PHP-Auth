<?php

use Core\Route;

#########################################################################################
# HOME
#########################################################################################
Route::get('/', 'HomeController@index');
Route::get("/register", "HomeController@register");
Route::post("/create-user", "HomeController@createUser");
Route::get("/connection", "HomeController@loginPage");
Route::post("/login", "HomeController@login");
Route::get("/logout", "HomeController@logout");

