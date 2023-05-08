<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Anagram API",
 *     description="RESTful API endpoints for fetching wordbase to the application and finding anagrams for given word",
 * )
 *
 * @OA\Server(
 *     url="your_url_here",
 *     description="Local development server"
 * )
 */

class AnagramController extends Controller
{
    
    /**
     * @OA\Post(
     *     path="/write",
     *     summary="Load the data from external wordbase to local database",
     *     tags={"Anagram"},
     *     @OA\Response(
     *         response="200",
     *         description="Responds 'Data loaded successfully' or 'Data has already been loaded'",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Data loading requests response message",
     *                 description="Success message"
     *             ),
     *             @OA\Property(
     *                 property="data_loaded",
     *                 type="array",
     *                 @OA\Items(type="string"),
     *                 example={"Data loaded successfully"},
     *                 description="Example of data loaded successfully"
     *             ),
     *             @OA\Property(
     *                 property="data_already_loaded",
     *                 type="array",
     *                 @OA\Items(type="string"),
     *                 example={"Data has already been loaded"},
     *                 description="Example of data has already been loaded"
     *             )
     *         )
     *     )
     * )
     */

    // Function to insert all the words from wordbase to database
    public function write() 
    {
        // Get the number of rows in the 'words' table
        $count = DB::table('words')->count();
        // If database is empty, insert the wordbase to databases table
        if ($count == 0) {
            // Read the file into an array of lines
            $lines = file('https://www.eki.ee/tarkvara/wordlist/lemmad2013.txt');
            // Chunk the array into smaller pieces to reduce memory usage
            $chunks = array_chunk($lines, 10000);
            // Iterate over the chunks and insert them into the database
            foreach ($chunks as $chunk) {
                $data = [];
                // Format the data for batch insertion
                foreach ($chunk as $line) {
                    $data[] = ['word' => trim($line)];
                }
                // Insert the chunk into the database
                DB::table('words')->insert($data);
            }
            // On successful load, respond with a corresponding message
            return response()->json([
                __("Data loaded successfully")
            ]);
        } else {
            // If the data has already been loaded, respond with a corresponding message
            return response()->json([
                __("Data has already been loaded")
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/input",
     *     summary="Send input word and receive anagrams of that word from database",
     *     tags={"Anagram"},
     *     @OA\RequestBody(
     *         description="Example data to send for the application",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="string",
     *                     example="krae"
     *                 )
     *             ),
     *             examples={
     *                 "valid_word": {
     *                     "value": {
     *                         "data": "krae"
     *                     },
     *                     "summary": "Example of a valid word, responds with anagrams of that word"
     *                 },
     *                 "invalid_word": {
     *                     "value": {
     *                         "data": "qwerty"
     *                     },
     *                     "summary": "Example of an invalid word, doesn't have any anagrams"
     *                 },
     *                 "empty_word": {
     *                     "value": {
     *                         "data": ""
     *                     },
     *                     "summary": "Example of an empty word, asks to enter a word"
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Responds 'Anagrams of the word: erak, kaer, kare, kera, rake', 'No anagrams for given word', 'Form is empty, enter a word,' or 'Database is empty, click on 'load' button'",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="anagrams",
     *                         type="array",
     *                         @OA\Items(type="string", example="erak"),
     *                         description="Array of anagrams"
     *                     )
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="No anagrams for given word",
     *                         description="Error message"
     *                     )
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="Form is empty, enter a word",
     *                         description="Error message"
     *                     )
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="Database is empty, click on 'load' button",
     *                         description="Error message"
     *                     )
     *                 )
     *             }
     *         )
     *     )
     * )
     */

    // Function to retrieve user input and find anagrams for given word from database
    public function anagram(Request $request) 
    {
        # Finding anagrams

        // Request input word and store it in lowercase
        $input_word = strtolower($request->data);
        // Retrieve all the values from "word" column and store them in array
        $word_list = DB::table('words')->pluck('word')->toArray();
        // Convert the $input_word into an array of characters
        $input_sorted = str_split($input_word);
        // Sort the characters in alphabetical order
        sort($input_sorted);
        // Convert the sorted array into a string
        $input_sorted = implode('', $input_sorted);
        // Empty array to store the results
        $result = [];
        // Iterate over stored words array
        foreach ($word_list as $word) {
            // Convert the current word from table to array of characters
            $word_sorted = str_split($word);
            // Sort the characters in alphabetical order
            sort($word_sorted);
            // Convert the sorted array into a string
            $word_sorted = implode('', $word_sorted);
            // Compare the sorted strings, if they match and the words are not identical, add current word to results array
            if ($input_sorted === $word_sorted && $input_word !== $word) {
                $result[] = $word;
            }
        }

        # Exception handling

        // Break $input_word value into an array to compare it against $result array
        $input_ar = explode(' ',$input_word);
        // Check if $word_list array (table) is empty, if it is, respond with a corresponding message, if it isn't, proceed with the statement
        if (empty($word_list)) {
            return response()->json([
                __("Database is empty, click on 'load' button")
            ]);
        // Check if the $input_word is empty, if it is, respond with a corresponding message, if it isn't, proceed with the statement
        } else if (empty($input_word)) {
            return response()->json([
                __("Form is empty, enter a word")
            ]);
        // Check if $input_ar array is identical to $result array or if $result array is empty, if it is, respond with a corresponding message
        } else if ($input_ar === $result || empty($result)) {
            return response()->json([
                __("No anagrams for given word")
            ]);
        }
        // Return a string from $result array for better formatting
        $jsonres = implode(', ',$result);
        // Return response with given anagrams
        return response()->json([
            __("Anagrams of the word: ") . $jsonres
        ]);
    }
}
