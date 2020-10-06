@extends('layouts.app')
@section('title')
    <div class="flex items-center">
        <a href="{{ url()->previous() }}" class="rounded-full py-2 px-3 bg-gray-600 mr-2 text-gray-100">
            <i class="fas fa-arrow-left"></i>
        </a>
        <span>
           Expense <small>[Edit]</small> 
        </span>
    </div>
    
@endsection
@section('content')

    <form class="bg-white shadow-md rounded px-4 pt-6 pb-8 m-1" method="POST" action="{{ route( 'expense.update', $expense->id ) }}">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">
                Amount 
            </label>
        <input value="{{ $expense->amount }}" placeholder="0.00" class="shadow text-center appearance-none border rounded w-full py-2 px-3 text-3xl text-white placeholder-white bg-green-400 leading-tight focus:outline-none focus:shadow-outline" id="amount" type="number" step="any" name="amount">
            @error('amount')
                <div class="text-red-600 font-semibold text-sm py-1"> {{ $message }} </div> 
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="expense_date">
                Date 
            </label>
            <input 
                value="{{ Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d\TH:i') }}" 
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
                    <option @if( $expense->expense_category_id == $category->id) selected @endif value="{{ $category->id }}"> {{ $category->expense_category }} </option>
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
            <input value="{{ $expense->description }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" type="text" placeholder="Details" name="description">
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-teal-500 active:bg-teal-800 active:shadow-inner hover:bg-teal-700 text-white font-bold py-2 px-4 rounded w-1/2" type="submit">
                Save
            </button>
            <button class="text-red-400 text-sm hover:underline focus:text-red-600 active:text-red-800" id="expense_destory_btn"><i class="far fa-trash-alt"></i> Delete Expense</button>
        </div>
  </form>
  <form action="{{ route('expense.destroy', $expense->id ) }}" method="POST" id="expense_destroy">
    @csrf
    @method('DELETE')

</form>
@endsection