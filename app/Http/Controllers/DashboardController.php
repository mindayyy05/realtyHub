<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Listing;
use App\Models\Transaction; // Import the Transaction model
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $excludeLabel = 'Types of Properties Sold';

        // Get all users
        $users = User::all();

        // Get total users registered
        $totalUsers = User::count();

        // Get all listings and total listings count
        $listings = Listing::all();
        $totalListings = Listing::count();

        // Get the count of pending listings
        $pendingListings = Listing::where('published', 'pending')->count();

        // Get the count of published listings
        $publishedListings = Listing::where('published', 'done')->count();

        // Get listings registered per month
        $listingsPerMonth = Listing::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Initialize an array to store listings count per month (12 months)
        $months = array_fill(1, 12, 0);

        // Fill months array with actual data
        foreach ($listingsPerMonth as $month => $count) {
            $months[$month] = $count;
        }

        // Fetch property type data
        $propertyTypes = Listing::select('property_type')
            ->get()
            ->groupBy('property_type')
            ->map(function ($items, $key) {
                return $items->count();
            })
            ->toArray();

        // Filter property types excluding 'Types of Properties Sold'
        $filteredPropertyLabels = [];
        $filteredPropertyData = [];

        foreach ($propertyTypes as $label => $count) {
            if ($label !== $excludeLabel) {
                $filteredPropertyLabels[] = $label;
                $filteredPropertyData[] = $count;
            }
        }

        $propertyChartData = [
            'labels' => $filteredPropertyLabels,
            'data' => $filteredPropertyData,
        ];

        // Fetch real estate agent data
        $realEstateAgents = Listing::select('real_estate_agent')
            ->get()
            ->groupBy('real_estate_agent')
            ->map(function ($items, $key) {
                return $items->count();
            })
            ->toArray();

        // Filter real estate agents excluding 'Types of Properties Sold'
        $filteredAgentLabels = [];
        $filteredAgentData = [];

        foreach ($realEstateAgents as $label => $count) {
            if ($label !== $excludeLabel) {
                $filteredAgentLabels[] = $label;
                $filteredAgentData[] = $count;
            }
        }

        $agentChartData = [
            'labels' => $filteredAgentLabels,
            'data' => $filteredAgentData,
        ];

        // Fetch the count of properties for sale and for rent
        $propertiesForSale = Listing::where('is_for_sale', 1)->count();
        $propertiesForRent = Listing::where('is_for_rent', 1)->count();

        // Get total users registered by month
        $usersPerMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Initialize an array to store users count per month (12 months)
        $userMonths = array_fill(1, 12, 0);

        // Fill userMonths array with actual data
        foreach ($usersPerMonth as $month => $count) {
            $userMonths[$month] = $count;
        }

        // Get total transactions per month
        $transactionsPerMonth = Transaction::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Initialize an array to store transactions count per month (12 months)
        $transactionMonths = array_fill(1, 12, 0);

        // Fill transactionMonths array with actual data
        foreach ($transactionsPerMonth as $month => $count) {
            $transactionMonths[$month] = $count;
        }

        // Initialize an array to store daily revenue for October (31 days)
        $dailyRevenue = array_fill(1, 31, 0);

        // Get revenue data for October (Month 10)
        $revenuesForOctober = Transaction::selectRaw('DAY(created_at) as day, SUM(CAST(REPLACE(price, "Rs.", "") AS DECIMAL(10,2))) as total_revenue')
            ->whereMonth('created_at', 10) // Only October
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total_revenue', 'day')
            ->toArray();

        // Fill daily revenue array with actual data
        foreach ($revenuesForOctober as $day => $total) {
            $dailyRevenue[$day] = $total;
        }

        // Fetch the count of listings by state
        $listingsByState = Listing::select('state', \DB::raw('COUNT(*) as count'))
            ->groupBy('state')
            ->orderBy('count', 'desc')
            ->pluck('count', 'state')
            ->toArray();

        // Prepare data for state chart
        $stateLabels = array_keys($listingsByState);
        $stateData = array_values($listingsByState);

        // Pass the data to the view
        return view('dashboard', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'listings' => $listings,
            'totalListings' => $totalListings,
            'pendingListings' => $pendingListings,
            'publishedListings' => $publishedListings,
            'months' => $months,
            'userMonths' => $userMonths,
            'propertyTypeChart' => $propertyChartData,
            'realEstateAgentChart' => $agentChartData,
            'propertiesForSale' => $propertiesForSale,
            'propertiesForRent' => $propertiesForRent,
            'transactionMonths' => $transactionMonths,
            'dailyRevenue' => $dailyRevenue, // Pass daily revenue data for October to the view
            'stateLabels' => $stateLabels, // Pass state labels to the view
            'stateData' => $stateData, // Pass state data to the view
        ]);
    }
}
