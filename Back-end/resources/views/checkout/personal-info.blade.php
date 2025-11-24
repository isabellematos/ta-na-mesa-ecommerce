<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações Pessoais - Checkout</title>

    <link rel="stylesheet" href="{{ asset('assets/css/estiloInformacao.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('components/organisms/header.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/button.css') }}">

    <link rel="stylesheet" href="{{ asset('components/organisms/checkout-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/personal-info.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-content">
                <div class="logo">
                    <img src="{{ asset('assets/img/logoDaora.png') }}" alt="Logo Ta Na Mesa">
                </div>
                <ul class="nav-links">
                    <li><a href="#">Suas mesas</a></li>
                    <li><a href="#">Mesas</a></li>
                    <li><a href="#">Cadastro de mesas</a></li>
                    <li><a href="{{ route('initial') }}" class="active-link">Loja</a></li>
                </ul>
                <div class="user-actions">
                    <a href="{{ route('profile.edit') }}">
                        @if(Auth::user()->imagemPerfil)
                            <img src="{{ asset('storage/' . Auth::user()->imagemPerfil) }}?v={{ time() }}" 
                                 alt="Perfil do usuário" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"
                                 onerror="this.onerror=null; this.src='{{ asset('assets/img/user-icon.png') }}';">
                        @else
                            <img src="{{ asset('assets/img/user-icon.png') }}" 
                                 alt="Perfil do usuário"
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        @endif
                    </a>
                    <a href="{{ route('cart.index') }}">
                        <img src="{{ asset('assets/img/Shopping cart.png') }}" alt="Carrinho de compras">
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="main-container">
            <div class="caminho">
                <h3>
                    <a href="{{ route('initial') }}" style="color: inherit; text-decoration: none;">Home</a> > 
                    <a href="{{ route('cart.index') }}" style="color: inherit; text-decoration: none;">Carrinho de Compras</a> > 
                    Informações pessoais
                </h3>
            </div>

            @if(session('success'))
                <div style="background-color: #28a745; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background-color: #dc3545; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('checkout.savePersonalInfo') }}" method="POST">
                @csrf
                <div class="checkout-container">
                    <div class="personal-info-column">
                        <h4>Informações pessoais</h4>

                        <div class="info-field">
                            <img src="{{ asset('assets/img/iconeEmail.png') }}" alt="Ícone de E-mail">
                            <div class="info-field-text">
                                <h5>E-MAIL</h5>
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="info-field">
                            <img src="{{ asset('assets/img/iconeMago.png') }}" alt="Ícone de Nome">
                            <div class="info-field-text">
                                <h5>NOME COMPLETO</h5>
                                <p>{{ $user->name }}</p>
                            </div>
                        </div>

                        <div class="info-field">
                            <img src="{{ asset('assets/img/iconeCPF.png') }}" alt="Ícone de CPF">
                            <div class="info-field-text">
                                <h5>CPF</h5>
                                <input type="text" 
                                       name="cpf" 
                                       id="cpf-input"
                                       value="{{ old('cpf', $user->cpf) }}"
                                       placeholder="000.000.000-00"
                                       maxlength="14"
                                       required
                                       style="background: transparent; border: none; color: white; font-size: 1rem; width: 100%; outline: none;">
                            </div>
                        </div>

                        <div class="info-field">
                            <img src="{{ asset('assets/img/iconeCalendario.png') }}" alt="Ícone de Data de Nascimento">
                            <div class="info-field-text">
                                <h5>DATA DE NASCIMENTO</h5>
                                <input type="date" 
                                       name="data_nascimento"
                                       value="{{ old('data_nascimento', $user->data_nascimento) }}"
                                       required
                                       style="background: transparent; border: none; color: white; font-size: 1rem; width: 100%; outline: none;">
                            </div>
                        </div>

                        <div class="info-field">
                            <img src="{{ asset('assets/img/iconeTelefone.png') }}" alt="Ícone de Telefone">
                            <div class="info-field-text">
                                <h5>TELEFONE</h5>
                                <input type="text" 
                                       name="telefone"
                                       id="telefone-input"
                                       value="{{ old('telefone', $user->telefone) }}"
                                       placeholder="(00) 00000-0000"
                                       maxlength="15"
                                       required
                                       style="background: transparent; border: none; color: white; font-size: 1rem; width: 100%; outline: none;">
                            </div>
                        </div>

                        <label class="checkbox-container">
                            <input type="checkbox" name="receber_emails" id="receber-emails" {{ old('receber_emails', $user->receber_emails) ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            Desejo receber e-mails sobre ofertas
                        </label>
                    </div>

                    <div class="address-info-column">
                        <h4>Endereço de entrega</h4>

                        <div class="info-field">
                            <img src="{{ asset('assets/img/iconeCEP.png') }}" alt="Ícone de CEP">
                            <div class="info-field-text">
                                <h5>CEP</h5>
                                <p>{{ $user->cep ? substr($user->cep, 0, 5) . '-' . substr($user->cep, 5) : 'Não informado' }}</p>
                            </div>
                        </div>

                        <div class="info-field">
                            <img src="{{ asset('assets/img/iconeEndereco.png') }}" alt="Ícone de Endereço">
                            <div class="info-field-text">
                                <h5>ENDEREÇO</h5>
                                <p>{{ $user->logradouro ? $user->logradouro . ', ' . $user->cidade . ' - ' . $user->estado : 'Não informado' }}</p>
                            </div>
                        </div>

                        <div class="info-field">
                            <img src="{{ asset('assets/img/iconeNumero.png') }}" alt="Ícone de Número">
                            <div class="info-field-text">
                                <h5>NÚMERO</h5>
                                <input type="text" 
                                       name="numero"
                                       value="{{ old('numero', $user->numero) }}"
                                       placeholder="Nº, AP, BL"
                                       required
                                       style="background: transparent; border: none; color: white; font-size: 1rem; width: 100%; outline: none;">
                            </div>
                        </div>

                        <div class="info-field">
                            <img src="{{ asset('assets/img/iconeComplemento.png') }}" alt="Ícone de Complemento">
                            <div class="info-field-text">
                                <h5>COMPLEMENTO</h5>
                                <input type="text" 
                                       name="complemento"
                                       value="{{ old('complemento', $user->complemento) }}"
                                       placeholder="(Opcional)"
                                       style="background: transparent; border: none; color: white; font-size: 1rem; width: 100%; outline: none;">
                            </div>
                        </div>

                        <button type="submit" class="buy-button" style="width: 100%; margin-top: 20px;">Continuar pagamento</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; direitos reservados 2025</p>
            <p>Este site foi desenvolvido por Isabelle Matos, Laís Lívia, Luana Miyashiro, Maria Vivielle, Malu
                Araujo, Yasmin Carolina</p>
        </div>
    </footer>

    <style>
        /* Estilo para o checkbox marcado */
        .checkbox-container input[type="checkbox"]:checked + .checkmark {
            background-color: var(--primary-color);
            position: relative;
        }

        /* Adiciona o "check" quando marcado */
        .checkbox-container input[type="checkbox"]:checked + .checkmark::after {
            content: "✓";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 14px;
            font-weight: bold;
        }

        /* Quando não marcado, fica com borda */
        .checkbox-container .checkmark {
            border: 2px solid var(--primary-color);
            background-color: transparent;
        }
    </style>

    <script>
        // Formatar CPF
        document.getElementById('cpf-input').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 3) value = value.substring(0, 3) + '.' + value.substring(3);
            if (value.length > 7) value = value.substring(0, 7) + '.' + value.substring(7);
            if (value.length > 11) value = value.substring(0, 11) + '-' + value.substring(11, 13);
            e.target.value = value;
        });

        // Formatar Telefone
        document.getElementById('telefone-input').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) value = '(' + value;
            if (value.length > 3) value = value.substring(0, 3) + ') ' + value.substring(3);
            if (value.length > 10) value = value.substring(0, 10) + '-' + value.substring(10, 14);
            e.target.value = value;
        });
    </script>
</body>

</html>
