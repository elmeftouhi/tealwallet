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