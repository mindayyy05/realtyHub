<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function pay(Request $request)
    {
        return rescue(function () use ($request) {
            // Log incoming request for debugging
            \Log::info('Payment request data:', $request->all());

            // Validate the request data
            $request->validate([
                'cardNumber' => 'required|string',
                'expiryMonth' => 'required|string',
                'cvv' => 'required|string',
                'cardName' => 'required|string',
                'property_id' => 'required|string', // Ensure this is required
                'price' => 'required|string', // Ensure this is required
            ]);

            // Retrieve the last flutter-token from the personal_access_tokens table
            $lastToken = DB::table('personal_access_tokens')
                ->where('name', 'flutter-token')
                ->orderBy('created_at', 'desc')
                ->first();

            // If a token exists, get the tokenable_id (user_id)
            $userId = $lastToken ? $lastToken->tokenable_id : null;

            // Check if userId is valid
            if (!$userId) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }

            // Create the transaction
            $transaction = Transaction::create([
                'user_id' => $userId,
                'cardNumber' => $request->cardNumber,
                'expiryMonth' => $request->expiryMonth,
                'cvv' => $request->cvv,
                'cardName' => $request->cardName,
                'property_id' => $request->property_id,
                'price' => $request->price,
            ]);

            // Return the response
            return response()->json([
                'status' => 'true',
                'payload' => $transaction,
            ], 200);
        }, function (Exception $exception) {
            // Handle exceptions
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        });
    }



    public function getListings()
    {
        $transactions = Transaction::all(); // Fetch all listings from the database
        return response()->json([
            'status' => 'true',
            'payload' => $transactions,
        ], 200);
    }
}
