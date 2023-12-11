@extends('base')
@include('_navbar')

@section('content')
<div class="h-screen bg-gray-50 p-5 flex justify-center items-center">
	<div class="lg:w-2/5 md:w-1/2 w-2/3">
        <form method="POST" action="{{ route('cars.rent.store', ['car' => $car]) }}"  class="bg-white p-10 rounded-lg shadow-lg min-w-full px-10 ">
            {{csrf_field()}}
            <h1 class="text-center text-2xl  text-green-600 font-bold font-sans">Rent a Car</h1>
            <p class="text-center text-base mb-6 text-gray-500 font-bold font-sans">Enter Details here:</p>

            <div class="flex -mx-3">
                <div class="w-full px-3 mb-5">
                    <label for="year" class="text-xs font-semibold px-1">Customer:</label>
                    <div class="flex">
                        <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                          </svg>

                          </div>
                            @if(auth()->user()->hasRole('customer'))
                            <!-- Show the name of the logged-in patient -->
                                <input type="text" value="{{ auth()->user()->firstName }} {{ auth()->user()->lastName }}" readonly class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-green-500">
                            @else
                          <!-- Show the dropdown for selecting patients -->
                            <select id="cust_id" name="cust_id" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-green-500">
                                <option disabled selected>Choose a Customer</option>
                                @foreach($customer as $cust)
                                    <option value="{{ $cust->id }}">{{ $cust->user->firstName }} {{ $cust->user->lastName }}</option>
                                @endforeach
                            </select>
                      @endif
                    </div>
                    @error('cust_id')
                        <p class="text-red-500 text-xs mt-2">{{$message}}</p>
                    @enderror
                </div>

            </div>
            <!-- Car Brand and Model -->
        <div class="flex -mx-3">
            <div class="w-full px-3 mb-5">
                <label for="car_id" class="text-xs font-semibold px-1">Car Brand and Model</label>
                <div class="flex">
                    <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                        </svg>
                    </div>
                    <!-- Add this hidden input field to include car_id in the form submission -->
                <input type="hidden" name="car_id" value="{{ $car->id }}">

    <!-- Display the selected car's details (readonly text field) -->
        <input type="text" value="{{ $car->brand }} {{ $car->model }} | {{ $car->year }} " readonly class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-green-500" placeholder="" name="car_details" id="car_details">

                        <!-- Display the selected car's details -->
                        {{-- <input type="text" value="{{ $car->brand }} {{ $car->model }} | {{ $car->year }} " readonly class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-green-500" placeholder="" name="car_id" id="car_id"> --}}

                </div>
                @error('car_id')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="flex -mx-3">
            <div class="w-full px-3 mb-5">
                <label for="car_id" class="text-xs font-semibold px-1">Rate Per Day</label>
                <div class="flex">
                    <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                    </div>

                        <!-- Display the selected car's details -->
                        <input type="text" value="{{ $car->pricePerDay }} " readonly class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-green-500" placeholder="" name="car_id" id="car_id">

                </div>
                @error('car_id')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>


            <div class="flex -mx-3">
                <div class="w-1/2 px-3 mb-5">
                    <label for="brand" class="text-xs font-semibold px-1">Start Date</label>
                    <div class="flex">
                        <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                          </div>
                        <input type="date" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-green-500" placeholder="" name="start_date" id="start_date">

                    </div>
                    @error('start_date')
                        <p class="text-red-500 text-xs mt-2">{{$message}}</p>
                    @enderror
                </div>
                <div class="w-1/2 px-3 mb-5">
                    <label for="model" class="text-xs font-semibold px-1">End Date</label>
                    <div class="flex">
                        <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>

                          </div>
                        <input type="date" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-green-500" placeholder="" name="end_date" id="end_date">

                    </div>
                    @error('end_date')
                        <p class="text-red-500 text-xs mt-2">{{$message}}</p>
                     @enderror
                </div>

            </div>

            <div class="flex -mx-3">
                <div class="w-full px-3 mb-5">
                    <label for="pricePerDay" class="text-xs font-semibold px-1">Total Cost</label>
                    <div class="flex">
                        <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                          </div>
                        <input type="text" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500"  name="totalCost" id="totalCost" >

                    </div>
                    @error('totalCost')
                            <p class="text-red-500 text-xs mt-2">{{$message}}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="w-full mt-6 bg-green-600 rounded-lg px-4 py-2 text-lg text-white tracking-wide font-semibold font-sans mb-5">Rent Car</button>
		</form>
	</div>
</div>
@endsection
