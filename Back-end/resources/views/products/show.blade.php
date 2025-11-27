<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Ta Na Mesa</title>
    <link rel="stylesheet" href="{{ asset('assets/css/estiloProduto.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('components/organisms/header.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/button.css') }}">
</head>

<body>

    <header class="header">
        <nav class="navbar">
            <div class="navbar-content">
                <div class="logo">
                    <img src="{{ asset('assets/img/logoDaora.png') }}" alt="Logo Ta Na Mesa">
                </div>
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
                    <a href="{{ route('cart.index') }}"><img src="{{ asset('assets/img/Shopping cart.png') }}" alt="Carrinho de compras"></a>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="main-container">
            <div class="caminho">
                <h3><a href="{{ route('initial') }}" style="color: inherit; text-decoration: none;">Home</a> > Produto</h3>
            </div>

            <section id="store-section" class="store">
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->image1) }}" alt="{{ $product->name }}">
                    <div class="product-info">
                        <span class="product-tag">LANÇAMENTO</span>
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <p class="product-description">
                            {{ $product->description }}
                        </p>
                        <span class="product-price">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                        
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <div class="product-info-options">
                                <div class="quantity-controls">
                                    <button type="button" class="quantity-btn" onclick="decreaseQuantity()">-</button>
                                    <span class="quantity-value" id="quantity">1</span>
                                    <input type="hidden" name="quantity" id="quantity-input" value="1">
                                    <button type="button" class="quantity-btn" onclick="increaseQuantity()">+</button>
                                </div>
                                <button type="submit" class="buy-button">Adicionar ao Carrinho</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
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
        let quantity = 1;
        const maxQuantity = {{ $product->units }};

        function increaseQuantity() {
            if (quantity < maxQuantity) {
                quantity++;
                document.getElementById('quantity').textContent = quantity;
                document.getElementById('quantity-input').value = quantity;
            }
        }

        function decreaseQuantity() {
            if (quantity > 1) {
                quantity--;
                document.getElementById('quantity').textContent = quantity;
                document.getElementById('quantity-input').value = quantity;
            }
        }
    </script>

</body>

</html>
