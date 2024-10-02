<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing; // Ensure you have the Listing model

class PropertiesController extends Controller
{
    public function listed()
    {
        // Retrieve all listings from the database
        $listings = Listing::all();

        // Pass the listings to the view
        return view('properties.listed', compact('listings'));
    }



    public function published()
    {
        $listings = Listing::where('published', 'done')->get(); // Adjust based on your status column
        return view('properties.published', compact('listings'));
    }

    public function pending()
    {
        $listings = Listing::where('published', 'pending')->get(); // Adjust based on your status column
        return view('properties.pending', compact('listings'));
    }
}
