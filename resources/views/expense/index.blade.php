@extends('layouts.app')
@section('title')
<div class="flex items-center justify-between">
    <div class="">
        <a href="{{ route('home') }}" class="rounded-full py-2 px-3 bg-gray-600 mr-2 text-gray-100">
            <i class="fas fa-arrow-left"></i>
        </a>
        <span> Expense </span>   
    </div>
    <div class="flex items-center p-1 bg-gray-100 rounded-lg">
        <a href="{{ route('expense.month', ["month"=>$dates['prev'][0], "year"=>$dates['prev'][1]]) }}" class="mx-4 block hover:text-gray-500"><i class="fas fa-chevron-left"></i></a>
        <div class="text-xs dates_current">{{ $dates['current'][0] . ' - ' . $dates['current'][1] }}</div>
        <a href="{{ route('expense.month', ["month"=>$dates['next'][0], "year"=>$dates['next'][1]]) }}" class="mx-4 block hover:text-gray-500"><i class="fas fa-chevron-right"></i></a>
    </div>
</div>
@endsection


@section('content')

    <div class="card m-1">
        <div class="relative">
            <div class="flex absolute w-full h-full bg-gray-800 bg-opacity-25">
                <div class="lds-ripple m-auto">
                    <div></div>
                    <div></div>
                </div>                
            </div>
            <canvas id="myPieChart" width="100%" height="80"></canvas>
        </div>
    </div>

    <div class="rounded bg-white shadow text-gray-700 m-1 overflow-hidden pb-16 relative">
        <div class="flex justify-between items-center py-4 px-3">
            <form method="GET" action="{{ route('expense.search') }}" class="flex items-center relative flex-1 m-0" id="expense.search">
                <input 
                    type="text" 
                    class="border py-1 pl-8 w-1/2 mr-1 rounded-md placeholder-gray-400 focus:outline-none focus:border-gray-500 active:shadow-inner input_search" 
                    data-target="mytable" 
                    placeholder="Search"
                    name="search"
                    value="<?= isset($_GET['search'])? $_GET['search']: '' ?>"
                >
                <span class="absolute top-0 left-0 mt-2 ml-3 text-gray-600">
                    <i class="fas fa-search"></i>
                </span>
                <div class="border-2 py-1 px-1 rounded-md text-sm w-1/2 mr-1">
                    <select name="expense_category" class="w-full" id="" onchange="this.form.submit()">
                        <option value="-1">-- Select</option>
                        @foreach ($expense_categories as $category)
                            <option <?= isset($_GET['expense_category'])? $_GET['expense_category'] == $category->id? 'selected': '': '' ?> value="{{$category->id}}">{{$category->expense_category}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="year" value="{{ $dates['current'][1] }}">
                    <input type="hidden" name="month" value="{{ $dates['current'][0] }}">
                </div>
            </form>
            <a 
                href="{{ route('expense.create') }}" 
                class="flex-shrink-0 boder text-white text-center rounded-md py-2 px-3 w-10 bg-teal-500 focus:outline-none active:bg-teal-800 active:shadow-inner hover:bg-teal-700"
            >
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <div class="flex items-center -mr-2">
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative mytable">
                <thead>
                    <tr class="sticky top-0 border-b border-gray-300 bg-gray-200 items-center text-sm">
                        <th class="text-center">Date</th>
                        <th class="py-4 text-left">Details</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $day = 0;
                        $bg = "bg-gray-100";
                    ?>
                    @forelse ($expenses as $expense)
                        <?php
                            if( $day != \Carbon\Carbon::parse($expense->expense_date)->format('d') )
                                $bg = ($bg === "bg-gray-100")? "":"bg-gray-100";
                            
                            $day = \Carbon\Carbon::parse($expense->expense_date)->format('d')
                        ?>
                        <tr class="sticky top-0 {{ $bg }} border-b border-gray-300 items-center text-xs hover:bg-green-100" data-amount="{{$expense->amount}}">
                            <td class="w-12 text-center py-2">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M') }} </td>
                            <td>{{ $expense->description }}</td>
                            <td class="w-16 px-1 text-right text-teal-800 font-bold">@money( $expense->amount )</td>
                            <td class="w-12">
                                <a href="{{route('expense.edit', ['expense'=>$expense->id])}}" class="flex-shrink-0 boder text-gray-600 py-2 px-3 focus:outline-none active:text-gray-800 active:shadow-inner hover:text-gray-700">
                                    <i class="fas fa-edit"></i>
                                </a>                            
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="4">Nothing to show</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="absolute bottom-0 w-full bg-teal-800 text-white py-2 text-right pr-4">
            Total : <span class="total_amount">@money( $expenses->sum('amount') )</span>
        </div>
    </div>
@endsection