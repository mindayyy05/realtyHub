<?php

namespace App\Http\Controllers;

use App\Models\LikedProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikePropertyController extends Controller
{
    // Function to handle the like request
    public function like(Request $request)
    {
        try {
            $userId = Auth::id(); // Get the currently authenticated user ID
            $propertyId = $request->input('property_id');

            // Check if the user has already liked the property
            $alreadyLiked = LikedProperty::where('user_id', $userId)
                ->where('property_id', $propertyId)
                ->exists();

            if ($alreadyLiked) {
                return response()->json(['message' => 'Property already liked'], 400);
            }

            // Create a new like record in the liked_properties table
            LikedProperty::create([
                'user_id' => $userId,
                'property_id' => $propertyId,
            ]);

            return response()->json(['message' => 'Property liked successfully'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to like property', 'error' => $e->getMessage()], 500);
        }
    }

    // Function to handle unliking the property (if you want to add that)
    public function unlike(Request $request)
    {
        try {
            $userId = Auth::id();
            $propertyId = $request->input('property_id');

            $likedProperty = LikedProperty::where('user_id', $userId)
                ->where('property_id', $propertyId)
                ->first();

            if (!$likedProperty) {
                return response()->json(['message' => 'Property not found in likes'], 404);
            }

            // Remove the like record from the database
            $likedProperty->delete();

            return response()->json(['message' => 'Property unliked successfully'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to unlike property', 'error' => $e->getMessage()], 500);
        }
    }
}

