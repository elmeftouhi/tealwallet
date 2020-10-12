<div class="flex justify-between items-center px-3 mt-8 text-sm text-teal-600">
    <a href="{{ route('expense.index')}}" class="w-1/2 card mr-2 text-center relative mb-1 pt-4 pb-8">
        <span class="font-semibold text-xl lg:text-base sum_today">...</span>
        <div class="text-center text-red-600 absolute bottom-0 right-0 mr-2 mb-2" style="font-size: 10px">
            Avg : 
            <span class="avg_day font-bold">...</span>
            /Day
        </div>
        <span class="absolute top-0 left-0 -mt-3 bg-teal-600 text-teal-100 rounded px-2 text-xs">Today</span>

    </a>
    <a href="{{ route('expense.index')}}" class="w-1/2 card text-center relative mb-1 pt-4 pb-8">
        <span class="font-semibold text-xl lg:text-base sum_month">...</span>
        <div class="text-center text-red-600 absolute bottom-0 right-0 mr-2 mb-2" style="font-size: 10px">
            Avg : 
            <span class="avg_month font-bold">...</span>
            /Month
        </div>
        <span class="absolute top-0 left-0 -mt-3 bg-teal-600 text-teal-100 rounded px-2 text-xs">This Month</span>
    </a>  
</div>