<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tela de Login</title>
	<link rel="stylesheet" href="{{ asset('/assets/css/estiloLogin.css') }}">
	<link rel="stylesheet" href="{{ asset('/components/atoms/button.css') }}">
	<link rel="stylesheet" href="{{ asset('/components/atoms/input.css') }}">
	<link rel="stylesheet" href="{{ asset('/components/atoms/label.css') }}">
	<link rel="stylesheet" href="{{ asset('/components/molecules/form-group.css') }}">

<body>
<div class="login-container">
        <div class="login-image"></div>
        <div class="login-form-container">
            <img src="{{ asset('/assets/img/logoDaora.png') }}" alt="Logo Tá na Mesa" class="logo"> 
            
        <form class="login-form" action="/login" method="POST">
            @csrf 
            <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
        </div>

        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" id="password" name="password" placeholder="********" required>
        </div>                

        <button type="submit" class="btn-login">Entrar<a href="dashboard"></button>

        <p class="signup-link">
            NÃO TEM CADASTRO? <a href="register">CADASTRE-SE</a>
        </p>
    </form>
        </div>
    </div>

</body>
</html>