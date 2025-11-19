<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tela de Cadastro</title>
	<link rel="stylesheet" href="{{ asset('assets/css/novo_usuario.css') }}">
	<link rel="stylesheet" href="{{ asset('components/atoms/button.css') }}">
	<link rel="stylesheet" href="{{ asset('components/atoms/input.css') }}">
	<link rel="stylesheet" href="{{ asset('components/atoms/label.css') }}">

<body>
	<div class="container">
		<div class="form-container">
			<div class="bg-pattern"></div>
			@if (session('success'))
			<p style="color: #086">
				{{ session('success') }}
            </p>
				@endif

				@if (session('error'))
			<p style="color: #f00">
				{{ session('error') }}
            </p>
				@endif

			<form action="/register" method="POST" enctype="multipart/form-data">
				@csrf
				<img src="../assets/img/logo.png" alt="Logo" class="logo">

				<div class="form-group">
					<label for="name">Nome</label>
					<input type="text" name="name" id="name" placeholder="Como devemos te chamar?" 
                    value="{{old('name')}}" required>
                    <span>{{$errors->first('name')}}</span>
				</div>

				<div class="form-group">
					<label>E-mail</label>
					<input type="email" name="email" id="email" placeholder="Digite seu e-mail" 
                    value="{{old('email')}}" required>
                    <span>{{$errors->first('email')}}</span>
				</div>

				<div class="form-group">
					<label>Senha</label>
					<input type="password" name="password" id="password" placeholder="********" required>
                    <span>{{$errors->first('password')}}</span>
				</div>

				<div class="form-group">
					<label>Confirme sua senha</label>
					<input type="password" name="password_confirmation" id="password_confirmation" placeholder="********" required>
                    <span>{{$errors->first('password_confirmation')}}</span>
				</div>

				<div class="form-group">
					<label for="tipo">Você é lojista?</label>
					<select id="tipo" name="tipo" required>
						<option value="" disabled selected hidden>Selecione</option>
						<option value="sim">Sim</option>
						<option value="nao">Não</option>
					</select>
				</div>

                
				<!-- <div class="form-group">
					<label>Imagem de perfil</label>
					<input type="file" name="imagemPerfil" id="imagemPerfil" placeholder="insira a url"
						value="{{old('imagemPerfil')}}" required>
				</div> -->
 
				<button type="submit" class="btn-cadastro">CADASTRE-SE</button>
				<p class="login-link">JÁ TEM CADASTRO? <a href="login">VOLTE AQUI!</a></p>
			</form>
		</div>
		<div class="image-container">
			<img src="../assets/img/cadastro_img.jpg" alt="Cenário fantasia">
		</div>
	</div>

	<script>
    const form = document.querySelector('form');
    const senha = document.getElementById('password');
    const confirma = document.getElementById('password_confirmation');

    form.addEventListener('submit', function (e) {
        if (senha.value !== confirma.value) {
            e.preventDefault();
            confirma.setCustomValidity("As senhas não coincidem.");
            confirma.reportValidity();
        } else {
            confirma.setCustomValidity("");
        }
    });

    senha.addEventListener('input', () => {
        confirma.setCustomValidity("");
    });

    confirma.addEventListener('input', () => {
        if (senha.value === confirma.value) {
            confirma.setCustomValidity("");
        }
    });
</script>

</body>
</html> 