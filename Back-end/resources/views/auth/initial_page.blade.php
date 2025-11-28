<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sua Jornada - Loja</title>
    
    <link rel="stylesheet" href="{{ asset('assets/css/estiloMain.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/button.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/input.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/label.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/form-group.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/product-card.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/header.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/product-grid.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atom/select.css') }}">

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
                    
                    @if(Auth::check() && Auth::user()->tipo === 'sim')
                        <a href="#" onclick="openLojistaModal(); return false;">
                            <img src="{{ asset('assets/img/Shopping cart.png') }}" alt="Carrinho de compras" style="width: 30px; height: 30px;">
                        </a>
                    @else
                        <a href="{{ route('cart.index') }}" class="cart-icon">
                            <img src="{{ asset('assets/img/Shopping cart.png') }}" style="width:30px;">

                            @if(isset($cartCount) && $cartCount > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    @endif

                    @auth
                        <a href="{{ route('profile.edit') }}">
                            @if(Auth::user()->imagemPerfil)
                                <img src="{{ asset('storage/' . Auth::user()->imagemPerfil) }}?v={{ time() }}" 
                                     alt="Perfil do usuário" 
                                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid white;"
                                     onerror="this.onerror=null; this.src='{{ asset('assets/img/user-icon.png') }}';">
                            @else
                                <img src="{{ asset('assets/img/user-icon.png') }}" 
                                     alt="Perfil do usuário" 
                                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
                            @endif
                        </a>
                        
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           style="color: white; text-decoration: none; margin-left: 15px;">
                            Sair
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

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
        <section class="hero-banner">
            <div class="banner-image">
                <img src="{{ asset('assets/img/Banner inicial.png') }}" alt="Banner com personagens de RPG">
                <h1 class="banner-title">Monte a sua nova<br>jornada aqui!</h1>
            </div>

            <div class="scroll-down-container">
                <a href="#store-section" class="scroll-down-button">
                    <img src="{{ asset('assets/img/botao.png') }}" alt="Scroll para baixo">
                </a>
            </div>

            <section id="store-section" class="store">
                <form method="GET" action="{{ route('initial') }}" id="filter-form" class="store-filter">
                    <div class="filter-bar-modern">
                        
                        <div class="filter-header-modern">
                            <span class="filter-icon"></span>
                            <h3 class="filter-title-modern">Filtro</h3>
                            <div class="filter-actions-modern">
                                <button type="button" class="btn-reset-modern" onclick="resetFilters()">Resetar</button>
                                <button type="submit" class="btn-apply-modern">Aplicar</button>
                            </div>
                        </div>

                        <div class="filter-content-modern">
                            
                            <div class="filter-group-modern">
                                <label for="nome">Nome:</label>
                                <div style="display: flex; align-items: center; background: white; border-radius: 5px; border: 1px solid #ccc; padding-right: 5px; height: 38px;">
                                    <input type="text" name="search" id="nome" class="filter-input-modern" placeholder="Buscar..." value="{{ request('search') }}" style="border: none; outline: none; box-shadow: none; height: 100%;">
                                    <button type="button" class="btn-reset-field" onclick="limparInput('nome')" style="font-size: 1.2rem; color: #CD004A; padding: 0 8px;">&times;</button>
                                </div>
                            </div>

                            <div class="filter-divider"></div>

                            <div class="filter-group-modern">
                                <label for="cat-trigger">Categorias:</label>
                                <div class="custom-dropdown">
                                    <div class="dropdown-trigger" onclick="toggleDropdown()" id="cat-trigger" style="height: 38px; border: 1px solid #ccc;">
                                        <span id="selected-text" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 130px;">Selecionar categorias...</span>
                                        <span class="dropdown-arrow">▼</span>
                                    </div>
                                    <div id="dropdown-list" class="dropdown-options">
                                        @php $categoriasFixas = ['Vestimentas', 'Acessórios', 'Livros', 'Dados', 'Brinquedos', 'Outro']; $selecionadas = request('categories', []); @endphp
                                        @foreach($categoriasFixas as $cat)
                                            <label class="dropdown-item">
                                                <input type="checkbox" name="categories[]" value="{{ $cat }}" {{ in_array($cat, $selecionadas) ? 'checked' : '' }} onchange="updateDropdownText()">
                                                <span>{{ $cat }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div> </div> </form>
            </section>
        </section>

        <div class="product-grid">
            @foreach($products as $product)
                <div class="product-card">
                    <a href="{{ route('product.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                        <div class="card-header">
                            {{-- AQUI ESTÁ A CORREÇÃO DA IMAGEM --}}
                            <img src="{{ Str::startsWith($product->image1, ['http', 'https']) ? $product->image1 : asset('storage/' . $product->image1) }}" 
                                 alt="{{ $product->name }}" 
                                 class="product-image">
                        </div>
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <p class="product-description">{{ Str::limit($product->description, 50) }}</p>
                        <span class="product-price">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                    </a>

                    @auth
                        @if(Auth::user()->tipo === 'sim')
                            <button type="button" class="buy-button" onclick="openLojistaModal()">
                                COMPRAR
                            </button>
                        @else
                            <a href="{{ route('product.show', $product->id) }}">
                                <button class="buy-button">COMPRAR</button>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('product.show', $product->id) }}">
                            <button class="buy-button">COMPRAR</button>
                        </a>
                    @endauth
                </div>
            @endforeach
        </div>
    </main>

    <div class="footer-spacer"></div>
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; direitos reservados 2025</p>
            <p>Este site foi desenvolvido por Isabelle Matos, Laís Lívia, Luana Miyashiro, Maria Vivielle, Malu Araujo e Yasmin Carolina</p>
        </div>
    </footer>

    <style>
        /* Container do dropdown */
        .custom-dropdown { position: relative; min-width: 200px; }
        
        /* Botão do dropdown */
        .dropdown-trigger {
            background-color: white !important;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 0 15px;
            color: #555 !important;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
            height: 100%;
        }

        /* Lista de opções */
        .dropdown-options {
            display: none;
            position: absolute;
            top: 105%;
            left: 0;
            width: 100%;
            background-color: white !important;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            z-index: 9999;
            padding: 5px 0;
        }
        .dropdown-options.show { display: block; }

        /* Itens da lista */
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            cursor: pointer;
            transition: background 0.2s;
            color: #000 !important;
            background-color: white !important;
        }
        .dropdown-item:hover { background-color: #f0f0f0 !important; }
        .dropdown-item span { color: #000 !important; font-weight: normal; }
        .dropdown-item input { margin-right: 10px; accent-color: #CD004A; width: 16px; height: 16px; }

        @media (max-width: 768px) {
            .filter-content-modern { flex-direction: column; align-items: stretch; gap: 20px; }
            .filter-divider { display: none; }
            .custom-dropdown, .filter-group-modern { width: 100%; }
        }
    </style>

    @if(session('purchase_success'))
        <div id="success-modal" style="display: flex; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 9999; justify-content: center; align-items: center;">
            <div style="position: relative; background: linear-gradient(135deg, #CD004A 0%, #8B0032 100%); border-radius: 20px; padding: 40px; max-width: 500px; text-align: center; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);">
                <button onclick="closeModal()" style="position: absolute; top: -20px; right: -20px; width: 50px; height: 50px; border-radius: 50%; background-color: #CD004A; border: 3px solid white; color: white; font-size: 24px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;">✕</button>
                <h1 style="color: white; font-size: 3rem; margin: 0 0 10px 0; font-weight: bold;">EBA!</h1>
                <h2 style="color: white; font-size: 1.5rem; margin: 0 0 30px 0; font-weight: bold;">COMPRA FINALIZADA COM SUCESSO!</h2>
                <div style="width: 150px; height: 150px; margin: 20px auto; background-color: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 80px;">🪄</div>
                <p style="color: white; font-size: 1.1rem; line-height: 1.6; margin: 20px 0;">Nossos magos já estão preparando a poção<br>para que, magicamente, seu pedido chegue até<br>você!</p>
                <a href="{{ route('profile.edit') }}"><button class="buy-button" style="margin-top: 30px; padding: 15px 40px; font-size: 1.1rem;">Voltar para perfil</button></a>
            </div>
        </div>
    @endif

    <div id="lojista-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 9999; justify-content: center; align-items: center;">
        <div style="position: relative; background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%); border: 2px solid #CD004A; border-radius: 20px; padding: 40px; max-width: 500px; text-align: center; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);">
            <button onclick="closeLojistaModal()" style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background-color: #CD004A; border: 2px solid white; color: white; font-size: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;">✕</button>
            <div style="width: 100px; height: 100px; margin: 0 auto 20px; background-color: rgba(205, 0, 74, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 50px;">🧙‍♂️</div>
            <h2 style="color: white; font-size: 1.8rem; margin: 0 0 15px 0; font-weight: bold;">Opa, Lojista!</h2>
            <p style="color: #ccc; font-size: 1.1rem; line-height: 1.6; margin: 20px 0;">Você está logado como vendedor. <br>Para comprar itens, por favor, entre com seu <strong>perfil de usuário comum</strong>.</p>
            <button onclick="closeLojistaModal()" class="buy-button" style="margin-top: 20px; padding: 12px 30px; font-size: 1rem;">Entendido</button>
        </div>
    </div>

    <script>
        function resetFilters() {
            window.location.href = '{{ route("initial") }}';
        }

        function limparInput(id) {
            const input = document.getElementById(id);
            if(input) input.value = '';
        }

        function closeModal() {
            const modal = document.getElementById('success-modal');
            if (modal) modal.style.display = 'none';
        }

        function openLojistaModal() {
            const modal = document.getElementById('lojista-modal');
            if (modal) modal.style.display = 'flex';
        }

        function closeLojistaModal() {
            const modal = document.getElementById('lojista-modal');
            if (modal) modal.style.display = 'none';
        }

        function toggleDropdown() {
            const list = document.getElementById('dropdown-list');
            list.classList.toggle('show');
        }

        function updateDropdownText() {
            const checkboxes = document.querySelectorAll('.dropdown-item input[type="checkbox"]:checked');
            const textSpan = document.getElementById('selected-text');
            if (checkboxes.length === 0) {
                textSpan.innerText = "Selecionar categorias...";
                textSpan.style.color = "#555";
            } else {
                const values = Array.from(checkboxes).map(cb => cb.value);
                textSpan.innerText = values.join(', ');
                textSpan.style.color = "#000";
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateDropdownText();
            
            const successModal = document.getElementById('success-modal');
            if (successModal) {
                successModal.addEventListener('click', function(e) {
                    if (e.target === this) closeModal();
                });
            }

            const lojistaModal = document.getElementById('lojista-modal');
            if (lojistaModal) {
                lojistaModal.addEventListener('click', function(e) {
                    if (e.target === this) closeLojistaModal();
                });
            }

            window.addEventListener('click', function(e) {
                const dropdown = document.querySelector('.custom-dropdown');
                if (dropdown && !dropdown.contains(e.target)) {
                    document.getElementById('dropdown-list').classList.remove('show');
                }
            });
        });
    </script>

</body>
</html>
