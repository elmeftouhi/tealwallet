@extends('layouts.app')
@section('title')
<div class="flex items-center">
    <a href="{{ url()->previous() }}" class="rounded-full py-2 px-3 bg-gray-600 mr-2 text-gray-100">
        <i class="fas fa-arrow-left"></i>
    </a>
    <span>
       Expense Category
    </span>
</div>
@endsection
@section('content')
    <div class="rounded bg-white shadow text-gray-700 m-1 overflow-hidden">
        <div class="flex justify-between items-center py-4 px-3">
            <div class="relative">
                <input type="text" class="border py-1 pl-8 rounded-md placeholder-gray-400 focus:outline-none focus:border-gray-500 active:shadow-inner" placeholder="Search">
                <span class="absolute top-0 left-0 mt-2 ml-3 text-gray-600">
                    <i class="fas fa-search"></i>
                </span>
            </div>
            <a href="{{ route('category.create') }}" class="flex-shrink-0 boder text-white rounded-md py-2 px-3 focus:outline-none bg-teal-500 active:bg-teal-800 active:shadow-inner hover:bg-teal-700">
                <i class="fas fa-plus"></i>
            </a>
        </div>

        <div class="flex items-center -mr-2">
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                <thead>
                    <tr class="sticky top-0 border-b border-gray-300 bg-gray-100 items-center text-sm">
                        <th>#</th>
                        <th>Icon</th>
                        <th class="py-4 text-left">Category</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr class="sticky top-0 border-b border-gray-300 items-center text-sm hover:bg-green-100 cursor-move" data-id="{{$category->id}}">
                            <td class="text-center"> <span class="text-sm font-bold">{{ $category->level }}</span> </td>
                            <td class="w-10 text-center text-lg py-4">  {!! $category->icon !!} </td>
                            <td class="truncate text-xs md:text-base">{{ $category->expense_category }}</td>
                            <td class="px-1">
                                @if ($category->status === 1)
                                    <div class="bg-green-400 border-green-900 text-white text-xs rounded py-1 text-center m-auto shadow-inner"></div>
                                @else
                                    <div class="bg-gray-500 border-gray-900 text-white text-xs rounded py-1 text-center m-auto"></div>
                                @endif
                            </td>
                            <td class="w-12">
                            <a href="{{route('category.edit', ['category'=>$category->id])}}" class="flex-shrink-0 boder text-gray-600 py-2 px-3 focus:outline-none active:text-gray-800 active:shadow-inner hover:text-gray-700">
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

    </div>
@endsection