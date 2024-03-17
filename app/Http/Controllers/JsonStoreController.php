<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JsonStoreController extends Controller
{

    /**
     * Handles the storage of title and description data as JSON.
     *
     * This method processes a POST request that must include 'title' and 'description' fields.
     * It performs validation to make sure that 'title' is not-empty (string) and no more than 255
     * characters in length and that the 'description' is a not-empty (string) and no more than 1000 characters.
     *
     * If the validation fails, the method responds with a JSON payload containing the validation
     * errors and a 422 HTTP status code.
     *
     * Upon passing validation, the method encodes the validated data into a JSON string and
     * stores this string in a file named 'json_store.json' within the application's public
     * storage directory. It then responds with a JSON payload indicating that the data has
     * been stored successfully.
     *
     * @param Request $request The request instance containing the 'title' and 'description' data.
     *
     * @return \Illuminate\Http\JsonResponse On validation failure, returns a JSON response with
     *                                       validation errors and a 422 status code. On success,
     *                                       returns a JSON response with a success message.
     *
     * @throws \Illuminate\Validation\ValidationException Automatically thrown and handled by
     *                                                     Laravel if validation fails, resulting
     *                                                     in a JSON response with error details.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $jsonData = json_encode($validatedData);
        Storage::disk('public')->put('json_store.json', $jsonData);

        return response()->json(['message' => 'Data stored successfully']);
    }

}
