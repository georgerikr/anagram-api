<?php

use App\Http\Controllers\AnagramController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TranslationController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

//Locale route for translation
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});

//Signin Route for checking username and password, sets 'approved_user' cookie if credentials are correct
Route::post('/signin', [LoginController::class, 'login']);

//Default Route that checks for 'approved_user' cookie, if it's set, redirects to default url with index blade
Route::get('/', [LoginController::class, 'cookie']);

//Write Route for write function that saves the wordlist to database
Route::post('/write', [AnagramController::class, 'write']);

//Input Route for retrieving user input and returning anagrams
Route::post('/input', [AnagramController::class, 'anagram']);

//Texts routes that give react forms translatable strings
Route::get('/loginTexts', [TranslationController::class, 'loginTexts']);
Route::get('/fetchTexts', [TranslationController::class, 'fetchTexts']);
Route::get('/getTexts', [TranslationController::class, 'getTexts']);

//Docs route for Swagger ApiDoc
Route::get('/docs', function() {
    return view('swagger');
});