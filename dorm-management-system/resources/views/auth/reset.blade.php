@extends('layouts.auth')

@section('title', 'Новый пароль')

@section('content')
    <style>
        html, body { margin: 0; padding: 0; height: 100%; font-family: Arial, sans-serif; }
        body {
            background: url("{{ asset('images/login-bg.jpg') }}") no-repeat center center fixed;
            background-size: cover;
        }
        .login-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 2rem;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        .form-control {
            border-radius: 30px;
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            width: 100%;
        }
        .btn-primary {
            background-color: #7e57c2;
            border: none;
            border-radius: 30px;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            color: #fff;
            cursor: pointer;
            margin-top: 1rem;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #673ab7;
        }
        .alert.alert-danger {
            margin-bottom: 1rem;
            background-color: #f8d7da;
            border: 1px solid #f5c2c7;
            padding: 0.75rem 1rem;
            border-radius: 4px;
            color: #842029;
        }
    </style>

    <div class="login-container">
        <div class="login-card">
            <h2>Установить новый пароль</h2>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="email" name="email" class="form-control" placeholder="Ваш email" value="{{ old('email') }}" required>
                <input type="password" name="password" class="form-control" placeholder="Новый пароль" required>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Подтвердите пароль" required>

                <button type="submit" class="btn btn-primary">Сбросить пароль</button>
            </form>
        </div>
    </div>
@endsection
