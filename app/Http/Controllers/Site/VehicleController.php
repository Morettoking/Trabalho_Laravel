<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with(['brand','carModel','color'])
            ->latest()
            ->paginate(12);

        return view('site.vehicles.index', compact('vehicles'));
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['brand','carModel','color','photos']);
        return view('site.vehicles.show', compact('vehicle'));
    }
}
