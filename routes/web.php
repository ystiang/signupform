<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FormController;

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
    return view('signup');
});

/*
|--------------------------------------------------------------------------
| Sign Up Form
|--------------------------------------------------------------------------
|
| Language is a required route paramater
| ID is a optional route parameter, 
| must be assigned with a default value.
|
*/
Route::get('/signup/{lang}/{id?}', function ($lang, $id=null) {
    App::setlocale($lang);
    if($id) {            
        return view('signup', ['lang'=>$lang], ['id'=>$id]);
    } else {            
        return view('signup', ['lang'=>$lang], ['id'=>'']);
    }
})->whereIn('lang', ['en', 'cn']);;

Route::post('/signup', [FormController::class, 'store'])->name('signup');

