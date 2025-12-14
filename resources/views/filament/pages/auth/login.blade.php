@extends('filament::layouts.base')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">

    <div class="bg-white shadow-xl rounded-3xl p-10 w-full max-w-md border-4"
         style="border-image: linear-gradient(90deg, #16A085, #2ECC71) 1;">

        {{-- Logo --}}
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/Volfortuin.png') }}"
                 alt="Logo"
                 class="h-16 opacity-90">
        </div>

        {{-- Welcome text --}}
        <h2 class="text-center text-2xl font-semibold text-gray-700 mb-1">
            Semoga harimu lancar
        </h2>

        <p class="text-center text-sm text-gray-500 mb-8">
            Sign in to continue
        </p>

        {{-- Form --}}
        <form method="POST" action="{{ route('filament.admin.auth.login') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label class="text-gray-700 font-medium">Email</label>
                <input type="email" name="email" required autofocus
                    class="w-full mt-1 border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            {{-- Password --}}
            <div>
                <label class="text-gray-700 font-medium">Password</label>
                <input type="password" name="password" required
                    class="w-full mt-1 border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-2 rounded-lg font-semibold transition-all">
                Sign In
            </button>
        </form>
    </div>
</div>
@endsection
