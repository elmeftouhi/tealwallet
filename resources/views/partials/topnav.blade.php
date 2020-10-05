<nav class="flex flex-shrink-0 justify-between items-center bg-white text-gray-800 border-b shadow-sm z-10">
    <div class="flex items-center">
        <div class="bg-teal-900 text-pink-100 mr-2">
            <a 
                class="text-center w-12 py-4 md:py-3 lg:py-3 show_sidenav outline-none block active:bg-teal-600 hover:bg-teal-700 cursor-pointer"
            >
                <i class="fas fa-bars"></i>
            </a>
        </div>
        
        <div class="text-red"> 
            <a href="/" class="flex items-center"> 
                <img class="h-8 md:h-8 mr-1" src="{{ asset('storage/masrofi_logo.png') }}" alt="Masrofi Logo"/>
                <span class="font-bold text-pink-900 text-xl md:text-xl"> {{ config('app.name') }} </span>
            </a>
        </div>              
    </div>
    <div class="pr-2">
        <ul class="flex items-center flex-1">
            <li class="px-4 relative">
                <a href="" class="block text-xl text-teal-900 hover:text-pink-700">
                    <i class="fas fa-bell"></i>
                </a>
                <span class="absolute top-0 right-0 rounded-full px-1 text-pink-100 bg-red-600 text-xs mr-1 -mt-1">
                    0
                </span>
            </li>
        </ul>               
    </div>

</nav>