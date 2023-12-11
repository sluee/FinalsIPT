<?php

namespace App\Http\Controllers;

use App\Events\UserLog;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Rental;
use App\Notifications\RentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('customer', 'car')) {
            // // If the user has the 'patient' role, retrieve only their own appointments
            // $appointment = $user->patient->appointment()->with(['service'])->orderBy('created_at', 'desc')->get();
            $rent = Rental::with(['customer.user', ])
            ->whereHas('customer', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->orderBy('created_at', 'desc')->get();
        } else {
            // If the user does not have the 'patient' role, retrieve all appointments
            $rent = Rental::with(['customer.user', 'car'])->orderBy('created_at', 'desc')->get();
        }
        return view('rent.index',compact('rent'));
    }



    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $customer = Customer::with('user')->get();
    //     $car = Car::all();
    //     return view('rent.create', [
    //         'car' => $car,
    //         'customer' => $customer
    //     ]);
    // }

    public function create(Car $car = null)
{
    $customer = Customer::with('user')->get();

    if ($car) {
        // If a specific car is provided, use that car
        $cars = collect([$car]);
    } else {
        // If no specific car is provided, get all cars
        $cars = Car::all();
    }

    return view('rent.create', [
        'cars' => $cars,
        'customer' => $customer
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
//     public function store(Request $request)
// {
//     $user = Auth::user();

//     $data = $request->validate([
//         'car_id' => 'required',
//         'start_date' => 'required|date|after_or_equal:today',
//         'end_date' => 'required',
//         'totalCost' => 'required',
//         'status' => 'string',
//     ]);

//     // Check if the logged-in user has the role "customer"
//     // Check if the logged-in user has the role "customer"
//     if ($user->hasRole('customer')) {
//         // If yes, use the first associated 'cust_id'
//         $data['cust_id'] = $user->customer->first()->id; // Adjust accordingly based on your relationship
//     } else {
//         // If not, set it to some default value or handle it based on your logic
//         $data['cust_id'] = $request->input('cust_id'); // Change this to your default 'cust_id' or handle accordingly
//         $data['status'] = 'Accepted';
//     }


//      // Check if the user selected a specific car
//      if ($request->has('car_id')) {
//         // Handle the case where a specific car is selected
//         $car = Car::find($data['car_id']);
//         $successMessage = 'Car booked successfully.';
//     } else {
//         // Handle the case where the user wants to view all cars
//         $cars = Car::all();
//         $data['car_id'] = $request->input('car_id');

//         $successMessage = 'All cars retrieved successfully.';
//     }
//     $rental = Rental::create($data);


//     if ($user->hasRole('customer')) {
//         $log_entry = Auth::user()->firstName . " " . Auth::user()->lastName . " rented a car " . $rental->car->brand . " " . $rental->car->model . " with the id #" . $rental->id;
//     } else {
//         $log_entry = Auth::user()->firstName . " ". Auth::user()->lastName . " rented a car for  " . $rental->customer->user->firstName ." ".$rental->customer->user->lastName . " a car  ".  $rental->car->brand . " " . $rental->car->model . " with the id# " . $rental->id;
//     }
//     event(new UserLog($log_entry));

//      $successMessage = $user->hasRole('customer')
//          ? 'Car Rental request submitted successfully. Please check email for notification'
//          : 'Car Rental added successfully.';

//          // $log_entry = Auth::user()->firstName . " " . Auth::user()->lastName . " rented a car " . $rental->car->brand . " " . $rental->car->model . " with the id #" . $rental->id;

//          if ($user->hasRole('admin')) {
//              $customer = $rental->customer;
//              $user = $customer->user;

//              $rentalData = [
//                  'body' => "Hi $user->firstName  $user->lastName,",
//                  'rentalBody' => "Just a friendly reminder that you have a scheduled car rental service for " . $rental->car->brand . " ". $rental->car->model .
//                      " from " . $rental->start_date . " to " . $rental->end_date . ". Please make sure everything is in order.",
//                  'rentalText' => "Check here.",
//                  'url' => url('/'),
//                  'thankyou' => 'We look forward to providing you with our car rental service.'
//              ];
//              $user->notify(new RentNotification($rentalData));
//          } elseif ($user->hasRole('customer')) {
//             $customer = $rental->customer;
//             $user = $customer->user;
//                 $rentalData = [
//                     'body' => "Hi $user->firstName  $user->lastName,",
//                     'rentalBody' => "Just a friendly reminder that you have  book a car rental service for " . $rental->car->brand . " ". $rental->car->model .
//                         " from " . $rental->start_date . " to " . $rental->end_date . ". Please allow a moment for your request to be processed and confirmed. We appreciate your patience.",
//                     'rentalText' => "Check here.",
//                     'url' => url('/'),
//                     'thankyou' => 'We look forward to providing you with our car rental service.'
//                 ];
//                 $user->notify(new RentNotification($rentalData));
//          }
//     return redirect('/rent')->with('message', $successMessage);
// }

public function store(Request $request)
{
    $user = Auth::user();

    $data = $request->validate([
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

    // Check if the user selected a specific car
    if ($request->has('car_id')) {
        $data['car_id'] = $request->input('car_id');
        $car = Car::find($data['car_id']);
        $successMessage = 'Car booked successfully.';
    } else {
        $cars = Car::all();
        $data['car_id'] = $request->input('car_id');
        $successMessage = 'All cars retrieved successfully.';
    }

    // Create a rental record
    $rental = Rental::create($data);

        if ($user->hasRole('customer')) {
        $log_entry = Auth::user()->firstName . " " . Auth::user()->lastName . " rented a car " . $rental->car->brand . " " . $rental->car->model . " with the id #" . $rental->id;
    } else {
        $log_entry = Auth::user()->firstName . " ". Auth::user()->lastName . " rented a car for  " . $rental->customer->user->firstName ." ".$rental->customer->user->lastName . " a car  ".  $rental->car->brand . " " . $rental->car->model . " with the id# " . $rental->id;
    }
    event(new UserLog($log_entry));

    if ($user->hasRole('admin')) {
        $customer = $rental->customer;
        $user = $customer->user;

        $rentalData = [
            'body' => "Hi $user->firstName  $user->lastName,",
            'rentalBody' => "Just a friendly reminder that you have a scheduled car rental service for " . $rental->car->brand . " ". $rental->car->model .
                " from " . $rental->start_date . " to " . $rental->end_date . ". Please make sure everything is in order.",
            'rentalText' => "Check here.",
            'url' => url('/'),
            'thankyou' => 'We look forward to providing you with our car rental service.'
        ];
        $user->notify(new RentNotification($rentalData));
    } elseif ($user->hasRole('customer')) {
       $customer = $rental->customer;
       $user = $customer->user;
           $rentalData = [
               'body' => "Hi $user->firstName  $user->lastName,",
               'rentalBody' => "Just a friendly reminder that you have  book a car rental service for " . $rental->car->brand . " ". $rental->car->model .
                   " from " . $rental->start_date . " to " . $rental->end_date . ". Please allow a moment for your request to be processed and confirmed. We appreciate your patience.",
               'rentalText' => "Check here.",
               'url' => url('/'),
               'thankyou' => 'We look forward to providing you with our car rental service.'
           ];
           $user->notify(new RentNotification($rentalData));
    }
    return redirect('/rent')->with('message', $successMessage);

    }



    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rental $rental)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        //
    }
}
