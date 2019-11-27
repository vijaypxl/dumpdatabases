<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/export', function () {
    set_time_limit(0);
    for($i=1; $i<5; $i++) {
        Artisan::call('db:export', [
            'username' => config('database.connections.mysql'.$i.'.username'),
            'password' => config('database.connections.mysql'.$i.'.password'),
            'db' => config('database.connections.mysql'.$i.'.database'),
        ]);
        echo '<pre>';
        print_r(Artisan::output());
    }
});
