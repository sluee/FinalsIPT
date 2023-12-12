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
    // public function index()
    // {
    //     $user= Auth::user();

    //     if ($user->hasRole('customer', 'car')) {

    //         $rent = Rental::with(['customer.user', ])
    //         ->whereHas('customer', function ($query) use ($user) {
    //             $query->where('user_id', $user->id);
    //         })->orderBy('created_at', 'desc')->get();
    //     } else {

    //         $rent = Rental::with(['customer.user', 'car'])->orderBy('created_at', 'desc')->get();
    //     }
    //     return view('rent.index',compact('rent'));
    // }

    public function index(){
        $user = Auth::user();
        if($user->hasRole('customer')){
            $rent = Rental::with(['customer.user', 'car' ])
                    ->whereHas('customer', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })->orderBy('created_at', 'desc')->get();
                } else {

                    $rent = Rental::with(['customer.user', 'car'])->orderBy('created_at', 'desc')->get();
                }
        // $rent = Rental::with(['customer.user', 'car'])->orderBy('created_at', 'desc')->get();
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

    // public function accept(Rental $rental){
    //     $loggedInUser = Auth::user();
    //     $rental->update(['status' => 'Accepted']);

    //     $log_entry = $loggedInUser->firstName . " " . $loggedInUser->lastName . " accepted a car rental with " . $rental->customer->user->firstName . " " . $rental->customer->user->lastName . " with the id# " . $rental->id;
    //     event(new UserLog($log_entry));

    //     $customer = $rental->customer;

    //     if ($customer && $customer->user) {
    //         $user = $customer->user;

    //         $rentalData = [
    //             'body' => "Hi $user->firstName  $user->lastName,",
    //             'rentalBody' => "Your scheduled car rental service for " . $rental->car->brand . " " . $rental->car->model .
    //                 " from " . $rental->start_date . " to " . $rental->end_date . " has been accepted. Please arrive ahead of the scheduled time.",
    //             'rentalText' => "Check here.",
    //             'url' => url('/'),
    //             'thankyou' => 'We look forward to providing you with our car rental service.'
    //         ];

    //         $user->notify(new RentNotification($rentalData));
    //     }

    //     return redirect('/rental')->with('message', 'Car Rental approved successfully.');
    // }

    public function accept(Rental $rental){
        $rental->update(['status' => 'Accepted']);

        $log_entry = Auth::user()->firstName . " " . Auth::user()->lastName . " declined a car rental with " . $rental->customer->user->firstName . " " . $rental->customer->user->lastName . " with the id# " . $rental->id;
        event(new UserLog($log_entry));

        $customer = $rental->customer;

        if ($customer && $customer->user) {
            $user = $customer->user;

            $rentalData = [
                'body' => "Hi $user->firstName  $user->lastName,",
                'rentalBody' => "Your scheduled car rental service for " . $rental->car->brand . " " . $rental->car->model .
                    " from " . $rental->start_date . " to " . $rental->end_date . " has been accepted. Please arrive ahead of the scheduled time.",
                'rentalText' => "Check here.",
                'url' => url('/'),
                'thankyou' => 'We look forward to providing you with our car rental service.'
            ];

            $user->notify(new RentNotification($rentalData));
        }

        return redirect('/rent')->with('message', 'Car Rental approved successfully.');
    }



    public function decline(Rental $rental){
        // Update the rental status to 'canceled'
        $rental->update(['status' => 'Declined']);


        $log_entry = Auth::user()->firstName . " " . Auth::user()->lastName . " declined a car rental with " . $rental->customer->user->firstName . " " . $rental->customer->user->lastName . " with the id# " . $rental->id;

        event(new UserLog($log_entry));

        $customer = $rental->customer;


        $user = $customer->user;

        $rentalData = [
            'body' => "Hello $user->firstName $user->lastName,",
            'rentalBody' => "We regret to inform you that we must decline your scheduled car rental service for the " . $rental->car->brand . " " . $rental->car->model .
                " from " . $rental->start_date . " to " . $rental->end_date . ". We apologize for any inconvenience this may cause.",
            'rentalText' => "For more details, please check here(" . url('/') . ").",
            'url' => url('/'),
            'thankyou' => 'Thank you for considering our car rental service. We appreciate your understanding and look forward to serving you in the future.'
        ];




        $user->notify(new RentNotification($rentalData));



        return redirect('/rent')->with('message', 'Car Rental declined successfully.');
    }
}
