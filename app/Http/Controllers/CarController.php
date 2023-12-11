<?php

namespace App\Http\Controllers;

use App\Events\UserLog;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::all();

        return view('cars.index',[
            'cars' => $cars
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cars.create',[

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'model'                => 'required|string',
            'year'                 => 'required|string',
            'type'                 => 'required|string',
            'year'                 => 'required|string',
            'capacity'             => 'required|string',
            'pricePerDay'          => 'required|string',
            'brand'                => 'required|string',
        ]);

        $car = Car::create($request->all());
        $log_entry = Auth::user()->firstName . " " . Auth::user()->lastName . " added a car " . $car->brand . " " . $car->model . " with the id #" . $car->id;
        event(new UserLog($log_entry));

        return redirect('/cars')->with('message', ' Car added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        //
    }

    public function createRent(Car $car )
    {
        $customer = Customer::with('user')->get();

        return view('cars.rent', [
            'car' => $car,
            'customer' => $customer
        ]);
    }


    public function rent(Request $request)
{
    $user = Auth::user();

    $data = $request->validate([
        'car_id' => 'required',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required',
        'totalCost' => 'required',
        'status' => 'string',
    ]);

    // Check if the logged-in user has the role "customer"
    if ($user->hasRole('customer')) {
        // If yes, use the first associated 'cust_id'
        $data['cust_id'] = $user->customer->first()->id; // Adjust accordingly based on your relationship
    } else {
        // If not, set it to some default value or handle it based on your logic
        $data['cust_id'] = $request->input('cust_id'); // Change this to your default 'cust_id' or handle accordingly
        $data['status'] = 'Accepted';
    }

    // Retrieve the car by ID
    $car = Car::findOrFail($request->input('car_id'));

    // Associate the car ID with the rental data
    $data['car_id'] = $car->id;

   $rental = Rental::create($data);

    $successMessage = $user->hasRole('customer')
        ? 'Appointment request submitted successfully. Please check email for notification'
        : 'Appointment added successfully.';

        $log_entry = Auth::user()->firstName . " " . Auth::user()->lastName . " rented a car " . $rental->car->brand . " " . $rental->car->model . " with the id #" . $rental->id;
        event(new UserLog($log_entry));

    return redirect('/cars')->with('message', $successMessage);
}



}
