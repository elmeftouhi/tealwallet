@extends('layouts.app')

@section('content')

<div class="w-full">
    <div class="w-full mb-12 mt-4">
        <img class="h-16 mx-auto" src="{{ asset('storage/masrofi_logo.png') }}" alt="Masrofi Logo"/> 
        <div class="text-pink-900 font-bold text-2xl text-center">
            {{ config('app.name') }}
        </div>
    </div>
    <form class="max-w-xs mx-auto bg-white shadow-md rounded px-8 pt-12 pb-8 mb-4 m-1 relative" method="POST" action="{{ route('password.update') }}">
        @csrf     
        <input type="hidden" name="token" value="{{ $token }}">  
        <div class="mb-4">
            <label class="block text-teal-600 text-sm font-bold mb-2" for="email">
                E-Mail Address
            </label>
            <input 
                class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border border-red-500 @enderror" 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required autocomplete="email" autofocus
            >
            @error('email')
                <p class="text-red-500 text-xs italic">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-teal-600 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input class="shadow appearance-none @error('password') border border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="password" id="password" type="password" placeholder="******************">
            @error('password')
                <p class="text-red-500 text-xs italic">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-teal-600 text-sm font-bold mb-2" for="password-confirm">
                Confirm Password
            </label>
            <input class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" type="password">
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" type="submit">
                Reset My Password
            </button>
        </div>
    </form>
    <p class="text-center text-gray-500 text-xs">
        &copy;2020 {{config('app.name')}}. All rights reserved.
    </p>
</div>

@endsection