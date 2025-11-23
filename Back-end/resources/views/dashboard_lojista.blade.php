<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu perfil - Lojista</title>

    <!-- Seus CSS originais -->
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

    <!-- CSS CORRIGIDO PARA O VISUAL IGUAL AO FIGMA -->
    <style>
        /* Garante que os produtos fiquem em grade (lado a lado) */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Responsivo */
            gap: 20px;
            width: 100%;
            margin-top: 30px;
            margin-bottom: 50px;
        }

        /* Card Preto do Lojista */
        .seller-card {
            background-color: #000000; /* Fundo Preto */
            border: 1px solid #333;
            border-radius: 12px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            transition: transform 0.2s;
            height: 100%; /* Altura igual para todos */
        }

        .seller-card:hover {
            transform: translateY(-5px);
            border-color: #e85d04; /* Laranja no hover */
        }

        /* Imagem dentro do card */
        .seller-card img {
            width: 100%;
            height: 200px; /* Altura fixa da imagem */
            object-fit: cover; /* Corta a imagem sem esticar */
            border-radius: 8px;
            margin-bottom: 15px;
            background-color: #222;
        }

        /* Texto do Card */
        .seller-card h3 {
            color: #ffffff;
            font-family: 'Roboto Condensed', sans-serif;
            font-size: 1.1rem;
            margin-bottom: 5px;
            text-align: center;
            text-transform: uppercase;
        }

        .seller-card .price {
            color: #e85d04;
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        /* Botões de Ação (Editar/Excluir) */
        .seller-actions {
            display: flex;
            gap: 10px;
            width: 100%;
            margin-top: auto; /* Empurra para o fundo do card */
        }

        .btn-card {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 0.9rem;
            transition: opacity 0.2s;
        }

        .btn-edit { background-color: #4a90e2; } /* Azul */
        .btn-delete { background-color: #d0021b; } /* Vermelho */
        
        .btn-card:hover { opacity: 0.8; }

        /* Esconde a tabela antiga se ela ainda existir */
        table { display: none !important; }
    </style>
</head>

<body>

    <header class="header">
        <nav class="navbar">
            <div class="navbar-content">
                <div class="logo">
                    <img src="{{ asset('assets/img/logoDaora.png') }}" alt="Logo Ta Na Mesa">
                </div>
                <div class="user-actions">
                    <!-- Foto do usuário logado -->
                    <a href="#"><img src="{{ asset('assets/img/gatoMago.jpg') }}" alt="Perfil do usuário"></a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="perfilLojista" style="background:none; border:none; cursor:pointer; font-family:inherit; font-size:inherit; color:inherit; margin-left: 10px;">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    
    <main class="main-content">
        <section class="hero-banner">
            <div class="banner-image">
                <img src="{{ asset('assets/img/Banner perfil.png') }}" alt="Banner com personagens de RPG">
                <h1 class="banner-title-seller">Seu perfil - Lojista</h1>
            </div>

            <section id="store-section" class="store">
                
                <!-- INFORMAÇÕES DO VENDEDOR -->
                <section id="profile-seller-infos" class="seller-infos">
                    <h2>Suas informações</h2>
                    <div class="seller-info-content">
                        <div class="seller-photo">
                            <img src="{{ asset('assets/img/gatoMago.jpg') }}" alt="Foto do vendedor">
                        </div>
                        <div class="seller-fields">
                            <div class="field-row">
                                <label>Foto de perfil:</label>
                                <div class="input-upload-container">
                                    <button type="button" class="btn-upload">FAÇA O UPLOAD</button>
                                </div>
                            </div>
                            
                            <!-- Exibindo nome do usuário logado -->
                            <div class="field-row">
                                <label>Nome da Loja:</label>
                                <input type="text" value="{{ Auth::user()->name }}" readonly style="background: #ddd;">
                            </div>

                            <div class="seller-save-btn">
                                <button class="btn-primary">Salvar</button>
                            </div>
                        </div>
                    </div>
                </section>
            
                <!-- SEÇÃO DE ANÚNCIOS -->
                <section id="seller-salesAds" class="seller-ads">
                    <h2 class="sellers-title">Seus anúncios</h2>

                    <!-- Filtros visuais -->
                    <div class="filter-bar">
                        <div class="filter-header">
                            <p class="filter-title">Filtro</p>
                            <div class="filter-actions">
                                <button class="btn-reset">Resetar</button>
                                <button class="btn-apply">Aplicar</button>
                            </div>
                        </div>
                        <div class="filter-line"></div>
                        <div class="filter-row">
                            <div class="filter-group">
                                <label>Data:</label>
                                <div class="input-container"><input type="date"></div>
                            </div>
                            <div class="filter-group">
                                <label>Nome:</label>
                                <div class="input-container"><select><option>Todos</option></select></div>
                            </div>
                            <div class="filter-group">
                                <label>Categoria:</label>
                                <div class="input-container"><select><option>Todas</option></select></div>
                            </div>
                        </div>
                    </div>

                    <!-- AQUI É O GRID DOS PRODUTOS -->
                    <div class="product-grid">
                        
                        <!-- 
                           A lógica abaixo evita o erro "Malformed" e "Undefined variable".
                           Se $products não existir, usa um array vazio [].
                        -->
                        @forelse($products ?? [] as $product)
                            <div class="seller-card">
                                
                                <!-- Imagem do Produto -->
                                @if($product->image1)
                                    <img src="{{ asset('storage/'.$product->image1) }}" 
                                         onerror="this.src='{{ asset($product->image1) }}'; this.onerror=null;" 
                                         alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('assets/img/iconeMago.png') }}" alt="Sem imagem">
                                @endif

                                <!-- Título e Preço -->
                                <h3>{{ $product->name }}</h3>
                                <span class="price">R$ {{ number_format($product->price, 2, ',', '.') }}</span>

                                <!-- Botões de Ação -->
                                <div class="seller-actions">
                                    <!-- Verifica se a rota de edição existe antes de criar o link -->
                                    @if(Route::has('product.edit'))
                                        <a href="{{ route('product.edit', $product->id) }}" class="btn-card btn-edit">EDITAR</a>
                                    @else
                                        <a href="#" class="btn-card btn-edit" style="background:gray;">EDITAR</a>
                                    @endif
                                    
                                    <!-- Formulário de Exclusão -->
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir?');" style="flex:1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-card btn-delete" style="width:100%;">EXCLUIR</button>
                                    </form>
                                </div>

                            </div>
                        @empty
                            <!-- Mensagem caso não tenha produtos -->
                            <div style="grid-column: 1/-1; text-align: center; padding: 40px; background: #f4f4f4; border-radius: 10px; color: #666;">
                                <p style="font-size: 1.2rem;">Você ainda não cadastrou nenhum produto.</p>
                            </div>
                        @endforelse

                    </div>

                    <button class="btn-ads" id="openModalButton">Adicionar novo anúncio</button>
                </section>

            </section>
        </section>


        <!-- MODAL DE CADASTRO DE PRODUTO -->
        <div id="productModal" class="modal-overlay">
            <div class="modal-content">
                <button class="modal-close-btn">&times;</button>
                <h2>Insira informações sobre o produto</h2>

                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-form-grid">
                        <label>Nome:</label>
                        <input type="text" name="name" placeholder="Nome do produto" class="modal-input-textarea" required>

                        <label>Preço:</label>
                        <input type="number" name="price" step="0.01" placeholder="R$ 0,00" class="modal-input-textarea" required>

                        <label>Quantidade:</label>
                        <input type="number" name="units" class="modal-input" required>

                        <label>Tags:</label>
                        <input type="text" placeholder="Ex: RPG, Dados" class="modal-input-textarea">

                        <label>Categoria:</label>
                        <select name="category_id" class="modal-input" required>
                            <option value="1">Geral</option>
                            <option value="2">RPG</option>
                        </select>

                        <label>Foto do produto:</label>
                        <input type="file" name="image1" class="modal-btn-upload" required>

                        <label>Descrição:</label>
                        <textarea name="description" placeholder="Descrição do item..." class="modal-input-textarea" required></textarea>
                    </div>
                    <button type="submit" class="modal-btn-primary">Criar Anúncio!</button>
                </form>
            </div>
        </div>

    </main>

    <!-- SCRIPT DO MODAL -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('productModal');
            const openBtn = document.getElementById('openModalButton');
            const closeBtn = document.querySelector('.modal-close-btn');

            if (openBtn) openBtn.onclick = () => modal.style.display = 'flex';
            if (closeBtn) closeBtn.onclick = () => modal.style.display = 'none';
            window.onclick = (e) => { if(e.target == modal) modal.style.display = 'none'; }
        });
    </script>

</body>