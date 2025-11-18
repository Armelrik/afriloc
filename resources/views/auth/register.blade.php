@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900">Register</h2>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    {{ __('messages.contact.name') }}
                </label>
                <input 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}"
                    required 
                    autofocus
                >
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    {{ __('messages.contact.email') }}
                </label>
                <input 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="password" 
                    type="password" 
                    name="password"
                    required
                >
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                    Confirm Password
                </label>
                <input 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation"
                    required
                >
            </div>

            <div class="flex items-center justify-between">
                <button 
                    class="bg-primary hover:bg-primary-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                    type="submit"
                >
                    Register
                </button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <a href="/login" class="text-sm text-primary hover:text-primary-600">
                Already have an account? Login
            </a>
        </div>
    </div>
</div>
@endsection

