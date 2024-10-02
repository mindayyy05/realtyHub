<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Support\Facades\DB; // Import DB facade for direct queries
use Exception;

class ListingController extends Controller
{
    public function sell(Request $request)
    {
        return rescue(function () use ($request) {
            // Validate the request data
            $request->validate([
                'bedrooms' => 'required|string',
                'bathrooms' => 'required|string',
                'garages' => 'required|string',
                'land_size' => 'required|string',
                'house_size' => 'required|string',
                'price' => 'required|string',
                'price_per_sqft' => 'required|string',
                'address' => 'required|string',
                'street_address' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zip_code' => 'required|string',
                'longitude' => 'required|string',
                'latitude' => 'required|string',
                'title' => 'required|string',
                'description' => 'required|string',
                'real_estate_agent' => 'required|string',
                'property_type' => 'required',
                'is_negotiable' => 'required|boolean',
                'is_for_sale' => 'required|boolean',
                'is_for_rent' => 'required|boolean',
                'images.*' => 'nullable|image|max:2048' // Validate image files
            ]);

            // Store images
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('listings', 'public');
                        $imagePaths[] = $path;
                    } else {
                        \Log::info("Invalid file");
                    }
                }
            }

            \Log::info("Image paths: " . json_encode($imagePaths));

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

            // Create the listing
            $listing = Listing::create([
                'user_id' => $userId, // Store the user_id from the token
                'bedrooms' => $request->bedrooms,
                'bathrooms' => $request->bathrooms,
                'garages' => $request->garages,
                'land_size' => $request->land_size,
                'house_size' => $request->house_size,
                'price' => $request->price,
                'price_per_sqft' => $request->price_per_sqft,
                'address' => $request->address,
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'title' => $request->title,
                'description' => $request->description,
                'real_estate_agent' => $request->real_estate_agent,
                'property_type' => $request->property_type,
                'is_negotiable' => $request->is_negotiable,
                'is_for_sale' => $request->is_for_sale,
                'is_for_rent' => $request->is_for_rent,
                'images' => json_encode($imagePaths),
            ]);

            // Return the response
            return response()->json([
                'status' => 'true',
                'payload' => $listing,
            ], 200);
        }, function (Exception $exception) {
            // Handle exceptions
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        });
    }

    public function publish($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->published = 'done'; // or any other value
        $listing->save();

        return redirect()->back()->with('status', 'Property has been published!');
    }

    public function destroy($id)
    {
        // Find the listing by ID
        $listing = Listing::findOrFail($id);

        // Delete the listing
        $listing->delete();

        // Redirect back to the listings page with a success message
        return redirect()->route('properties.listed')->with('status', 'Listing has been successfully deleted!');
    }

    public function update(Request $request, $id)
    {
        // Validate the input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            // Add other fields as needed
        ]);

        // Find the listing by ID and update it
        $listing = Listing::find($id);
        $listing->title = $validated['title'];
        $listing->price = $validated['price'];
        $listing->description = $validated['description'];
        // Update other fields
        $listing->save();

        // Redirect back to the listings page with success message
        return redirect()->route('properties.listed')->with('success', 'Listing updated successfully!');
    }



    public function getListings()
    {
        $listings = Listing::all(); // Fetch all listings from the database
        return response()->json([
            'status' => 'true',
            'payload' => $listings,
        ], 200);
    }

    public function getRentListings()
    {
        $listings = Listing::where('published', 'done') // Filter for published listings
            ->where('is_for_rent', 1) // Filter for listings that are for rent
            ->get(); // Fetch the filtered listings

        return response()->json([
            'status' => 'true',
            'payload' => $listings,
        ], 200);
    }

    public function getTrincoListings()
    {
        $listings = Listing::where('published', 'done') // Filter for published listings
            ->where('state', 'Trincomalee') // Filter for listings that are for rent
            ->get(); // Fetch the filtered listings

        return response()->json([
            'status' => 'true',
            'payload' => $listings,
        ], 200);
    }

    public function getColomboListings()
    {
        $listings = Listing::where('published', 'done') // Filter for published listings
            ->where('state', 'Colombo') // Filter for listings that are for rent
            ->get(); // Fetch the filtered listings

        return response()->json([
            'status' => 'true',
            'payload' => $listings,
        ], 200);
    }

    public function getSaleListings()
    {
        $listings = Listing::where('published', 'done') // Filter for published listings
            ->where('is_for_sale', 1) // Filter for listings that are for rent
            ->get(); // Fetch the filtered listings

        return response()->json([
            'status' => 'true',
            'payload' => $listings,
        ], 200);
    }

    public function getApartmentListings()
    {
        $listings = Listing::where('published', 'done') // Filter for published listings
            ->where('property_type', 'Apartment') // Filter for listings that are for rent
            ->get(); // Fetch the filtered listings

        return response()->json([
            'status' => 'true',
            'payload' => $listings,
        ], 200);
    }

    public function getCommercialListings()
    {
        $listings = Listing::where('published', 'done') // Filter for published listings
            ->where('property_type', 'Commercial Property') // Filter for listings that are for rent
            ->get(); // Fetch the filtered listings

        return response()->json([
            'status' => 'true',
            'payload' => $listings,
        ], 200);
    }

    public function getTownhouseListings()
    {
        $listings = Listing::where('published', 'done') // Filter for published listings
            ->where('property_type', 'Town House') // Filter for listings that are for rent
            ->get(); // Fetch the filtered listings

        return response()->json([
            'status' => 'true',
            'payload' => $listings,
        ], 200);
    }
}
