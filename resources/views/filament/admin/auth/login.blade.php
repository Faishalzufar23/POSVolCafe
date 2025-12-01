@extends('filament-panels::layouts.base')

@section('content')
<style>
    body {
        background: radial-gradient(circle at 20% 20%, #e0f2ff, #ffffff 60%);
        font-family: 'Inter', sans-serif;
    }

    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-card {
        background: white;
        width: 380px;
        padding: 35px;
        border-radius: 18px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        animation: fadeIn .7s ease;
    }

    h2 {
        text-align: center;
        margin-bottom: 5px;
        font-weight: 700;
        color: #0f172a;
    }

    p {
        text-align: center;
        color: #64748b;
        margin-bottom: 25px;
        font-size: 14px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-size: 14px;
        font-weight: 500;
    }

    input {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        outline: none;
        transition: .2s;
    }

    input:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, .25);
    }

    button {
        width: 100%;
        padding: 12px;
        border: none;
        margin-top: 18px;
        border-radius: 10px;
        background: #f59e0b;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    button:hover {
        background: #d97706;
        transform: translateY(-1px);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="login-wrapper">
    <div class="login-card">

        <h2>Selamat Datang</h2>
        <p>Silakan masuk untuk melanjutkan</p>

        <form method="POST" action="{{ route('filament.admin.auth.login') }}">
            @csrf

            <label>Email</label>
            <input type="email" name="email" required>

            <label style="margin-top: 15px;">Password</label>
            <input type="password" name="password" required>

            <div style="margin-top: 10px; display: flex; align-items: center; gap:6px;">
                <input type="checkbox" name="remember">
                <span style="font-size: 14px;">Remember me</span>
            </div>

            <button type="submit">Login</button>
        </form>

    </div>
</div>
@endsection
