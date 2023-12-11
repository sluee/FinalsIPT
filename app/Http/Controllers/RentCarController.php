<?php

namespace App\Http\Controllers;

use App\Events\UserLog;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Rental;
use App\Notifications\RentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentCarController extends Controller
{
    public function create( Car $car){
        $customer = Customer::with('user')->get();

        return view('cars.rent', [
            'car' => $car,
            'customer' => $customer
        ]);
    }

    public function store(Request $request){
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

       if ($user->hasRole('customer')) {
           $log_entry = Auth::user()->firstName . " " . Auth::user()->lastName . " rented a car " . $rental->car->brand . " " . $rental->car->model . " with the id #" . $rental->id;
       } else {
           $log_entry = Auth::user()->name . " rented a car for  " . $rental->customer->user->firstName ." ".$rental->customer->user->firstName. "a car  ".  $rental->car->brand . " " . $rental->car->model . " with the id# " . $rental->id;
       }
       event(new UserLog($log_entry));

        $successMessage = $user->hasRole('customer')
            ? 'Car Rental request submitted successfully. Please check email for notification'
            : 'Car Rental added successfully.';

            // $log_entry = Auth::user()->firstName . " " . Auth::user()->lastName . " rented a car " . $rental->car->brand . " " . $rental->car->model . " with the id #" . $rental->id;

            if ($user->hasRole('admin')) {
                $customer = $rental->customer;
                $user = $customer->user;

                $rentalData = [
                    'body' => "Hi $user->firstName  $user->lastName,",
                    'rentalBody' => "Just a friendly reminder that you have a scheduled car rental service for " . $rental->car->brand . $rental->car->model .
                        " from " . $rental->start_date . " to " . $rental->end_date . ". Please make sure everything is in order.",
                    'rentalText' => "Check here.",
                    'url' => url('/'),
                    'thankyou' => 'We look forward to providing you with our car rental service.'
                ];
                $user->notify(new RentNotification($rentalData));
            } elseif ($user->hasRole('customer')) {
                // Handle customer notification here
                // You can customize the notification content based on the customer's role
            }

        return redirect('/cars')->with('message', $successMessage);
    }
}
