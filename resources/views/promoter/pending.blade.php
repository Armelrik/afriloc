@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
        <svg class="mx-auto h-16 w-16 text-yellow-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        
        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Application Pending') }}</h2>
        
        <p class="text-gray-600 mb-6">
            {{ __('Thank you for your interest in becoming a promoter! Your application is currently under review.') }}
        </p>
        
        <p class="text-gray-600 mb-8">
            {{ __('You will receive an email notification once your account is approved. This usually takes 1-2 business days.') }}
        </p>
        
        <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-600">
            {{ __('Return to Home') }}
        </a>
    </div>
</div>
@endsection


