<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu perfil - Comprador</title>

    <link rel="stylesheet" href="{{ asset('assets/css/estiloMain.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/button.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('components/atoms/input.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/label.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/form-group.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/product-card.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/header.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/product-grid.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    
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
                <div class="Loja">
                <ul class="nav-links">
                    <li><a href="{{ route('initial') }}" class="active-link">Loja</a></li>
                </ul>
                </div>
                <div class="user-actions ">
                    <div class="carrinho " >
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
                    </div>    
                    @auth
                        <a href="{{ Auth::user()->tipo === 'sim' ? route('dashboard') : route('profile.edit') }}">                            @if(Auth::user()->imagemPerfil)
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
                <img src="{{ asset('assets/img/Banner perfil.png') }}" alt="Banner com personagens de RPG">
                <h1 class="banner-title-buyer">Seu perfil - Comprador</h1>
            </div>

            <div class="scroll-down-container">
                <a href="#store-section" class="scroll-down-button">
                    <img src="{{ asset('assets/img/botao.png') }}" alt="Scroll para baixo">
                </a>
            </div>

            <section id="store-section" class="store">
                @if(session('status') === 'profile-updated')
                    <div style="background-color: #28a745; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                        Perfil atualizado com sucesso!
                    </div>
                @endif

                <section id="profile-buyer-infos" class="buyer-infos">
                    <h2>Suas informações</h2>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="buyer-info-content">
                            <div class="buyer-photo">
                                <img id="profile-preview" 
                                     src="{{ Auth::user()->imagemPerfil ? asset('storage/' . Auth::user()->imagemPerfil).'?v='.time() : asset('assets/img/user-icon.png') }}" 
                                     alt="Foto do comprador"
                                     style="width: 180px; height: 180px; border-radius: 50%; object-fit: cover; border: 4px solid #ffff;">
                            </div>

                            <div class="buyer-fields">
                                <div class="field-row">
                                    <label class="profile-picture">Foto de perfil:</label>
                                    <div class="input-upload-container">
                                        <input type="file" id="profile-upload" name="imagemPerfil" style="display: none;" accept="image/*" onchange="previewImage(event)">
                                        <button type="button" class="btn-upload" onclick="document.getElementById('profile-upload').click()">
                                            FAÇA O UPLOAD
                                        </button>
                                    </div>
                                </div>

                                <div class="field-row">
                                    <label>Nome:</label>
                                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                </div>

                                <div class="field-row">
                                    <label>Email:</label>
                                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                </div>
                                
                                <div class="field-row">
                                    <label>CEP:</label>
                                    <input type="text" name="cep" value="{{ old('cep', Auth::user()->cep) }}" required>
                                </div>

                                <div class="field-row">
                                    <label>Logradouro:</label>
                                    <input type="text" name="logradouro" value="{{ old('logradouro', Auth::user()->logradouro) }}" required>
                                </div>

                                <div class="field-row">
                                    <label>Número:</label>
                                    <input type="text" name="numero" value="{{ old('numero', Auth::user()->numero) }}" required>
                                </div>

                                <div class="field-row">
                                    <label>Complemento:</label>
                                    <input type="text" name="complemento" value="{{ old('complemento', Auth::user()->complemento) }}">
                                </div>
                                
                                <div class="buyer-save-btn">
                                    <button type="submit" class="btn-primary">Salvar Alterações</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>

                <section id="buyer-salesAds" class="buyer-ads" style="margin-top: 50px;">
                    <section id="buyer-ItemsShopped" class="buyer-shopped">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h2 style="color: #ffffff; margin: 0;">Seus pedidos</h2>
                        </div>

                        <form method="GET" action="{{ route('profile.edit') }}" class="filter-bar-modern">
                            <div class="filter-header-modern">
                                <div style="display: flex; align-items: center;">
                                    <span class="filter-icon" style="font-size: 1.5rem; margin-right: 10px;"></span>
                                    <h3 class="filter-title-modern" style="margin: 0;">Filtro</h3>
                                </div>
                                <div class="filter-actions-modern">
                                    <a href="{{ route('profile.edit') }}" class="btn-reset-modern">Resetar</a>
                                    <button type="submit" class="btn-apply-modern">Aplicar</button>
                                </div>
                            </div>

                            <div class="filter-content-modern">
                                <div class="filter-group-modern">
                                    <label for="order-data">Data da Compra:</label>
                                    <input type="date" name="date" id="order-data" class="filter-select-modern" 
                                           value="{{ request('date') }}" 
                                           style="background: white; color: black;">
                                </div>

                                <div class="filter-divider"></div>

                                <div class="filter-group-modern">
                                    <label for="order-nome">Nome do Produto:</label>
                                    <input type="text" name="search" id="order-nome" class="filter-input-modern" 
                                           placeholder="Buscar..." 
                                           value="{{ request('search') }}">
                                </div>

                                <div class="filter-divider"></div>

                                <div class="filter-group-modern">
                                    <label for="order-categoria">Categoria:</label>
                                    <select name="category_id" id="order-categoria" class="filter-select-modern">
                                        <option value="">Todas</option>
                                        {{-- GARANTINDO QUE EXISTE CATEGORIA --}}
                                        @if(isset($categories))
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </form>

                        @if(!isset($orders) || $orders->isEmpty())
                            <div style="text-align: center; padding: 40px; background-color: #1a1a1a; border-radius: 10px; color: #ccc;">
                                <p style="font-size: 1.2rem;">Nenhum pedido encontrado com esses filtros.</p>
                                <a href="{{ route('initial') }}">
                                    <button class="buy-button" style="margin-top: 20px; padding: 10px 30px;">Ir para a loja</button>
                                </a>
                            </div>
                        @else
                            <div class="orders-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                                @foreach($orders as $order)
                                    <div class="order-card" style="background-color: #2a2a2a; border-radius: 10px; overflow: hidden; position: relative; border-left: 5px solid #CD004A; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
                                        
                                        <div class="order-image" style="height: 200px; background-color: #fff; display: flex; align-items: center; justify-content: center; position: relative;">
                                            @if($order->items->first() && $order->items->first()->product)
                                                {{-- CORREÇÃO DA IMAGEM NA LISTA --}}
                                                <img src="{{ Str::startsWith($order->items->first()->product->image1, ['http', 'https']) ? $order->items->first()->product->image1 : asset('storage/' . $order->items->first()->product->image1) }}" 
                                                     alt="Produto" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                            @else
                                                <span style="font-size: 3rem;">📦</span>
                                            @endif
                                            
                                            <div class="order-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); padding: 10px; text-align: center;">
    <h3 style="color: white; margin: 0; font-size: 1rem;">
        {{-- Se tiver produto, mostra o nome. Se não, mostra o ID --}}
        {{ $order->items->first() && $order->items->first()->product ? $order->items->first()->product->name : 'Pedido #' . $order->id }}
    </h3>
    <small style="color: #ccc;">{{ $order->created_at->format('d/m/Y') }}</small>
</div>
                                        </div>
                                        
                                        <div class="order-actions" style="padding: 15px; display: flex; flex-direction: column; gap: 10px;">
                                            <div style="text-align: right;">
                                                 <span style="color: #CD004A; font-weight: bold;">Total: R$ {{ number_format($order->total, 2, ',', '.') }}</span>
                                            </div>
                                            
                                            <div style="display: flex; gap: 10px;">
                                                <button onclick="showOrderDetails({{ $order->id }})" style="flex: 1; padding: 10px; background-color: #0066cc; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                                                    Detalhes
                                                </button>

                                                @if($order->status === 'pending')
                                                    <button onclick="showCancelModal({{ $order->id }})" style="flex: 1; padding: 10px; background-color: #CD004A; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                                                        Cancelar
                                                    </button>
                                                @else
                                                    <button disabled style="flex: 1; padding: 10px; background-color: #444; color: #888; border: 1px solid #666; border-radius: 5px; cursor: not-allowed;">
                                                        {{ $order->status == 'cancelled' ? 'Cancelado' : 'Enviado' }}
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </section>
                </section>
            </section>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; direitos reservados 2025</p>
            <p>Este site foi desenvolvido por Isabelle Matos, Laís Lívia, Luana Miyashiro, Maria Vivielle, Malu Araujo e Yasmin Carolina</p>
        </div>
    </footer>

    <div id="details-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.9); z-index: 9999; justify-content: center; align-items: center; overflow-y: auto;">
        <div style="position: relative; background-color: #1a1a1a; border-radius: 20px; padding: 40px; max-width: 800px; width: 90%; margin: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);">
            <button onclick="closeDetailsModal()" style="position: absolute; top: -20px; right: -20px; width: 50px; height: 50px; border-radius: 50%; background-color: #CD004A; border: 3px solid white; color: white; font-size: 24px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;">✕</button>
            <h2 style="color: white; font-size: 2rem; margin: 0 0 30px 0; padding-bottom: 20px; border-bottom: 1px solid #444;">Detalhes do pedido</h2>
            <div id="order-details-content"></div>
        </div>
    </div>

    <div id="cancel-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 9999; justify-content: center; align-items: center;">
        <div style="position: relative; background: linear-gradient(135deg, #CD004A 0%, #8B0032 100%); border-radius: 20px; padding: 40px; max-width: 500px; text-align: center; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);">
            <button onclick="closeCancelModal()" style="position: absolute; top: -20px; right: -20px; width: 50px; height: 50px; border-radius: 50%; background-color: #CD004A; border: 3px solid white; color: white; font-size: 24px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;">✕</button>
            <h2 style="color: white; font-size: 2rem; margin: 0 0 20px 0; font-weight: bold;">Cancelar Pedido?</h2>
            <p style="color: white; font-size: 1.1rem; line-height: 1.6; margin: 20px 0;">Tem certeza que deseja cancelar este pedido?<br>Esta ação não pode ser desfeita.</p>
            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <button onclick="closeCancelModal()" style="flex: 1; padding: 15px; background-color: transparent; border: 2px solid white; color: white; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 1rem;">Não, voltar</button>
                <form id="cancel-form" method="POST" style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width: 100%; padding: 15px; background-color: white; color: #CD004A; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 1rem;">Sim, cancelar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        function showOrderDetails(orderId) {
            const orders = @json(isset($orders) ? $orders : []);
            const order = orders.find(o => o.id === orderId);
            
            if (!order) return;

            let itemsHtml = '';
            order.items.forEach(item => {
                // CORREÇÃO DA IMAGEM NO JAVASCRIPT
                let imagem = '';
                if(item.product.image1 && item.product.image1.startsWith('http')) {
                    imagem = item.product.image1;
                } else if(item.product.image1) {
                    imagem = `/storage/${item.product.image1}`;
                } else {
                    imagem = '/assets/img/iconeMago.png';
                }

                itemsHtml += `
                    <div style="display: flex; gap: 20px; margin-top: 20px; padding: 15px; background-color: #2a2a2a; border-radius: 10px;">
                        <div style="flex-shrink: 0;">
                            <img src="${imagem}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                        </div>
                        <div style="flex-grow: 1;">
                            <h3 style="color: #CD004A; margin: 0 0 5px 0;">${item.product.name}</h3>
                            <p style="color: white; margin: 5px 0;">Qtd: ${item.quantity} | Unit: R$ ${parseFloat(item.price).toFixed(2)}</p>
                            <p style="color: #ccc; margin: 5px 0; font-size: 0.9rem;">${item.product.description || ''}</p>
                        </div>
                    </div>
                `;
            });

            const content = `
                <div style="color: white;">
                    <p><strong>Data:</strong> ${new Date(order.created_at).toLocaleDateString('pt-BR')}</p>
                    <p><strong>Status:</strong> ${order.status === 'pending' ? 'Em rota' : order.status}</p>
                    <p><strong>Total:</strong> R$ ${parseFloat(order.total).toFixed(2)}</p>
                    <hr style="border-color: #444; margin: 20px 0;">
                    ${itemsHtml}
                </div>
            `;

            document.getElementById('order-details-content').innerHTML = content;
            document.getElementById('details-modal').style.display = 'flex';
        }

        function closeDetailsModal() {
            document.getElementById('details-modal').style.display = 'none';
        }

        function showCancelModal(orderId) {
            const modal = document.getElementById('cancel-modal');
            const form = document.getElementById('cancel-form');
            form.action = `/order/${orderId}`;
            modal.style.display = 'flex';
        }

        function closeCancelModal() {
            document.getElementById('cancel-modal').style.display = 'none';
        }

        // Fechar modais ao clicar fora
        window.onclick = function(event) {
            const detailsModal = document.getElementById('details-modal');
            const cancelModal = document.getElementById('cancel-modal');
            if (event.target == detailsModal) detailsModal.style.display = 'none';
            if (event.target == cancelModal) cancelModal.style.display = 'none';
        }
    </script>

    <style>
        /* === CORREÇÃO GERAL DE LAYOUT === */
        * {
            box-sizing: border-box; /* Isso impede que paddings estourem o tamanho dos elementos */
        }

        /* Container do Filtro */
        .filter-bar-modern { 
            background-color: #2a2a2a; 
            border-radius: 10px; 
            padding: 20px; 
            margin-bottom: 30px; 
            width: 100%; /* Garante que ocupa a largura certa */
            border: 1px solid #444; /* Borda sutil para definir o limite */
        }

        /* Cabeçalho do Filtro */
        .filter-header-modern { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            margin-bottom: 20px; 
            padding-bottom: 15px; 
            border-bottom: 1px solid #444; 
        }

        .filter-title-modern { 
            flex-grow: 1; 
            margin: 0; 
            font-size: 1.2rem; 
            color: white; 
            margin-left: 10px; 
        }

        /* Botões Resetar/Aplicar */
        .filter-actions-modern { display: flex; gap: 10px; }
        
        .btn-reset-modern, .btn-apply-modern { 
            padding: 8px 20px; 
            border-radius: 5px; 
            border: none; 
            cursor: pointer; 
            font-weight: bold; 
            transition: all 0.3s; 
            text-decoration: none; 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            height: 40px; /* Altura fixa para alinhar */
        }
        
        .btn-reset-modern { background-color: transparent; border: 1px solid #666; color: #ccc; }
        .btn-reset-modern:hover { background-color: #444; color: white; }
        .btn-apply-modern { background-color: #CD004A; color: white; }
        .btn-apply-modern:hover { background-color: #a0003a; }

        /* Conteúdo do Filtro (Inputs) */
        .filter-content-modern { 
            display: flex; 
            gap: 20px; 
            align-items: flex-end; /* Alinha tudo pela base */
            margin-bottom: 0; /* Remove margem extra */
            flex-wrap: wrap; 
        }

        .filter-group-modern { 
            display: flex; 
            flex-direction: column; 
            gap: 5px; 
            flex: 1; 
            min-width: 200px; 
        }

        .filter-group-modern label { 
            color: white; 
            font-weight: bold; 
            font-size: 0.9rem; 
        }

        /* === A MÁGICA DOS INPUTS E SELECTS IGUAIS === */
        .filter-select-modern, .filter-input-modern { 
            width: 100%; 
            height: 45px; /* Altura unificada e maiorzinha */
            padding: 0 15px; /* Padding lateral */
            border-radius: 5px; 
            border: 1px solid #555; 
            background-color: white; 
            color: #000; 
            font-size: 1rem;
            outline: none;
            
            /* Remove estilo padrão do navegador para ficar igual */
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        /* Estilizando a setinha do Select na marra com CSS */
        select.filter-select-modern {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='black' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 15px;
            padding-right: 40px; /* Espaço para a seta não ficar em cima do texto */
            cursor: pointer;
        }

        .filter-input-modern::placeholder { color: #666; }

        .filter-divider { 
            width: 1px; 
            height: 45px; /* Altura igual aos inputs */
            background-color: #555; 
            display: none; 
        }

        @media(min-width: 768px) { .filter-divider { display: block; } }
    </style>
</body>
</html>