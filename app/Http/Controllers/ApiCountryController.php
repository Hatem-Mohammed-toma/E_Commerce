<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiCountryController extends Controller
{
    public function all()
    {
        // Select only the specified fields
        $countries = Country::select('country_name', 'city_name', 'event_name', 'desc_name', 'date')->get();

        // Return the results as JSON
        return response()->json($countries);
    }




    public function getLocationData(Request $request)
    {
        // Define custom validation rules
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }
        $validated = $validator->validated();
        $country = Country::where('latitude', $validated['latitude'])
                            ->where('longitude', $validated['longitude'])
                            ->first();

        if ($country) {
            return response()->json([
                'country_name' => $country->country_name,
                'city_name' => $country->city_name,
                'event_name' => $country->event_name,
                'desc_name' => $country->desc_name,
                'date' => $country->date,
            ]);
        } else {
            return response()->json([
                'message' => 'Data for this location does not exist.'
            ], 404);
        }
    }



}
