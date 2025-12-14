@extends('filament::layouts.base')

@section('body')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">

    <div class="bg-white rounded-3xl shadow-xl p-10 w-full max-w-md relative">

        {{-- GREEN TOP BORDER --}}
        <div class="absolute top-0 left-0 right-0 h-3 bg-gradient-to-r from-green-400 to-green-600 rounded-t-3xl"></div>

        {{-- LOGO --}}
        <div class="flex justify-center mt-6 mb-4">
            <img src="{{ asset('images/Volfortuin.png') }}" class="w-24" alt="Logo">
        </div>

        <h2 class="text-center text-2xl font-semibold text-gray-800 mb-1">
            Semoga harimu lancar
        </h2>

        <p class="text-center text-gray-500 mb-6 text-sm">
            Sign in to continue
        </p>

        {{-- FILAMENT LOGIN FORM --}}
        <x-filament-panels::form
            action="{{ route('filament.admin.auth.login') }}"
            method="POST"
            class="space-y-5"
        >
            @csrf

            {{ $this->form }}

            <button
                type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg font-semibold transition"
            >
                Sign In
            </button>

        </x-filament-panels::form>

    </div>

</div>
@endsection
