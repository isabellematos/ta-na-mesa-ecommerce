<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu perfil - Aventureiro</title>
    <link rel="stylesheet" href="{{ asset('assets/css/estiloMain.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/button.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/input.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/label.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/form-group.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/product-card.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/header.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/product-grid.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-content">
                <div class="logo">
                    <a href="{{ route('initial') }}">
                        <img src="{{ asset('assets/img/logoDaora.png') }}" alt="Logo Ta Na Mesa">
                    </a>
                </div>
                <div class="user-actions">
                    <a href="{{ route('cart.index') }}">
                        <img src="{{ asset('assets/img/Shopping cart.png') }}" alt="Carrinho de compras" style="width: 30px; height: 30px;">
                    </a>
                    <a href="#">
                        @if(Auth::user()->imagemPerfil)
                            <img src="{{ asset('storage/' . Auth::user()->imagemPerfil) }}" alt="Perfil" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
                        @else
                            <img src="{{ asset('assets/img/user-icon.png') }}" alt="Perfil" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        @endif
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="background:none; border:none; color:white; cursor:pointer; font-family:inherit; margin-left:15px; font-size: 1rem;">Sair</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <section class="hero-banner">
            <div class="banner-image">
                <img src="{{ asset('assets/img/Banner perfil.png') }}" alt="Banner RPG">
                <h1 class="banner-title-seller" style="font-size: 3rem;">Perfil do Aventureiro</h1>
            </div>
            <div class="scroll-down-container">
                <a href="#store-section" class="scroll-down-button">
                    <img src="{{ asset('assets/img/botao.png') }}" alt="Scroll">
                </a>
            </div>

            <section id="store-section" class="store">
                <section class="seller-infos">
                    <h2>Suas informações</h2>
                    <div class="seller-info-content">
                        <div class="seller-photo">
                            @if(Auth::user()->imagemPerfil)
                                <img src="{{ asset('storage/' . Auth::user()->imagemPerfil) }}" style="width: 180px; height: 180px; object-fit: cover; border-radius: 50%; border: 4px solid #CD004A;">
                            @else
                                <img src="{{ asset('assets/img/user-icon.png') }}" style="width: 180px; height: 180px; object-fit: cover; border-radius: 50%; border: 4px solid #CD004A;">
                            @endif
                        </div>
                        <div class="seller-fields">
                            <div class="field-row">
                                <label>Nome:</label>
                                <input type="text" value="{{ Auth::user()->name }}" readonly style="color: #ccc; cursor: default;">
                            </div>
                            <div class="field-row">
                                <label>E-mail:</label>
                                <input type="email" value="{{ Auth::user()->email }}" readonly style="color: #ccc; cursor: default;">
                            </div>
                            <div style="margin-top: 20px;">
                                <a href="{{ route('profile.edit') }}" class="btn-primary" style="text-decoration: none; display: inline-block; text-align: center;">Editar Perfil</a>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="user-orders" class="seller-ads" style="margin-top: 50px;">
                    <h2 class="sellers-title">Seus Pedidos (Histórico)</h2>

                    <form method="GET" action="{{ route('dashboard') }}" class="filter-bar-modern" style="margin-bottom: 30px; background-color: #2a2a2a; padding: 20px; border-radius: 10px;">
                        <div style="display: flex; gap: 20px; align-items: end; flex-wrap: wrap;">
                            <div class="filter-group-modern">
                                <label style="color: white; display: block; margin-bottom: 5px;">Data da Compra:</label>
                                <input type="date" name="date" value="{{ request('date') }}" style="padding: 10px; border-radius: 5px; border: 1px solid #555; background: #fff; color: #000;">
                            </div>
                            <div class="filter-group-modern">
                                <label style="color: white; display: block; margin-bottom: 5px;">Contém itens de:</label>
                                <div class="tags-container" style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    @php $categorias = ['Vestimentas', 'Acessórios', 'Livros', 'Dados', 'Brinquedos', 'Outro']; $selecionadas = request('categories', []); @endphp
                                    @foreach($categorias as $cat)
                                        <label class="tag-item">
                                            <input type="checkbox" name="categories[]" value="{{ $cat }}" class="hidden-checkbox" {{ in_array($cat, $selecionadas) ? 'checked' : '' }}>
                                            <span class="tag-design">{{ $cat }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="filter-actions" style="margin-bottom: 5px;">
                                <button type="submit" style="background: #CD004A; color: white; border: none; padding: 10px 25px; border-radius: 5px; cursor: pointer; font-weight: bold;">Filtrar</button>
                                <a href="{{ route('dashboard') }}" style="color: #ccc; text-decoration: none; margin-left: 15px; font-size: 0.9rem;">Limpar</a>
                            </div>
                        </div>
                    </form>

                    <div class="orders-list">
                        @if(isset($orders))
                            @forelse($orders as $order)
                                <div class="order-card" style="background: #2a2a2a; padding: 20px; margin-bottom: 20px; border-radius: 10px; border-left: 5px solid #CD004A;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #444; padding-bottom: 10px;">
                                        <h3 style="color: white; margin: 0;">Pedido #{{ $order->id }}</h3>
                                        <span style="color: #ccc;">{{ $order->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="order-items">
                                        <ul style="list-style: none; padding: 0;">
                                            @foreach($order->items as $item)
                                                <li style="color: white; margin-bottom: 8px; display: flex; justify-content: space-between;">
                                                    <span>{{ $item->product->name }} <span style="font-size: 0.8rem; color: #CD004A; border: 1px solid #CD004A; padding: 2px 6px; border-radius: 10px;">{{ $item->product->Category->name ?? 'Item' }}</span></span>
                                                    <span>R$ {{ number_format($item->price, 2, ',', '.') }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #444; text-align: right;">
                                        <span style="color: #CD004A; font-weight: bold; font-size: 1.2rem;">Total: R$ {{ number_format($order->total, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 40px; background: #2a2a2a; border-radius: 10px;"><p style="color: #ccc; font-size: 1.2rem;">Nenhum pedido encontrado. 🧙‍♂️</p></div>
                            @endforelse
                        @endif
                    </div>
                </section>
            </section>
        </section>
    </main>
    <div class="footer-spacer"></div>
    <footer class="footer"><div class="footer-content"><p>&copy; 2025 Ta Na Mesa</p></div></footer>

    <style>
        .hidden-checkbox { display: none; }
        .tag-design { display: inline-block; padding: 8px 20px; border: 1px solid #555; border-radius: 20px; color: #ccc; cursor: pointer; transition: all 0.3s ease; user-select: none; }
        .tag-item:hover .tag-design { border-color: #CD004A; color: white; }
        .hidden-checkbox:checked + .tag-design { background-color: #CD004A; color: white; border-color: #CD004A; font-weight: bold; }
    </style>
</body>
</html>