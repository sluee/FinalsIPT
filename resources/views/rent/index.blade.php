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

                <a href="/rent/create" type="button" class="bg-green-500 hover:bg-green-700 px-4 py-2 rounded-md text-white font-normal tracking-wide cursor-pointer" >
                    <i class="fa-solid fa-plus"></i> Create Rentals
                </a>

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
                                    {{$rnt->totalCost}}
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
                                            <div class="w-4 mr-5 transform hover:text-purple-500 hover:scale-110">
                                                <form method="POST" action="{{ url('/rent/accept/'. $rnt->id) }}">
                                                    @csrf
                                            <button type="submit"  title="Accept Rental">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                                                </svg>


                                                </button>
                                                </form>
                                            </div>
                                            <div class="w-4 mr-2 transform hover:text-gray-500 hover:scale-110">
                                                <form method="POST" action="{{ url('/rent/declined/'. $rnt->id) }}">
                                                    @csrf
                                                <button type="submit" title="Decline Rent">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 15h2.25m8.024-9.75c.011.05.028.1.052.148.591 1.2.924 2.55.924 3.977a8.96 8.96 0 01-.999 4.125m.023-8.25c-.076-.365.183-.75.575-.75h.908c.889 0 1.713.518 1.972 1.368.339 1.11.521 2.287.521 3.507 0 1.553-.295 3.036-.831 4.398C20.613 14.547 19.833 15 19 15h-1.053c-.472 0-.745-.556-.5-.96a8.95 8.95 0 00.303-.54m.023-8.25H16.48a4.5 4.5 0 01-1.423-.23l-3.114-1.04a4.5 4.5 0 00-1.423-.23H6.504c-.618 0-1.217.247-1.605.729A11.95 11.95 0 002.25 12c0 .434.023.863.068 1.285C2.427 14.306 3.346 15 4.372 15h3.126c.618 0 .991.724.725 1.282A7.471 7.471 0 007.5 19.5a2.25 2.25 0 002.25 2.25.75.75 0 00.75-.75v-.633c0-.573.11-1.14.322-1.672.304-.76.93-1.33 1.653-1.715a9.04 9.04 0 002.86-2.4c.498-.634 1.226-1.08 2.032-1.08h.384" />
                                                    </svg>
                                                </button>
                                                </form>
                                            </div>
                                            @else
                                            <p class="text-xs text-center text-yellow-900 bg-yellow-400 uppercase px-2 py-1 rounded-full w-50 border font-bold first-letter">Done</p>
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
