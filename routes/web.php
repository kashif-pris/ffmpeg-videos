<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    \FFMpeg::fromDisk('C:\Users\lenovo\Desktop')
    ->open('1.mp4')
    ->export()
    ->toDisk('C:\Users\lenovo\Desktop')
    ->inFormat(new \FFMpeg\Format\Video\X264())
    ->save('yesterday.aac');
});
