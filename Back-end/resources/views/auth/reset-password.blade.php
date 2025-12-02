<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="{{ asset('assets/css/novo_usuario.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/button.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/input.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/label.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/select.css') }}">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="bg-pattern">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo">
            </div>

            <form action="{{ route('password') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if (session('success'))
                    <p style="color: #086; margin-bottom: 10px;">{{ session('success') }}</p>
                @endif

                @if (session('error'))
                    <p style="color: #f00; margin-bottom: 10px;">{{ session('error') }}</p>
                @endif

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" id="email" placeholder="Digite seu e-mail" 
                        value="{{ old('email') }}" required>
                    <span>{{ $errors->first('email') }}</span>
                </div>

                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="password" id="password" placeholder="********" required>
                    <span>{{ $errors->first('password') }}</span>
                </div>

                <div class="form-group">
                    <label>Confirme sua senha</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="********" required>
                    <span>{{ $errors->first('password_confirmation') }}</span>
                </div>

                <button type="submit" class="btn-cadastro">ATUALIZAR SENHA</button>

                <p class="login-link">
                    <a href="{{ route('login') }}">VOLTAR PARA LOGIN</a>
                </p>
            </form>
        </div>

        <div class="image-container">
            <img src="{{ asset('assets/img/cadastro_img.jpg') }}" alt="Cenário fantasia">
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

        senha.addEventListener('input', () => confirma.setCustomValidity(""));
        confirma.addEventListener('input', () => {
            if (senha.value === confirma.value) {
                confirma.setCustomValidity("");
            }
        });
    </script>
</body>
</html>
