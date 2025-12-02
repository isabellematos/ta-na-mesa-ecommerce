<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras - Ta Na Mesa</title>

    <link rel="stylesheet" href="{{ asset('assets/css/estiloCarrinho.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('components/organisms/header.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/button.css') }}">

    <link rel="stylesheet" href="{{ asset('components/organisms/cart-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/cart-item.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/order-summary.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-content">
                <ul class="nav-links">
                    <li><a href="{{ route('initial') }}" class="active-link">Loja</a></li>
                </ul>
                <div class="user-actions">
                    @auth
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
                    @else
                        <a href="{{ route('login') }}">
                            <img src="{{ asset('assets/img/user-icon.png') }}" 
                                 alt="Perfil do usuário"
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="main-container">
            <div class="caminho">
                <h3><a href="{{ route('initial') }}" style="color: inherit; text-decoration: none;">Home</a> > Carrinho de Compras</h3>
            </div>

            @if(session('success'))
                <div style="background-color: #28a745; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background-color: #dc3545; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('error') }}
                </div>
            @endif

            @if($cartItems->isEmpty())
                <div style="text-align: center; padding: 50px;">
                    <h2>Seu carrinho está vazio</h2>
                    <p style="color: #ccc; margin: 20px 0;">Adicione produtos ao seu carrinho para continuar comprando.</p>
                    <a href="{{ route('initial') }}">
                        <button class="buy-button">Ir para a loja</button>
                    </a>
                </div>
            @else
                <div class="cart-container">
                    <div class="cart-items-column">
                        @foreach($cartItems as $item)
                            <div class="cart-item" data-item-id="{{ $item->id }}">
                                <input type="checkbox" checked>
                                <div class="cart-item-image-container">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cart-item-delete">
                                            <img src="{{ asset('assets/img/iconeLixo.png') }}" alt="Excluir item">
                                        </button>
                                    </form>
                                    
                                    {{-- AQUI ESTÁ A CORREÇÃO DA IMAGEM --}}
                                    <img src="{{ Str::startsWith($item->product->image1, ['http', 'https']) ? $item->product->image1 : asset('storage/' . $item->product->image1) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="cart-item-image">
                                </div>
                                <div class="cart-item-details">
                                    <h4>{{ $item->product->name }}</h4>
                                    <p>{{ Str::limit($item->product->description, 50) }}</p>
                                    <p>Ref: {{ $item->product->id }}</p>
                                    <p class="cart-item-price">R$ {{ number_format($item->product->price, 2, ',', '.') }}</p>
                                </div>
                                <div class="quantity-controls">
                                    <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, -1, {{ $item->product->units }})">-</button>
                                    <span class="quantity-value" id="quantity-{{ $item->id }}">{{ $item->quantity }}</span>
                                    <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, 1, {{ $item->product->units }})">+</button>
                                </div>
                            </div>
                        @endforeach

                        <a href="{{ route('initial') }}">
                            <button class="buy-button" style="margin-top: 20px;">Escolher mais produtos</button>
                        </a>
                    </div>

                    <div class="summary-column">
                        <div class="order-summary">
                            <div class="frete-info">
                                <h4>Frete</h4>
                                <p>Informe o CEP e veja se tem FRETE GRÁTIS na sua região!</p>
                                
                                <div style="margin: 15px 0;">
                                    <input type="text" 
                                           id="cep-input" 
                                           placeholder="00000-000" 
                                           maxlength="9"
                                           value="{{ Auth::check() && Auth::user()->cep ? substr(Auth::user()->cep, 0, 5) . '-' . substr(Auth::user()->cep, 5) : '' }}"
                                           >
                                    <button onclick="buscarCEP()" 
                                            class="buy-button"
                                            style="width: 100%; padding: 10px;">
                                            Buscar CEP
                                    </button>
                                </div>

                                <div id="address-info" style="display: {{ Auth::check() && Auth::user()->cep ? 'block' : 'none' }};">
                                    <p><strong id="cidade-estado">{{ Auth::check() && Auth::user()->cidade ? Auth::user()->cidade . ' - ' . Auth::user()->estado : '' }}</strong></p>
                                    <p id="logradouro-bairro">{{ Auth::check() && Auth::user()->logradouro ? Auth::user()->logradouro . (Auth::user()->numero ? ', ' . Auth::user()->numero : '') : '' }}</p>
                                    <p id="bairro-text">{{ Auth::check() && Auth::user()->bairro ? Auth::user()->bairro : '' }}</p>
                                </div>

                                @if($subtotal >= 250)
                                    <p style="color: #28a745; font-weight: bold;">Parabéns! Você ganhou FRETE GRÁTIS!</p>
                                @elseif($subtotal < 100)
                                    <p><a href="#">Compre mais R${{ number_format(100 - $subtotal, 2, ',', '.') }} e ganhe FRETE GRÁTIS!</a></p>
                                @else
                                    <p><a href="#">Compre mais R${{ number_format(250 - $subtotal, 2, ',', '.') }} e ganhe FRETE GRÁTIS!</a></p>
                                @endif
                            </div>
                            <hr style="border-color: #444; margin: 20px 0;">
                            <h4>Resumo do pedido</h4>
                            <div class="summary-line">
                                <span>Subtotal</span>
                                <span id="subtotal-value">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                            </div>
                            <div class="summary-line">
                                <span>Frete</span>
                                <span id="frete-value">R$ {{ $subtotal >= 250 ? '0,00' : '10,00' }}</span>
                            </div>
                            <div class="summary-total">
                                <span>Total do pedido</span>
                                <span id="total-value">R$ {{ number_format($subtotal >= 250 ? $subtotal : $subtotal + 10, 2, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('checkout.personalInfo') }}">
                                <button class="buy-button" style="width: 100%; margin-top: 20px;">Finalizar pedido</button>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; direitos reservados 2025</p>
            <p>Este site foi desenvolvido por Isabelle Matos, Laís Lívia, Luana Miyashiro, Maria Vivielle, Malu
                Araujo, Yasmin Carolina</p>
        </div>
    </footer>

    <script>
        function updateQuantity(itemId, change, maxUnits) {
            const quantityElement = document.getElementById(`quantity-${itemId}`);
            let currentQuantity = parseInt(quantityElement.textContent);
            let newQuantity = currentQuantity + change;

            if (newQuantity < 1 || newQuantity > maxUnits) {
                return;
            }

            fetch(`/cart/${itemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    quantityElement.textContent = newQuantity;
                    location.reload(); // Recarrega para atualizar os totais
                }
            })
            .catch(error => console.error('Erro:', error));
        }

        // Formatar CEP enquanto digita
        document.getElementById('cep-input').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.substring(0, 5) + '-' + value.substring(5, 8);
            }
            e.target.value = value;
        });

        function buscarCEP() {
            const cepInput = document.getElementById('cep-input');
            const cep = cepInput.value.replace(/\D/g, '');

            if (cep.length !== 8) {
                alert('Por favor, digite um CEP válido com 8 dígitos.');
                return;
            }

            // Buscar CEP na API ViaCEP
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        alert('CEP não encontrado!');
                        return;
                    }

                    // Exibir informações do endereço
                    document.getElementById('cidade-estado').textContent = `${data.localidade} - ${data.uf}`;
                    document.getElementById('logradouro-bairro').textContent = data.logradouro;
                    document.getElementById('bairro-text').textContent = data.bairro;
                    document.getElementById('address-info').style.display = 'block';

                    // Salvar no banco de dados se o usuário estiver logado
                    @auth
                    fetch('/cart/save-address', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            cep: cep,
                            logradouro: data.logradouro,
                            bairro: data.bairro,
                            cidade: data.localidade,
                            estado: data.uf,
                            complemento: data.complemento || '',
                            numero: ''
                        })
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            console.log('Endereço salvo com sucesso!');
                        }
                    })
                    .catch(error => console.error('Erro ao salvar endereço:', error));
                    @endauth
                })
                .catch(error => {
                    console.error('Erro ao buscar CEP:', error);
                    alert('Erro ao buscar CEP. Tente novamente.');
                });
        }

        // Permitir buscar CEP ao pressionar Enter
        document.getElementById('cep-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                buscarCEP();
            }
        });
    </script>
</body>
</html>
