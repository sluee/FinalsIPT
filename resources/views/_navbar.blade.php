<!-- component -->
<nav class=" bg-green-500 w-full flex relative justify-between items-center mx-auto px-8 h-20">
    <!-- logo -->
    <div class="inline-flex">
        <a class="_o6689fn" href="/"
            ><div class="hidden md:flex items-center">
                <img src="https://www.grab.com/sg/wp-content/uploads/sites/4/2018/07/02-illustration-partnerships.png" class="w-50 h-20" alt="Image">
                <h1 class="text-white text-3xl font-bold ml-2">SwiftDrive Solutions</h1>
            </div>
        </a>
    </div>


        <div class="flex-initial">
            <div class="flex justify-end items-center relative">
                <div class="flex mr-4 items-center">
                    <a class="inline-block py-2 px-3 hover:bg-green-400 rounded-full" href="/dashboard">
                        <div class="flex items-center relative text-white  cursor-pointer whitespace-nowrap">Dashboard</div>
                    </a>
                    @if(auth()->user()->hasRole('admin'))
                        <a class="inline-block py-2 px-3 hover:bg-green-400 rounded-full" href="/cars">
                            <div class="flex items-center relative text-white  cursor-pointer whitespace-nowrap">Cars</div>
                        </a>
                        <a class="inline-block py-2 px-3 hover:bg-green-400 rounded-full" href="/rent">
                            <div class="flex items-center relative text-white  cursor-pointer whitespace-nowrap">Rentals</div>
                        </a>
                        <a class="inline-block py-2 px-3 hover:bg-green-400 rounded-full" href="/customers">
                            <div class="flex items-center relative text-white  cursor-pointer whitespace-nowrap">Customers</div>
                        </a>
                        <a class="inline-block py-2 px-3 hover:bg-green-400 rounded-full" href="/logs">
                            <div class="flex items-center relative text-white  cursor-pointer whitespace-nowrap">Logs</div>
                        </a>


                    @endif

                    @if(auth()->user()->hasRole('customer'))
                        <a class="inline-block py-2 px-3 hover:bg-green-400  rounded-full" href="/cars">
                            <div class="flex items-center relative text-white  cursor-pointer whitespace-nowrap">Cars</div>
                        </a>
                        <a class="inline-block py-2 px-3 hover:bg-green-400  rounded-full" href="/rent">
                            <div class="flex items-center relative  text-white cursor-pointer whitespace-nowrap">Rentals</div>
                        </a>
                    @endif

                </div>

                <div class="flex justify-end items-center relative">
                    <form action="{{url('/logout')}}" method="POST" class="inline-block py-2 px-3 hover:bg-green-400 rounded-full">
                        {{csrf_field()}}
                        <button class="flex items-center relative  text-white cursor-pointer whitespace-nowrap"  type="submit">Logout</button>
                    </form>
                    {{-- <a class="inline-block py-2 px-3 hover:bg-green-400 rounded-full" href="/positions">
                        <div class="flex items-center relative text-white  cursor-pointer whitespace-nowrap">Logout</div>
                    </a> --}}

                </div>
            </div>
        </div>
    </div>
    <!-- end login -->
</nav>

<style scoped>

</style>
