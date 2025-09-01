<?php

use App\Http\Controllers\Web\WebsiteController;
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
Route::group(['middleware' => 'WebLang'], function () {
    Route::get('/lang/{lang}', function ($lang){
        if (in_array($lang, ['ar','en'])){
            // return $lang;
            session()->put('mktechs.lang',$lang);
        }else{
            session()->put('mktechs.lang','en');
        }
        return back();
    })->middleware('Lang');
    Route::get('/', [WebsiteController::class, 'index']);
    Route::get('team', [WebsiteController::class, 'team'])->name('team');
    Route::get('projects', [WebsiteController::class, 'projects'])->name('projects');
    Route::post('contact_us', [WebsiteController::class, 'contact_us'])->name('contact_us');
});
