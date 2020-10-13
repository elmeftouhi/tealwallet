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
            <li class="px-4 relative mr-2 notifications_show cursor-pointer">
                <a class="block text-xl text-teal-900 hover:text-pink-700">
                    <i class="fas fa-bell"></i>
                </a>
                @if(auth()->user()->alerts->where('unread', 0)->count() > 0)
                    <span class="absolute top-0 right-0 rounded-full px-1 text-pink-100 bg-red-600 text-xs mr-1 -mt-1">
                        {{ auth()->user()->alerts->count() }}
                    </span>
                @endif
            </li>
            <li class="">
                <a href="" class="block text-xl text-teal-900 hover:text-pink-700 show_full_screen border border-gray-400 py-2 px-3 rounded">
                    <i class="fas fa-expand-alt"></i>
                    <i class="fas fa-compress-alt hide"></i>
                </a>
            </li>
        </ul>               
    </div>



</nav>    
<div class="w-full h-full bg-gray-100 bg-opacity-0 absolute z-20 notifications hide">
    <div class="mt-12 mx-auto overflow-auto pt-1 right-0" style="height: auto; max-height: 220px; width: 290px; max-width: 310px;">
        <ul class="rounded overflow-hidden border-t-4 border-teal-900">
            @foreach (auth()->user()->alerts->where('unread', 0) as $alert)
                <li class="py-3 px-3 text-xs flex items-center border-b cursor-pointer hover:bg-teal-300 bg-teal-200">
                    <span class="flex-1 mr-1"> {{ $alert->alert_message }} </span>
                    <a class="w-5 text-red-600 cursor-pointer hover:bg-red-600 hover:text-white active:bg-red-700 py-2 px-1 text-center rounded"><i class="fas fa-trash-alt"></i></a>
                </li>                            
            @endforeach
        </ul>
    </div>
</div>