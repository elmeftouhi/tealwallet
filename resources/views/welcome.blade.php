@extends('layouts.app')
@section('title')
    Expenses
@endsection
@section('content')
    
    <div class="bg-white border rounded m-1 shadow relative">
        <div class="hide flex absolute w-full h-full bg-gray-800 bg-opacity-25">
            <div class="lds-ripple m-auto">
                <div></div>
                <div></div>
            </div>                
        </div>


        <div class="flex justify-between px-3 py-4 items-center">
            <div class="flex items-center">
                <div class="border rounded text-sm py-1 px-2 mr-2">
                    <select name="" id="" class="chart_periode">
                        <option value="month">Month</option>
                        <option value="year">Year</option>
                    </select>
                </div>
                <div class="border rounded text-sm py-1 px-2">
                    <select name="" id="" class="chart_type">
                        <option value="line">Line</option>
                        <option value="bar">Bar</option>
                    </select>
                </div>
            </div>
            <div class="flex">
                <button class="border bg-gray-100 px-3 py-2 mx-1 hover:bg-gray-200 active:bg-gray-300 chart_change" data-direction="prev" data-value="0"><i class="fas fa-angle-left"></i></button>
                <button class="border bg-gray-100 px-3 py-2 mx-1 hover:bg-gray-200 active:bg-gray-300 chart_change" data-direction="next" data-value="0"><i class="fas fa-angle-right"></i></button>
            </div>
        </div>

        <div class="">
            <canvas id="myChart" width="100%" height="50">

            </canvas>

        </div>

    </div>

    <div class="flex justify-between items-center px-3 py-3 ">
        <h1 class="font-sans font-bold subpixel-antialiased text-base text-gray-700 ">
            Categories
        </h1>  
        <span class="text-red-800 font-bold sum_month">...</span>         
    </div>

    <div class="px-2 pb-10" style="columns: 2; ">
        @foreach ($categories as $category)
        <a href="{{ route('expense.create_with_category', ['id_category'=>$category->id]) }}" 
            class="block rounded-lg p-5 transition-all border bg-white mb-4 shadow-md transform hover:bg-gray-200 active:bg-gray-300 cursor-pointer @if($category->month_expenses->where('user_id', Auth::id())->sum('amount') > 0) bg-teal-400 hover:bg-teal-300 active:bg-teal-500 @endif" 
            style="break-inside: avoid"
        >
            <div class="text-2xl">
                {!! $category->icon !!}
            </div>
            <p class="text-sm font-medium font-semibold uppercase tracking-wide mt-2">
                {{ $category->expense_category }}
            </p>
            <p class="text-right text-teal-600 font-bold text-base">
                @money ( $category->month_expenses->where('user_id', Auth::id())->sum('amount') )
            </p>
        </a>
        @endforeach
    </div>
@endsection