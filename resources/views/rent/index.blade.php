@extends('base')
@include('_navbar')

@section('content')


<div class=" p-8 rounded-md w-full ">
    <div class=" flex items-center justify-between pb-6">
        <div>
            <h2 class="text-gray-600 font-semibold text-2xl">List of Rentals</h2>

        </div>
        <div class="flex items-center justify-between">
            <div class="lg:ml-40 ml-10 space-x-8 justify-between">
                @if(session('message'))
                    <div class="alert bg-green-400 p-4">
                        {{session('message')}}
                    </div>
                @endif

                @if(session('error'))
                <div class="alert bg-red-400 p-4">
                    {{session('error')}}
                </div>
            @endif
            @if(auth()->user()->hasRole('admin'))
                <a href="/rent/create" type="button" class="bg-green-500 hover:bg-green-700 px-4 py-2 rounded-md text-white font-normal tracking-wide cursor-pointer" >
                    <i class="fa-solid fa-plus"></i> Create Rentals
                </a>
            @endif
            </div>
        </div>
    </div>
    <div class="flex-1 pr-4">
        <div class="relative md:w-1/3">
            <input type="search Employee"
                class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                placeholder="Search...">
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
    <div>
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>

                        <tr>

                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Customer Name
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Caar
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Start Date
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                End Date
                            </th>

                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Total Cost
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            @if(auth()->user()->hasRole('admin'))
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Action
                            </th>
                            @endif

                        </tr>
                    </thead>
                    <tbody >
                        @foreach($rent as $rnt)
                            <tr class="border-b border-gray-200">

                                <td class="px-5 py-2 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                      {{$rnt->customer->user->firstName}}   {{$rnt->customer->user->lastName}}
                                    </p>
                                </td>
                                <td class="px-5 py-3 bg-white text-sm">
                                    {{$rnt->car->brand}} {{$rnt->car->model}}
                                </td>

                                <td class="px-5 py-3 bg-white text-sm">
                                   {{$rnt->start_date}}
                                </td>
                                <td class="px-5 py-3 bg-white text-sm">
                                    {{$rnt->end_date}}
                                 </td>
                                <td class="px-5 py-3 bg-white text-sm">
                                    ₱ {{$rnt->totalCost}}
                                 </td>
                                    <td class="px-5 py-3 bg-white text-sm">
                                        <p class="text-xs uppercase px-2 py-1 text-center rounded-full w-50 border font-bold first-letter
                                        @if($rnt->status == "Pending")
                                            text-green-800 bg-green-400
                                        @elseif($rnt->status == "Accepted")
                                            text-blue-900 bg-blue-400
                                        @elseif($rnt->status == "Declined")
                                            text-red-900 bg-red-400
                                        @endif
                                        leading-tight"
                                    >{{ $rnt->status }}</p>

                                    </td>
                                    @if(auth()->user()->hasRole('admin'))
                                    <td class="px-5 py-3 bg-white text-sm">
                                        <div class="flex item-center justify-center">
                                            @if($rnt->status === 'Pending')
                                                <div class="w-4 mr-5 transform hover:text-green-500 hover:scale-110">
                                                    <form method="POST" action="{{ url('/rent/accept/'. $rnt->id) }}">
                                                        @csrf
                                                        <button type="submit" title="Accept Rental">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                              </svg>

                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
                                                    <form method="POST" action="{{ url('/rent/declined/'. $rnt->id) }}">
                                                        @csrf
                                                        <button type="submit" title="Decline Rent">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                              </svg>

                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <p class="text-xs text-center text-yellow-900 bg-yellow-400 uppercase px-2 py-1 rounded-full w-50 border font-bold first-letter">&#9733;</p>
                                            @endif
                                        </div>
                                    </td>

                                    @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection
