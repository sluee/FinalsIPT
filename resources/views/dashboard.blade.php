@extends('base')
@include('_navbar')

@section('content')
<div class="py-2">
    <main class="overflow-y-auto">
        <div class="container mx-auto grid">

          <!-- Cards -->
          <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-2  mt-5">
            <!-- Card -->
            <div class="flex items-center p-4 rounded-lg shadow-xs dark:bg-gray-800">
              <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
              </div>
              <div>
                <p class="mb-2 text-lg font-medium text-white dark:text-white">
                 No. of Users
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{$registeredUsers}}
                </p>
              </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
              <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
              </div>
              <div>
                <p class="mb-2 text-lg font-medium text-gray-600 dark:text-gray-400">
                  No. of Cars
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{$allCars}}
                </p>
              </div>
            </div>

            <!-- Card -->

          </div>

        </div>
    </main>

</div>
<div class=" bg-gray-50 flex items-center justify-center ">
    <div class="container flex flex-col md:flex-row items-center justify-between px-5 text-gray-700">
        <div class="w-full lg:w-1/2 mx-8">
            <div class="text-7xl text-green-500 font-dark font-extrabold mb-8"> SwiftDrive Solutions </div>
            <p class="text-2xl md:text-3xl font-light leading-normal mb-8">
                "Empower your journey with Swiftdrive Solutions: Where Efficiency Meets Mobility, and Innovation Unlocks Every Mile."
            </p>

            {{-- <a href="/login" class="px-5 inline py-3 text-sm font-medium leading-5 shadow-2xl text-white transition-all duration-400 border border-transparent rounded-lg focus:outline-none bg-green-600 active:bg-green-700 hover:bg-green-800">Get Started</a> --}}
        </div>
        <div class="w-full lg:flex lg:justify-end lg:w-1/2 mx-5 my-12">
        <img src="https://www.grab.com/sg/wp-content/uploads/sites/4/2018/07/02-illustration-partnerships.png" class="" alt="Image">
        </div>
    </div>
</div>


@endsection
