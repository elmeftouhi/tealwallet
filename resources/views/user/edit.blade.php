@extends('layouts.app')

@section('title') 
    <div class="flex items-center justify-between py-1">
        <div class="">
            <a href="{{ route('home') }}" class="rounded-full py-2 px-3 bg-gray-600 mr-2 text-gray-100">
                <i class="fas fa-arrow-left"></i>
            </a>
            <span>
                Edit Profile  <small>[Edit]</small> 
            </span>            
        </div>
        <div class="mr-1 bg-teal-600 rounded-full px-2 text-xs text-white font-normal">Active</div>
    </div>
@endsection
@section('content')
    <form action="{{ route('user.avatar.upload') }}" method="POST" id="avatar_form" enctype="multipart/form-data">
        @csrf 
        <div class="max-w-xs mx-auto m-1 shadow bg-white mb-4">
            <div class="bg-gray-200 relative py-6">
                <div class="w-xs mx-auto overflow-hidden">
                    @if( Storage::disk('public')->exists(auth()->user()->avatar) )
                        <img 
                            src="{{ asset('storage/'.auth()->user()->avatar) }}" 
                            alt="Masrofi User Photo" 
                            class="rounded-full object-center object-cover w-20 m-auto cursor-pointer hover:shadow hover:opacity-75 border-dashed show-upload"
                            data-target="avatar"
                        >
                    @else
                        <img 
                            src="https://icons.iconarchive.com/icons/papirus-team/papirus-apps/256/system-users-icon.png" 
                            alt="Masrofi User Photo" 
                            class="rounded-full object-center object-cover w-20 m-auto cursor-pointer hover:shadow hover:opacity-75 border-dashed show-upload"
                            data-target="avatar"
                        >
                    @endif
                </div>
                <input type="file" name="avatar" id="avatar" class="hidden" data-target="avatar_form">
                @error('avatar') <p class="text-red-500 text-xs italic text-center">{{ $message }}</p> @enderror
            </div>
        </div>
    </form>
    <form action="{{ route('user.update') }}" method="POST">
        @csrf 
        @method('PATCH')

        <div class="max-w-xs mx-auto bg-white shadow-md rounded px-8 pt-4 pb-8 mb-4 m-1 relative">
            <div class="mb-4">
                <label class="block text-teal-600 text-sm font-bold mb-2" for="name"> Name </label>
                <input placeholder="your name" class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border border-red-500 @enderror" id="name" type="text"  name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="mb-12">
                <label class="block text-teal-600 text-sm font-bold mb-2" for="email"> Email </label>
                <input placeholder="exemple@email.com" class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border border-red-500 @enderror" id="email" type="email"  name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>
                @error('email') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between">
                <button class="w-full bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update Profile
                </button>
            </div>
        </div>
    </form>
@endsection