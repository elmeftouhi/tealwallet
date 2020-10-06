@extends('layouts.app')
@section('title')
    <div class="flex items-center">
        <a href="{{ url()->previous() }}" class="rounded-full py-2 px-3 bg-gray-600 mr-2 text-gray-100">
            <i class="fas fa-arrow-left"></i>
        </a>
        <span>
           Expense Category <small>[New]</small> 
        </span>
    </div>
    
@endsection
@section('content')

    <form class="bg-white shadow-md rounded px-4 pt-6 pb-8 m-1" method="POST" action="{{ route( 'category.store' ) }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="expense_category">
                Category Name
            </label>
            <input value="" class="shadow appearance-none border @error('expense_category')) border-red-600 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="expense_category" type="text" placeholder="Category Name" name="expense_category">
            @error('expense_category')
                <div class="text-red-600 font-semibold text-sm py-1"> {{ $message }} </div> 
            @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="icon">
                Icons : 
            </label>
            <div class="flex justify-between items-center">
                <select name="icon" id="icon" class="shadow appearance-none border @error('icon')) border-red-600 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach ($icons as $k=>$icon)
                        <option data-icon="{{ $icon }}" value="{{ $icon }}"> {{ $k }} </option>
                    @endforeach
                </select>  
                <span class="icon_display pl-6 text-2xl w-20">{!! $icons['cars & Fuel'] !!}</span>
            </div>

            @error('icon')
                <div class="text-red-600 font-semibold text-sm py-1"> {{ $message }} </div> 
            @enderror
        </div>
        <div class="flex mt-6 mb-6">
            <label class="flex items-center">
              <input type="checkbox" class="form-checkbox" name="status">
              <span class="ml-2">Enable / Disable</span>
            </label>
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-teal-500 active:bg-teal-800 active:shadow-inner hover:bg-teal-700 text-white font-bold py-2 px-4 rounded w-full" type="submit">
                Save
            </button>
        </div>
  </form>
@endsection