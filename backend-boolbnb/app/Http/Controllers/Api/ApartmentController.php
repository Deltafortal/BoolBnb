<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get index options
        $options = $request->all();

        // Basic Query
        $query = Apartment::where('is_visible', true)
            ->withMax(['promotions' => function ($query) {
                $query->where('apartment_promotion.end_date', '>=', date("Y-m-d H:i:s"));
            }], 'apartment_promotion.end_date');

        // Ordering
        $query->orderBy('promotions_max_apartment_promotionend_date', 'desc')
            ->orderBy('created_at', 'desc');

        // Get Apartments
        $apartments = $query->get();


        // Send response
        return response()->json($apartments);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $apartment = Apartment::with('user', 'category', 'services')->find($id);
        if (!$apartment) return response(null, 404);

        $ip_address = $request->getClientIp();
        $apartment_views_hour = $apartment->views->where('ip_address', $ip_address)->where('date', '>=', date('Y-m-d H:i:s', strtotime('-1 hour')))->count();

        if ($apartment_views_hour === 0) {
            // Insert View
            $view = new View();
            $view->ip_address = $request->getClientIp();
            $view->apartment_id = $id;
            $view->date = date("Y-m-d H:i:s");
            $view->save();
        }

        return response()->json($apartment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    /**
     * Display a listing of promoted apartments.
     */
    public function promoted()
    {

        // Basic Query
        $query = Apartment::where('is_visible', true)
            ->withMax(['promotions' => function ($query) {
                $query->where('apartment_promotion.end_date', '>=', date("Y-m-d H:i:s"));
            }], 'apartment_promotion.end_date');

        // Get Promoted Apartments
        $query->havingNotNull('promotions_max_apartment_promotionend_date');

        // Ordering
        $query->orderBy('promotions_max_apartment_promotionend_date', 'desc')
            ->orderBy('created_at', 'desc');

        // Get Apartments
        $apartments = $query->get();


        // Send response
        return response()->json($apartments);
    }


    /**
     * Display a listing of random non promoted apartments.
     */
    public function random()
    {
        // Basic Query
        $query = Apartment::where('is_visible', true)
            ->withMax(['promotions' => function ($query) {
                $query->where('apartment_promotion.end_date', '>=', date("Y-m-d H:i:s"));
            }], 'apartment_promotion.end_date');

        // Get Not Promoted Apartments
        $query->havingNull('promotions_max_apartment_promotionend_date');

        // Random Ordering
        $query->inRandomOrder();

        // Get Apartments
        $apartments = $query->get();


        // Send response
        return response()->json($apartments);
    }
}
