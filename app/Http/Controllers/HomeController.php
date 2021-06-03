<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\VehicleInventory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $vehiclesRegistered = VehicleInventory::all();

        return view('home');
    }
}
