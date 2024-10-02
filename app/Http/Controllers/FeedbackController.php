<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class FeedbackController extends Controller
{
    public function feedback(Request $request)
    {
        return rescue(function () use ($request) {
            // Validate the request data
            $request->validate([

                'name' => 'required|string',
                'feedback' => 'required|string',

            ]);


            $lastToken = DB::table('personal_access_tokens')
                ->where('name', 'flutter-token')
                ->orderBy('created_at', 'desc')
                ->first();

            //If a token exists, get the tokenable_id (user_id)
            $userId = $lastToken ? $lastToken->tokenable_id : null;

            //Check if userId is valid
            if (!$userId) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }

            // Create the listing
            $feedback = Feedback::create([
                'user_id' => $userId, // Store the user_id from the token

                'name' => $request->name,
                'feedback' => $request->feedback,

            ]);

            // Return the response
            return response()->json([
                'status' => 'true',
                'payload' => $feedback,
            ], 200);
        }, function (Exception $exception) {
            // Handle exceptions
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        });
    }

    public function getFeedbacks()
    {
        try {
            // Fetch all feedbacks from the table
            $feedbacks = Feedback::all();

            return response()->json([
                'status' => 'true',
                'payload' => $feedbacks,
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    // public function index()
    // {
    //     // Return the feedback view
    //     return view('feedback'); // Assuming you will create feedback.blade.php
    // }

    public function index()
    {
        // Fetch all feedbacks from the table
        $feedbacks = Feedback::all(); // You might want to limit this with pagination

        // Return the feedback view with feedback data
        return view('feedback', compact('feedbacks')); // Pass feedbacks to the view
    }
}
