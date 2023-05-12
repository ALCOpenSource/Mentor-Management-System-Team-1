<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CountryController extends Controller
{
    /**
     * Return a list of countries.
     */
    public function index()
    {
        if (callStatic(Cache::class, 'has', 'countries')) {
            return new ApiResource(callStatic(Cache::class, 'get', 'countries'));
        }

        $countries = callStatic(Country::class, 'all');

        // Cache forever
        callStatic(Cache::class, 'put', 'countries', $countries, 0);

        return new ApiResource($countries);
    }

    /**
     * Return country details including states and cities.
     */
    public function getCities(Request $request)
    {
        $cache_key = 'cities_'.strtolower($request->country ?? '');

        if (callStatic(Cache::class, 'has', $cache_key)) {
            return new ApiResource(callStatic(Cache::class, 'get', $cache_key));
        }

        $country = callStatic(Country::class, 'where', 'code', strtoupper($request->country))->first();

        if (! $country) {
            return new ApiResource(['error' => 'Country not found', 'status' => 404]);
        }

        // Cache forever
        callStatic(Cache::class, 'put', $cache_key, $country->cities, 0);

        return new ApiResource($country->cities);
    }

    /**
     * Return country details including states and cities.
     */
    public function getStates(Request $request)
    {
        // If in cache, return from cache
        $cache_key = 'states_'.strtolower($request->country ?? '');

        if (callStatic(Cache::class, 'has', $cache_key)) {
            return new ApiResource(callStatic(Cache::class, 'get', 'states'));
        }

        $country = callStatic(Country::class, 'where', 'code', strtoupper($request->country))->first();

        if (! $country) {
            return new ApiResource(['error' => 'Country not found', 'status' => 404]);
        }

        // Cache forever
        callStatic(Cache::class, 'put', $cache_key, $country->states, 0);

        return new ApiResource($country->states);
    }

    /**
     * Return state details including cities.
     */
    public function getStateCities(Request $request)
    {
        $state = callStatic(State::class, 'where', 'name', $request->state)->first();

        if (! $state) {
            return new ApiResource(['error' => 'State not found', 'status' => 404]);
        }

        return new ApiResource($state->cities);
    }
}
