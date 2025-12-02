<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/estiloLogin.css') }}">
    <link rel="stylesheet" href="{{ asset('/components/atoms/button.css') }}">
    <link rel="stylesheet" href="{{ asset('/components/atoms/input.css') }}">
    <link rel="stylesheet" href="{{ asset('/components/atoms/label.css') }}">
    <link rel="stylesheet" href="{{ asset('/components/molecules/form-group.css') }}">
</head>
<body>
<div class="login-container">
    <div class="login-image"></div>
    <div class="login-form-container">
        <img src="{{ asset('/assets/img/logoDaora.png') }}" alt="Logo Tá na Mesa" class="logo">

        @if (session('success'))
            <p style="color: #086; margin-bottom: 10px;">{{ session('success') }}</p>
        @endif

        @if (session('error'))
            <p style="color: red; margin-bottom: 10px;">{{ session('error') }}</p>
        @endif

        @if ($errors->any())
            <div style="color: red; margin-bottom: 10px;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form class="login-form" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Digite seu e-mail" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" placeholder="********" required>
            </div>

            <button type="submit" class="btn-login">Entrar</button>

            <p class="signup-link">
                    NÃO TEM CADASTRO? <a href="{{ route('register') }}">CADASTRE-SE</a> <br><br>
                    <a href="{{ route('password') }}">ESQUECI MINHA SENHA</a>
                </p>
        </form>
    </div>
</div>
</body>
</html>
