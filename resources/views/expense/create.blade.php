@extends('layouts.app')
@section('title')
    <div class="flex items-center">
        <a href="{{ url()->previous() }}" class="rounded-full py-2 px-3 bg-gray-600 mr-2 text-gray-100">
            <i class="fas fa-arrow-left"></i>
        </a>
        <span>
           Expense <small>[New]</small> 
        </span>
    </div>
    
@endsection
@section('content')

    <form class="bg-white shadow-md rounded px-4 pt-6 pb-8 m-1" method="POST" action="{{ route( 'expense.store' ) }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">
                Amount 
            </label>
        <input 
            value="{{ old('amount') }}" 
            placeholder="0.00" 
            class="shadow text-center appearance-none border rounded w-full py-2 px-3 text-3xl text-white placeholder-white bg-green-400 leading-tight focus:outline-none focus:shadow-outline autofocus" 
            id="amount" 
            type="number" 
            step="any" 
            name="amount" 
            autofocus="autofocus"
            tabindex="1"
        >
            @error('amount')
                <div class="text-red-600 font-semibold text-sm py-1"> {{ $message }} </div> 
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="expense_date">
                Date 
            </label>
            <input 
                value="{{ date('Y-m-d\TH:i') }}" 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                id="expense_category" 
                type="datetime-local" 
                name="expense_date"
            >
            @error('expense_date')
                <div class="text-red-600 font-semibold text-sm py-1"> {{ $message }} </div> 
            @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="expense_categories">
                Expense Category
            </label>
            <select name="expense_category_id" id="expense_categories" class="shadow appearance-none border @error('expense_category_id')) border-red-600 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @foreach ($expense_categories as $k=>$category)
                    
                    <option @if($id_category == $category->id) selected @endif @if(old('expense_category_id') == $category->id) selected @endif value="{{ $category->id }}"> {{ $category->expense_category }} </option>
                @endforeach
            </select>
            @error('expense_category_id')
                <div class="text-red-600 font-semibold text-sm py-1"> {{ $message }} </div> 
            @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                Details
            </label>
            <input value="" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" type="text" placeholder="Details" name="description">
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-teal-500 active:bg-teal-800 active:shadow-inner hover:bg-teal-700 text-white font-bold py-2 px-4 rounded w-full" type="submit">
                Save
            </button>
        </div>
  </form>
@endsection