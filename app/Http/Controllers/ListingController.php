<?php

namespace App\Http\Controllers;

use App\Events\ListingViewed;
use App\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function getIndex()
    {
        // $listings = Listing::all();
        $listings =null;

        return view('listing')->with('listings', $listings);
    }

    public function getDetails($id)
    {
        $listing = Listing::find($id);

        if(Auth::check()) {
            event(new ListingViewed($listing)); // fire the event
        }

        return view('details')->with('listing', $listing);
    }
}
