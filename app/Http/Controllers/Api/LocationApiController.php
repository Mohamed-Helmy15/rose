<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationApiController extends Controller
{
    /**
     * جلب المدن بناءً على governate_id
     */
    public function getCities(Request $request)
    {
        $governateId = $request->query('governate_id');

        if (!$governateId) {
            return response()->json([
                'status' => 'error',
                'message' => 'يجب تحديد معرف المحافظة',
            ], 400);
        }

        $cities = City::where('governate_id', $governateId)
            ->where('is_active', true)
            ->select('id', 'name')
            ->get();

        return response()->json($cities);
    }

    /**
     * جلب المناطق بناءً على city_id
     */
    public function getLocations(Request $request)
    {
        $cityId = $request->query('city_id');

        if (!$cityId) {
            return response()->json([
                'status' => 'error',
                'message' => 'يجب تحديد معرف المدينة',
            ], 400);
        }

        $locations = Location::where('city_id', $cityId)
            ->where('is_active', true)
            ->select('id', 'name')
            ->get();

        return response()->json($locations);
    }
}