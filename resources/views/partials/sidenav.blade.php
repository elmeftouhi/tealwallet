
<div id="sidenav" class="hide bg-gray-400 bg-opacity-25 w-full h-full absolute top-0 z-10">
    <nav class="relative bg-teal-700 text-teal-100 py-8 px-4 h-full shadow-xl w-64 text-xs -ml-64 overflow-auto">

        <div class="absolute top-0 -ml-2 mt-2 cursor-pointer hover:bg-teal-600 text-white text-xl font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline show_sidenav">
            <i class="fas fa-arrow-left"></i>
        </div>

        <div class="relative text-center mb-8">
            <div class="text-center w-full items-center mb-4">
                @if(Storage::disk('public')->exists(auth()->user()->avatar))
                    <img 
                        src="{{ asset('storage/'.auth()->user()->avatar) }}" 
                        alt="TealWallet User Avatar {{auth()->user()->avatar}}" 
                        class="rounded-full object-center object-cover w-16 m-auto"
                    >
                @else
                    <img 
                        src="https://icons.iconarchive.com/icons/papirus-team/papirus-apps/256/system-users-icon.png" 
                        alt="TealWallet User Avatar" 
                        class="rounded-full object-center object-cover h-10 w-10 m-auto"
                    >
                @endif
            </div>
            <h2 class="font-bold text-sm">{{ ucfirst( auth()->user()->name ) }}</h2>
            <h3 class="mb-4">Licence : Standard</h3>
            <a href="{{ route('user.edit') }}" class="absolute top-0 right-0 hover:bg-teal-800 hover: rounded cursor px-2 py-1"><i class="fas fa-user-edit"></i> Edit </a>

            <form 
                action="{{ route('logout') }}" 
                method="POST"
                class="hover:bg-teal-800 hover:rounded cursor px-2 py-1 inline"
            >
                @csrf
            <button><i class="fas fa-door-open"></i> LogOut</button>
            </form>
        </div>


        <ul class="expense_graph_sums">
            <li class="mb-2">
                <a href="{{ route('home') }}" class=" text-base block -mx-2 px-3 py-1 {{ request()->is('/') ? 'bg-teal-800 rounded' : 'hover:bg-teal-800 hover: rounded' }}">
                    <i class="fas fa-home text-xl"></i> Dashbord
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('expense.index') }}" class=" text-base block -mx-2 px-3 py-1 {{ Route::currentRouteNamed( 'expense.index' ) ?  'bg-teal-800 rounded' : 'hover:bg-teal-800 hover: rounded' }} ">
                    <i class="fas fa-hand-holding-usd text-xl"></i> Expenses
                </a>
            </li>
            <li class="mb-2">
            <a href="{{ route('category') }}" class=" text-base block -mx-2 px-3 py-1 {{ Route::currentRouteNamed( 'category' ) ?  'bg-teal-800 rounded' : 'hover:bg-teal-800 hover: rounded' }}">
                    <i class="fas fa-folder-open text-xl"></i> Expense Category
                </a>
            </li>
            <li class="my-2 text-lg mt-4">
                <h3>
                    Reports
                </h3>
            </li>
            <li class="mb-2">
                <a href="" class="block -mx-2 px-3 py-1 hover:bg-teal-800 hover: rounded">
                    <div class="flex justify-between items-center">
                        <div class="text-base">
                            <i class="fas fa-hand-holding-usd"></i> Today
                        </div>
                        <div class="text-teal-900 bg-teal-100 rounded-full px-2 text-xs sum_today">
                            ...
                        </div>
                    </div>
                    
                </a>
            </li>

            <li class="mb-2">
                <a href="" class="block -mx-2 px-3 py-1 hover:bg-teal-800 hover: rounded">
                    <div class="flex justify-between items-center">
                        <div class="text-base">
                            <i class="fas fa-hand-holding-usd"></i> This Week
                        </div>
                        <div class="text-teal-900 bg-teal-100 rounded-full px-2 text-xs sum_week">
                            ...
                        </div>
                    </div>
                    
                </a>
            </li>

            <li class="mb-2">
                <a href="" class="block -mx-2 px-3 py-1 hover:bg-teal-800 hover: rounded">
                    <div class="flex justify-between items-center">
                        <div class="text-base">
                            <i class="fas fa-hand-holding-usd"></i> This Month
                        </div>
                        <div class="text-teal-900 bg-teal-100 rounded-full px-2 text-xs sum_month">
                            ...
                        </div>
                    </div>
                    
                </a>
            </li>

            <li class="mb-2">
                <a href="" class="block -mx-2 px-3 py-1 hover:bg-teal-800 hover: rounded">
                    <div class="flex justify-between items-center">
                        <div class="text-base">
                            <i class="fas fa-hand-holding-usd"></i> This Year
                        </div>
                        <div class="text-teal-900 bg-teal-100 rounded-full px-2 text-xs sum_year">
                            ...
                        </div>
                    </div>
                    
                </a>
            </li>

        </ul>
    </nav>
</div>