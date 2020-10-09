@extends('layouts.app')
@section('title')
    <div class="flex items-center">
        <a href="{{ url()->previous() }}" class="rounded-full py-2 px-3 bg-gray-600 mr-2 text-gray-100">
            <i class="fas fa-arrow-left"></i>
        </a>
        <span>
           Expense Category <small>[Edit]</small> 
        </span>
    </div>
    
@endsection
@section('content')
    <form class="bg-white shadow-md rounded px-4 pt-6 pb-8 m-1" method="POST" action="{{ route( 'category.update', $category->id ) }}">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="expense_category">
                Category Name
            </label>
            <input value="{{ $category->expense_category }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="expense_category" type="text" placeholder="Username" name="expense_category">
        </div>

        <div class="flex">
            <div class="mb-4 flex-1">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="icon">
                    Icons : 
                </label>
                <div class="flex justify-between items-center">
                    <select name="icon" id="icon" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach ($icons as $k=>$icon)
                            @if ($icon === $category->icon)
                                <option selected data-icon="{{ $icon }}" value="{{ $icon }}"> {{ $k }} </option>
                            @else
                                <option data-icon="{{ $icon }}" value="{{ $icon }}"> {{ $k }} </option>
                            @endif
                        
                        @endforeach
                    </select>
                    <span class="icon_display pl-6 text-2xl w-20">{!! $category->icon !!}</span>
                </div>
            </div>
    
            <div class="mb-4 ml-4 w-20">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="expense_level">
                    Position
                </label>
                <input value="{{ $category->level }}" class="text-center shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="expense_level" type="number" placeholder="0" name="level">
            </div>
        </div>


        <div class="flex mt-1 mb-6">
            <label class="flex items-center">
              <input type="checkbox" class="form-checkbox" name="status" @if($category->status) checked @endif>
              <span class="ml-2">Enable / Disable</span>
            </label>
        </div>

        <div class="flex mt-1 mb-1">
            <label class="flex items-center">
              <input type="checkbox" class="form-checkbox" name="is_budget" @if($category->is_budget) checked @endif>
              <span class="ml-2">Budget / Month</span>
            </label>
        </div>
        <div class="mb-4">
            <input value="{{ $category->budget_amount }}" class="text-center shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="budget_amount" type="number" placeholder="0" name="budget_amount">
        </div>
        <?php 
            $total_this_month = $category->month_expenses()->sum("amount");
            $diff = $category->budget_amount - $total_this_month;
            $percentage = 0;
            if($category->budget_amount-$total_this_month >= 0 ){
                $percentage = ( ($category->month_expenses()->sum("amount") / $category->budget_amount) * 100 ) . '%';
            }else{
                $percentage = '100%';
            }
                
        ?>

        <div class="h-4 bg-gray-200 w-full mb-12 mt-8 py-1 px-1 items-center rounded-full relative">
            <div class="{{ $diff > 0? 'bg-teal-900':'bg-red-600' }} h-2 rounded-full max-w-full" style="width: {{ $percentage }}"></div>
            <div class="text-center w-full absolute top-0 left-0 text-teal-800 -mt-5 text-xs">
                {!! ($category->budget_amount - $total_this_month) > 0 ? '<span class="text-green-600">' . $percentage . ' (Amount left : +' . $diff . ')</span>': '<span class="text-red-600">(' . $percentage . ' Amount exceed : ' . $diff . ')</span>' !!}
            </div>
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-teal-500 active:bg-teal-800 active:shadow-inner hover:bg-teal-700 text-white font-bold py-2 px-4 rounded w-1/2" type="submit">
                Save
            </button>
            <button class="text-red-400 text-sm hover:underline focus:text-red-600 active:text-red-800" id="category_destory_btn"><i class="far fa-trash-alt"></i> Delete Category</button>
        </div>
  </form>
    <form action="{{ route('category.destroy', $category->id ) }}" method="POST" id="category_destroy">
        @csrf
        @method('DELETE')

    </form>
@endsection