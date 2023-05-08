<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TranslationController extends Controller
{
    // Function that returns translatable strings to Login react component
    public function loginTexts()
    {
        return response()->json([
            __("Login"),
            __("Enter your email"),
            __("Enter your password")
        ]);
    }
    // Function that returns translatable strings to FetchWords react component
    public function fetchTexts()
    {
        return response()->json([
            __("Search for word anagrams"),
            __("Load the wordbase:"),
            __("Load"),
            __("Wait, data is loading")
        ]);
    }
    // Function that returns translatable strings to GetAnagram react component
    public function getTexts()
    {
        return response()->json([
            __("Enter a word..."),
            __("Send")
        ]);
    }
}
