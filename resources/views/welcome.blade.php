<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
        <title>SwiftDrive Solutions</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


    </head>
    <body class="antialiased">
        <div class="h-screen w-screen bg-gray-50 flex items-center justify-center">
            <div class="container flex flex-col md:flex-row items-center justify-between px-5 text-gray-700">
                <div class="w-full lg:w-1/2 mx-8">
                    <div class="text-7xl text-green-500 font-dark font-extrabold mb-8"> SwiftDrive Solutions </div>
                    <p class="text-2xl md:text-3xl font-light leading-normal mb-8">
                        "Empower your journey with Swiftdrive Solutions: Where Efficiency Meets Mobility, and Innovation Unlocks Every Mile."
                    </p>

                    <a href="/login" class="px-5 inline py-3 text-sm font-medium leading-5 shadow-2xl text-white transition-all duration-400 border border-transparent rounded-lg focus:outline-none bg-green-600 active:bg-green-700 hover:bg-green-800">Get Started</a>
                </div>
                <div class="w-full lg:flex lg:justify-end lg:w-1/2 mx-5 my-12">
                <img src="https://www.grab.com/sg/wp-content/uploads/sites/4/2018/07/02-illustration-partnerships.png" class="" alt="Image">
                </div>
            </div>
        </div>

    </body>
</html>
