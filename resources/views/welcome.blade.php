@extends('layouts.app')

@section('content')
    
    @include('partials.cards')
    
    @include('partials.graph')

    <div class="flex justify-between items-center px-3 py-3 ">
        <h1 class="font-sans font-bold subpixel-antialiased text-base text-gray-700 ">
            Categories
        </h1>  
        <span class="text-teal-900 font-bold sum_month">...</span>         
    </div>

    <div class="px-2 pb-10" style="columns: 2; ">
        @foreach ($categories as $category)


        <?php 
            $total_this_month = $category->month_expenses->where('user_id', Auth::id())->sum('amount');
            $diff = $category->budget_amount - $total_this_month;
            $percentage = 0;
            if($diff > 0 ){
                $percentage = ( ($category->month_expenses()->sum("amount") / $category->budget_amount) * 100 ) . '%';
            }else{
                $percentage = '100%';
            }
                
        ?>

        <a href="{{ route('expense.create_with_category', ['id_category'=>$category->id]) }}" 
            class="block rounded-lg py-5 px-2 sm:p-5 transition-all border bg-white mb-4 shadow-md transform hover:bg-gray-200 active:bg-gray-300 cursor-pointer @if($total_this_month > 0) bg-teal-400 hover:bg-teal-300 active:bg-teal-500 @endif" 
            style="break-inside: avoid"
        >
            <div class="text-2xl">
                {!! $category->icon !!}
            </div>
            <p class="text-xs sm:text-sm font-medium font-semibold uppercase tracking-wide mt-2">
                {{ $category->expense_category }}
            </p>
            <p class="text-right text-teal-600 font-bold text-base">
                @money ( $total_this_month )
            </p>

            @if($category->is_budget)
                <div class="h-2 bg-gray-200 w-full mt-8 px-1 items-center rounded-full relative" style="padding-top: 2px; padding-bottom: 1px">
                    <div class="{{ $diff > 0? 'bg-teal-900':'bg-red-600' }} h-1 rounded-full max-w-full" style="width: {{ $percentage }}"></div>
                    <div class="text-center w-full absolute top-0 left-0 text-teal-800 -mt-5 text-xs">
                        {!! $diff > 0 ? '<span class="text-green-600">' . $percentage . ' </span>': '<span class="text-red-600">(' . $percentage . ')</span>' !!}
                    </div>
                </div>
            @endif

        </a>
        @endforeach
    </div>
@endsection