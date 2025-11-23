<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu perfil - Lojista</title>

    <link rel="stylesheet" href="{{ asset('assets/css/estiloMain.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/button.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('components/atoms/input.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/label.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/form-group.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/product-card.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/header.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/product-grid.css') }}">

    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            width: 100%;
            margin-top: 20px;
        }
    </style>
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
                    <a href="#">
                        <img src="{{ Auth::user()->imagemPerfil ? asset('storage/'.Auth::user()->imagemPerfil) : asset('assets/img/gatoMago.jpg') }}" 
                             alt="Perfil do usuário" 
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                    </a>

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
                
                <!-- SEÇÃO DE INFORMAÇÕES DO LOJISTA -->
                <section id="profile-seller-infos" class="seller-infos">
                    <h2>Suas informações</h2>
                    <div class="seller-info-content">
                        <div class="seller-photo">
                            <img src="{{ Auth::user()->imagemPerfil ? asset('storage/'.Auth::user()->imagemPerfil) : asset('assets/img/gatoMago.jpg') }}" alt="Foto do vendedor">
                        </div>
                        
                        <form class="seller-fields" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="field-row">
                                <label>Foto de perfil:</label>
                                <div class="input-upload-container">
                                    <input type="file" id="profile-upload" name="imagemPerfil" style="display: none;">
                                    <button type="button" class="btn-upload" onclick="document.getElementById('profile-upload').click()">FAÇA O UPLOAD</button>
                                </div>
                            </div>

                            <div class="field-row">
                                <label>Nome:</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}">
                            </div>

                            <div class="field-row">
                                <label>Link para contato:</label>
                                <input type="url" name="contact_link" placeholder="Link do seu instagram/whatsapp...">
                            </div>

                            <div class="field-row">
                                <label>Breve descrição:</label>
                                <div class="textarea-wrapper">
                                    <textarea rows="3" name="description" placeholder="Descrição da sua loja..."></textarea>
                                </div>
                            </div>

                            <div class="seller-save-btn">
                                <button type="submit" class="btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </section>

                <!-- SEÇÃO DE ANÚNCIOS -->
                <section id="seller-salesAds" class="seller-ads">
                    <h2 class="sellers-title">Seus anúncios</h2>

                    <!-- Filtros (Mantendo seu HTML original) -->
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
                                <label for="data">Data:</label>
                                <div class="input-container">
                                    <input type="date" id="data">
                                </div>
                            </div>
                            <div class="filter-group">
                                <label for="sistema">Nome:</label>
                                <div class="input-container">
                                    <select id="sistema"><option>Todos</option></select>
                                </div>
                            </div>
                            <div class="filter-group">
                                <label for="localizacao">Categoria:</label>
                                <div class="input-container">
                                    <select id="localizacao"><option>Todas</option></select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- GRID DE PRODUTOS -->
                    <div class="product-grid">
    @forelse($products as $product)
        <div class="product-card" style="background-color: #000; border: 1px solid #333; padding: 15px; border-radius: 10px; display:flex; flex-direction:column; align-items:center;">
            
            <div class="product-image" style="width:100%; height:200px; margin-bottom:10px;">
                @if($product->image1)
                    <img src="{{ asset('storage/'.$product->image1) }}" 
                         alt="{{ $product->name }}" 
                         style="width:100%; height:100%; object-fit:cover; border-radius:5px;"
                         onerror="this.onerror=null;this.src='{{ asset('assets/img/iconeMago.png') }}';"> 
                @else
                    <img src="{{ asset('assets/img/iconeMago.png') }}" alt="Sem imagem" style="width:100%; height:100%; object-fit:contain;">
                @endif
            </div>

            <h3 style="color:white; margin-bottom:5px;">{{ $product->name }}</h3>
            <p class="price" style="color:#e85d04; font-weight:bold;">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
            
            <div style="display:flex; gap:10px; width:100%; margin-top:10px;">
                <button type="button" 
                        onclick="document.getElementById('editModal-{{ $product->id }}').style.display='flex'"
                        style="flex:1; background:#2196F3; color:white; border:none; padding:8px; border-radius:5px; cursor:pointer; font-size:1rem;">
                    Editar
                </button>

                <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Tem certeza?');" style="flex:1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width:100%; height:100%; background:#F44336; color:white; border:none; padding:8px; border-radius:5px; cursor:pointer; font-size:1rem;">Excluir</button>
                </form>
            </div>
        </div> 
        <div id="editModal-{{ $product->id }}" class="modal-overlay" 
             style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:9999; justify-content:center; align-items:center; backdrop-filter: blur(4px);">
            
            <div class="modal-content" style="background:#0f0f0f; border-radius:8px; width:480px; max-width:95%; position:relative; overflow:hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                
                <button type="button" onclick="document.getElementById('editModal-{{ $product->id }}').style.display='none'" 
                        style="position:absolute; top:10px; right:10px; background:#D81B60; width:40px; height:40px; border-radius:50%; border:none; color:white; font-size:1.5rem; cursor:pointer; z-index:10; display:flex; align-items:center; justify-content:center;">&times;</button>

                <div style="width:100%; height:150px;">
                    <img src="{{ asset('assets/img/imagemEditar.jpg') }}" alt="Editar" style="width:100%; height:100%; object-fit:cover; opacity: 0.8;">
                </div>

                <div style="padding: 20px 40px 30px 40px;">
                    <h2 style="text-align:center; color:white; font-family: 'Playfair Display', serif; font-weight: 400; margin-bottom:20px; font-size:1.5rem; border-bottom:1px solid #333; padding-bottom:10px;">
                        Edite informações
                    </h2>

                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <div class="form-row" style="display: grid; grid-template-columns: 90px 1fr; align-items: center; gap: 10px;">
                                <label style="color:#ddd; text-align:right;">Nome:</label>
                                <input type="text" name="name" value="{{ $product->name }}" required 
                                       style="width:100%; height:35px; padding:0 10px; background:#4f4f4f; border:none; border-radius:4px; color:white;">
                            </div>

                            <div class="form-row" style="display: grid; grid-template-columns: 90px 1fr; align-items: center; gap: 10px;">
                                <label style="color:#ddd; text-align:right;">Preço:</label>
                                <input type="number" step="0.01" name="price" value="{{ $product->price }}" required 
                                       style="width:100%; height:35px; padding:0 10px; background:#4f4f4f; border:none; border-radius:4px; color:white;">
                            </div>

                            <div class="form-row" style="display: grid; grid-template-columns: 90px 1fr; align-items: center; gap: 10px;">
                                <label style="color:#ddd; text-align:right;">Qtd:</label>
                                <input type="number" name="units" value="{{ $product->units }}" required 
                                       style="width:100%; height:35px; padding:0 10px; background:#4f4f4f; border:none; border-radius:4px; color:white;">
                            </div>

                            <div class="form-row" style="display: grid; grid-template-columns: 90px 1fr; align-items: center; gap: 10px;">
                                <label style="color:#ddd; text-align:right;">Categoria:</label>
                                <select name="category_id" style="width:100%; height:35px; background:#4f4f4f; border:none; border-radius:4px; color:white;">
                                    <option value="1" {{ $product->category_id == 1 ? 'selected' : '' }}>Geral</option>
                                    <option value="2" {{ $product->category_id == 2 ? 'selected' : '' }}>RPG</option>
                                </select>
                            </div>

                            <div class="form-row" style="display: grid; grid-template-columns: 90px 1fr; align-items: center; gap: 10px;">
                                <label style="color:#ddd; text-align:right;">Foto:</label>
                                <div style="background:#4f4f4f; border-radius:4px; height: 35px; display: flex; align-items: center; padding-left: 5px; width: 100%;">
                                    <input type="file" name="image1" style="width:100%; color:#aaa; font-size: 0.8rem; background: transparent; border: none;">
                                </div>
                            </div>

                            <div class="form-row" style="display: grid; grid-template-columns: 90px 1fr; align-items: start; gap: 10px;">
                                <label style="color:#ddd; text-align:right; margin-top:5px;">Desc:</label>
                                <textarea name="description" rows="2" style="width:100%; padding:5px; background:#4f4f4f; border:none; border-radius:4px; color:white;">{{ $product->description }}</textarea>
                            </div>
                        </div>

                        <button type="submit" style="width:100%; margin-top:20px; padding:12px; background:#D81B60; color:white; border:none; font-weight:bold; border-radius:6px; cursor:pointer;">
                            Salvar
                        </button>
                    </form>
                    
                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Tem certeza?');" style="margin-top:10px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="width:100%; padding:10px; background:#ccc; color:#333; border:none; font-weight:bold; border-radius:6px; cursor:pointer;">
                            Desativar Anúncio
                        </button>
                    </form>

                </div>
            </div>
        </div>

    @empty
        <p style="color: white; grid-column: 1/-1; text-align: center; padding: 20px;">Você ainda não possui anúncios.</p>
    @endforelse
</div>

                    <button class="btn-ads" id="openModalButton">Adicionar novo anúncio</button>
                </section>
            </section>
        </section>

        <!-- MODAL (Lógica para salvar no banco) -->
        <div id="productModal" class="modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:1000; justify-content:center; align-items:center; backdrop-filter: blur(4px);">
    
    <div class="modal-content" style="background:#0f0f0f; padding:30px 40px; border-radius:8px; width:480px; max-width:95%; position:relative; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
        
        <button class="modal-close-btn" style="position:absolute; top:-15px; right:-15px; background:#D81B60; width:45px; height:45px; border-radius:50%; border:none; color:white; font-size:1.8rem; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">&times;</button>
        
        <div style="text-align:center; margin-bottom:25px; border-bottom: 1px solid #333; padding-bottom: 15px;">
            <h2 style="color:white; font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 400; letter-spacing: 0.5px;">
                Insira informações sobre o produto
            </h2>
        </div>

        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-form-grid" style="display:flex; flex-direction:column; gap:12px;">
                
                <div class="form-row" style="display: grid; grid-template-columns: 100px 1fr; align-items: center; gap: 10px;">
                    <label style="color:#ddd; font-size: 1rem; text-align: right;">Nome:</label>
                    <input type="text" name="name" placeholder="Nome do produto" required 
                           style="width:100%; height: 35px; padding:0 10px; background:#4f4f4f; border:none; border-radius:4px; color:white; font-style: italic; font-size: 0.9rem;">
                </div>

                <div class="form-row" style="display: grid; grid-template-columns: 100px 1fr; align-items: center; gap: 10px;">
                    <label style="color:#ddd; font-size: 1rem; text-align: right;">Preço:</label>
                    <input type="number" name="price" step="0.01" placeholder="Digite o valor em R$" required 
                           style="width:100%; height: 35px; padding:0 10px; background:#4f4f4f; border:none; border-radius:4px; color:white; font-style: italic; font-size: 0.9rem;">
                </div>

                <div class="form-row" style="display: grid; grid-template-columns: 100px 1fr; align-items: center; gap: 10px;">
                    <label style="color:#ddd; font-size: 1rem; text-align: right;">Quantidade:</label>
                    <input type="number" name="units" placeholder="Quantidade em estoque" required 
                           style="width:100%; height: 35px; padding:0 10px; background:#4f4f4f; border:none; border-radius:4px; color:white; font-style: italic; font-size: 0.9rem;">
                </div>

                <div class="form-row" style="display: grid; grid-template-columns: 100px 1fr; align-items: center; gap: 10px;">
                    <label style="color:#ddd; font-size: 1rem; text-align: right;">Categoria:</label>
                    <div style="position:relative; width: 100%;">
                        <select name="category_id" required 
                                style="width:100%; height: 35px; padding:0 10px; background:#4f4f4f; border:none; border-radius:4px; color:white; font-style: italic; appearance: none; cursor:pointer; font-size: 0.9rem;">
                            <option value="" disabled selected>Para sua mesa/Vestir</option> <option value="1">Geral</option>
                            <option value="2">RPG</option>
                        </select>
                        <span style="position:absolute; right:10px; top:50%; transform:translateY(-50%); color:white; pointer-events:none; font-size: 0.8rem;">&#9660;</span>
                    </div>
                </div>

                <div class="form-row" style="display: grid; grid-template-columns: 100px 1fr; align-items: center; gap: 10px;">
                    <label style="color:#ddd; font-size: 1rem; text-align: right;">Foto:</label>
                    <div style="background:#4f4f4f; border-radius:4px; height: 35px; display: flex; align-items: center; padding-left: 5px; width: 100%;">
                        <input type="file" name="image1" required 
                               style="width:100%; color:#aaa; font-size: 0.85rem; background: transparent; border: none;">
                    </div>
                </div>

                <div class="form-row" style="display: grid; grid-template-columns: 100px 1fr; align-items: start; gap: 10px;">
                    <label style="color:#ddd; font-size: 1rem; text-align: right; margin-top: 8px;">Descrição:</label>
                    <textarea name="description" rows="3" placeholder="Informações sobre o produto" required 
                              style="width:100%; padding:10px; background:#4f4f4f; border:none; border-radius:4px; color:white; font-style: italic; resize: none; font-size: 0.9rem;"></textarea>
                </div>
            </div>

            <button type="submit" 
                    style="width:100%; margin-top:25px; padding:12px; background:#D81B60; color:white; border:none; font-weight:bold; font-size: 1rem; border-radius:6px; cursor:pointer; transition: background 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.2);">
                Criar Anúncio!
            </button>
        </form>
    </div>
</div>
    </main>

    <!-- Script para abrir/fechar o modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('productModal');
            const openModalBtn = document.getElementById('openModalButton');
            const closeBtn = modal.querySelector('.modal-close-btn');

            function openModal() { modal.style.display = 'flex'; }
            function closeModal() { modal.style.display = 'none'; }

            if (openModalBtn) openModalBtn.addEventListener('click', openModal);
            if (closeBtn) closeBtn.addEventListener('click', closeModal);

            window.onclick = function(event) {
                if (event.target == modal) closeModal();
            }
        });
    </script>
</body>
</html>