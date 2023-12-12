@extends('base')
@include('_navbar')

@section('content')
<div class="bg-gray-50 p-8 rounded-md w-full ">
	<div class=" flex items-center justify-between pb-6">
            <div>
                <h2 class=" text-3xl text-gray-600 font-semibold ">List of Cars</h2>
                <span class="text-xl">All cars </span>
            </div>
            <div class="flex items-center justify-between">
                <div class="lg:ml-40 ml-10 space-x-8">
                    @if(session('message'))
                        <div class="alert bg-green-500 p-4">
                            {{session('message')}}
                        </div>
                    @endif
                    @if(auth()->user()->hasRole('admin'))
                        <a href="/cars/create" type="button" class="bg-green-500 px-4 py-2 rounded-md text-white font-normal tracking-wide cursor-pointer">
                            <i class="fa-solid fa-user-plus"></i> Create Cars
                        </a>
                    @endif
                    {{-- <button class="bg-indigo-600 px-4 py-2 rounded-md text-white font-semibold tracking-wide cursor-pointer">New Report</button> --}}
                    {{-- <button class="bg-green-500 px-4 py-2 rounded-md text-white font-normal tracking-wide cursor-pointer">Create Position</button> --}}
                </div>
            </div>
		</div>
        <div class="flex-1 pr-4">
            <div class="relative md:w-1/3">
                <input type="search"
                    class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                    placeholder="Search cars...">
                <div class="absolute top-0 left-0 inline-flex items-center p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <circle cx="10" cy="10" r="7" />
                        <line x1="21" y1="21" x2="15" y2="15" />
                    </svg>
                </div>
            </div>
        </div>
        <!-- component -->
        <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-4 py-12">
            <div class="text-center pb-12">
                <h2 class="text-base font-bold text-green-600">
                    SwiftDrive Solutions – Your Fast Lane to Seamless Transportation!
                </h2>
                <h2 class="font-bold text-xl md:text-xl lg:text-1xl font-heading text-gray-900">
                    Discover our amazing range of rental cars and experience top-notch quality on the road!
                </h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($cars as $car)
                    <div class="w-full bg-gray-100 rounded-lg shadow-lg overflow-hidden flex flex-col justify-center items-center">
                        @if($car->type === 'Pickup')
                            <div>
                                <img class="object-center object-cover h-auto w-full" src="/images/Pickup.jpg" alt="photo">
                            </div>
                        @elseif($car->type === 'SUV')
                            <div>
                                <img class="object-center object-cover h-auto w-full" src="/images/suv.jpg" alt="photo">
                            </div>
                        @elseif ($car->type === 'Van')
                            <div>
                                <img class="object-center object-cover h-auto w-full" src="/images/van.jpg" alt="photo">
                            </div>
                        @else
                            <div>
                                <img class="object-center object-cover h-auto w-full" src="/images/sedan.jpg" alt="photo">
                            </div>
                        @endif

                        <div class="text-center py-8 sm:py-6">
                            <p class="text-base text-green-700 font-bold mb-2 text-end">₱ {{$car->pricePerDay}} per Day</p>
                            <p class="text-xl text-gray-700 font-bold mb-2">{{$car->brand}} | {{$car->model}} </p>
                            <p class="text-base text-gray-400 font-normal">{{$car->type}} | {{$car->year}} released | {{$car->capacity}} seater</p>
                        </div>
                        @if(auth()->user()->hasRole('customer'))
                            <div class="flex px-10 mb-2 justify-center">
                                <a href="/rent/create/{{$car->id}}" class="flex items-center justify-center w-full h-12 px-6 text-m uppercase bg-green-400 rounded-lg hover:bg-green-500">Rent Car now</a>
                            </div>
                        @endif
                    </div>
                @endforeach

            </div>
        </section>
</div>

@endsection
