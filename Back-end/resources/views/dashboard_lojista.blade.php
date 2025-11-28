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
        /* Ajustes para o filtro ficar alinhado */
        .filter-row {
            display: flex;
            gap: 15px;
            align-items: flex-end;
            margin-top: 15px;
            flex-wrap: wrap;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .input-container select, .input-container input {
            padding: 8px;
            border-radius: 5px;
            border: none;
            background-color: #fff;
            color: #000;
            min-width: 150px;
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

                    <form method="POST" action="{{ route('logout') }}" style="display: inline; margin-left: 15px;">
                        @csrf
                        <button type="submit" style="background:none; border:none; cursor:pointer; font-family:inherit; font-size:inherit; color:white; text-decoration:none;">
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
                
                <section id="profile-seller-infos" class="seller-infos">
                    <h2>Suas informações</h2>
                    <div class="seller-info-content">
                        <div class="seller-photo">
                            @if(Auth::user()->imagemPerfil)
                                <img src="{{ asset('storage/' . Auth::user()->imagemPerfil) }}" alt="Foto do vendedor" style="width: 180px; height: 180px; object-fit: cover; border-radius: 50%; border: 4px solid #ffff;">
                            @else
                                <img src="{{ asset('assets/img/gatoMago.jpg') }}" alt="Foto do vendedor" style="width: 180px; height: 180px; object-fit: cover; border-radius: 50%; border: 4px solid #CD004A;">
                            @endif
                        </div>
                        
                        <div class="seller-fields">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('patch') 
                                <div class="field-row">
                                    <label>Foto de perfil:</label>
                                    <div class="input-upload-container">
                                        <input type="file" id="profile-upload" name="imagemPerfil" style="display: none;" onchange="this.form.submit()"> 
                                        <button type="button" class="btn-upload" onclick="document.getElementById('profile-upload').click()">
                                            FAÇA O UPLOAD
                                        </button>
                                    </div>
                                </div>

                                <div class="field-row">
                                    <label>Nome:</label>
                                    <input type="text" name="name" value="{{ Auth::user()->name }}">
                                </div>

                                <div class="field-row">
                                    <label>E-mail:</label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}">
                                </div>

                                <div class="seller-save-btn">
                                    <button type="submit" class="btn-primary">Salvar Alterações</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>

                <section id="seller-salesAds" class="seller-ads">
                    <h2 class="sellers-title">Seus anúncios</h2>

                    <form method="GET" action="{{ route('dashboard') }}" class="filter-bar">
                        <div class="filter-header">
                            <p class="filter-title">Filtro</p>
                            <div class="filter-actions">
                                <a href="{{ route('dashboard') }}" class="btn-reset" style="text-decoration: none; color: inherit; display: flex; align-items: center;">Resetar</a>
                                <button type="submit" class="btn-apply">Aplicar</button>
                            </div>
                        </div>
                        <div class="filter-line"></div>
                        
                        <div class="filter-row">
                            <div class="filter-group">
                                <label for="data">Data:</label>
                                <div class="input-container">
                                    <input type="date" id="data" name="date" value="{{ request('date') }}">
                                </div>
                            </div>

                            <div class="filter-group">
                                <label for="search">Nome:</label>
                                <div class="input-container">
                                    <input type="text" id="search" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                                </div>
                            </div>

                            <div class="filter-group">
                                <label for="category_id">Categoria:</label>
                                <div class="input-container">
                                    <select id="category_id" name="category_id">
                                        <option value="all">Todas</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

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
                                            onclick="openEditModal(
                                                '{{ $product->id }}', 
                                                '{{ $product->name }}', 
                                                '{{ $product->price }}', 
                                                '{{ $product->units }}', 
                                                '{{ $product->category_id }}', 
                                                '{{ $product->description }}'
                                            )"
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
                        @empty
                            <p style="color: white; grid-column: 1/-1; text-align: center; padding: 20px;">Você ainda não possui anúncios.</p>
                        @endforelse
                    </div>

                    <button class="btn-ads" id="openModalButton">Adicionar novo anúncio</button>
                </section>
            </section>
        </section>

        <div id="productModal" class="modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:1000; justify-content:center; align-items:center; backdrop-filter: blur(4px);">
            <div class="modal-content" style="background:#0f0f0f; padding:30px 40px; border-radius:8px; width:480px; max-width:95%; position:relative; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                
                <button class="modal-close-btn" style="position:absolute; top:-15px; right:-15px; background:#D81B60; width:45px; height:45px; border-radius:50%; border:none; color:white; font-size:1.8rem; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">&times;</button>
                
                <div style="text-align:center; margin-bottom:25px; border-bottom: 1px solid #333; padding-bottom: 15px;">
                    <h2 id="modalTitle" style="color:white; font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 400; letter-spacing: 0.5px;">
                        Insira informações sobre o produto
                    </h2>
                </div>

                <form id="modalForm" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-form-grid" style="display:flex; flex-direction:column; gap:12px;">
                        
                        <div class="form-row" style="display: grid; grid-template-columns: 100px 1fr; align-items: center; gap: 10px;">
                            <label style="color:#ddd; font-size: 1rem; text-align: right;">Nome:</label>
                            <input type="text" id="modal-nome" name="name" placeholder="Nome do produto" required 
                                   style="width:100%; height: 35px; padding:0 10px; background:#4f4f4f; border:none; border-radius:4px; color:white; font-style: italic; font-size: 0.9rem;">
                        </div>

                        <div class="form-row" style="display: grid; grid-template-columns: 100px 1fr; align-items: center; gap: 10px;">
                            <label style="color:#ddd; font-size: 1rem; text-align: right;">Preço:</label>
                            <input type="number" id="modal-preco" name="price" step="0.01" placeholder="Digite o valor em R$" required 
                                   style="width:100%; height: 35px; padding:0 10px; background:#4f4f4f; border:none; border-radius:4px; color:white; font-style: italic; font-size: 0.9rem;">
                        </div>

                        <div class="form-row" style="display: grid; grid-template-columns: 100px 1fr; align-items: center; gap: 10px;">
                            <label style="color:#ddd; font-size: 1rem; text-align: right;">Quantidade:</label>
                            <input type="number" id="modal-qtd" name="units" placeholder="Quantidade em estoque" required 
                                   style="width:100%; height: 35px; padding:0 10px; background:#4f4f4f; border:none; border-radius:4px; color:white; font-style: italic; font-size: 0.9rem;">
                        </div>

                        <div class="form-row" style="display: grid; grid-template-columns: 100px 1fr; align-items: center; gap: 10px;">
                            <label style="color:#ddd; font-size: 1rem; text-align: right;">Categoria:</label>
                            <div style="position:relative; width: 100%;">
                                <select id="modal-categoria" name="category_id" required 
                                        style="width:100%; height: 35px; padding:0 10px; background:#4f4f4f; border:none; border-radius:4px; color:white; font-style: italic; appearance: none; cursor:pointer; font-size: 0.9rem;">
                                    <option value="" disabled selected>Escolher categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span style="position:absolute; right:10px; top:50%; transform:translateY(-50%); color:white; pointer-events:none; font-size: 0.8rem;">&#9660;</span>
                            </div>
                        </div>

                        <div class="form-row" style="display: grid; grid-template-columns: 100px 1fr; align-items: center; gap: 10px;">
                            <label style="color:#ddd; font-size: 1rem; text-align: right;">Foto:</label>
                            <div style="background:#4f4f4f; border-radius:4px; height: 35px; display: flex; align-items: center; padding-left: 5px; width: 100%;">
                                <input type="file" name="image1" id="modal-foto"
                                       style="width:100%; color:#aaa; font-size: 0.85rem; background: transparent; border: none;">
                            </div>
                        </div>

                        <div class="form-row" style="display: grid; grid-template-columns: 100px 1fr; align-items: start; gap: 10px;">
                            <label style="color:#ddd; font-size: 1rem; text-align: right; margin-top: 8px;">Descrição:</label>
                            <textarea id="modal-descricao" name="description" rows="3" placeholder="Informações sobre o produto" required 
                                      style="width:100%; padding:10px; background:#4f4f4f; border:none; border-radius:4px; color:white; font-style: italic; resize: none; font-size: 0.9rem;"></textarea>
                        </div>
                    </div>

                    <button type="submit" id="modalSubmitBtn"
                            style="width:100%; margin-top:25px; padding:12px; background:#D81B60; color:white; border:none; font-weight:bold; font-size: 1rem; border-radius:6px; cursor:pointer; transition: background 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.2);">
                        Criar Anúncio!
                    </button>
                </form>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; direitos reservados 2025</p>
            <p>Este site foi desenvolvido por Isabelle Matos, Laís Lívia, Luana Miyashiro, Maria Vivielle, Malu Araujo e Yasmin Carolina</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('productModal');
            const openModalBtn = document.getElementById('openModalButton');
            const closeBtn = modal.querySelector('.modal-close-btn');
            const form = document.getElementById('modalForm');
            const modalTitle = document.getElementById('modalTitle');
            const submitBtn = document.getElementById('modalSubmitBtn');

            // Função para abrir o modal em modo CRIAÇÃO
            if (openModalBtn) {
                openModalBtn.addEventListener('click', function() {
                    form.reset(); // Limpa o formulário
                    form.action = "{{ route('product.store') }}"; // Rota de criar
                    modalTitle.innerText = "Insira informações sobre o produto";
                    submitBtn.innerText = "Criar Anúncio!";
                    
                    // Remove input _method se existir (usado apenas no update)
                    const methodInput = form.querySelector('input[name="_method"]');
                    if (methodInput) methodInput.remove();
                    
                    // Torna a foto obrigatória na criação
                    document.getElementById('modal-foto').required = true;

                    modal.style.display = 'flex';
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        });

        // Função global para abrir o modal em modo EDIÇÃO (chamada pelos botões nos cards)
        function openEditModal(id, name, price, units, categoryId, description) {
            const modal = document.getElementById('productModal');
            const form = document.getElementById('modalForm');
            const modalTitle = document.getElementById('modalTitle');
            const submitBtn = document.getElementById('modalSubmitBtn');

            // Preenche os campos
            document.getElementById('modal-nome').value = name;
            document.getElementById('modal-preco').value = price;
            document.getElementById('modal-qtd').value = units;
            document.getElementById('modal-descricao').value = description;
            
            // Seleciona a categoria
            const categorySelect = document.getElementById('modal-categoria');
            if(categorySelect) categorySelect.value = categoryId;

            // Configura para EDIÇÃO
            form.action = `/product/${id}`; // Rota de update
            modalTitle.innerText = "Editar Produto";
            submitBtn.innerText = "Salvar Alterações";

            // Adiciona o input hidden _method = PUT para o Laravel entender que é update
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
            }

            // Na edição, a foto não é obrigatória
            document.getElementById('modal-foto').required = false;

            modal.style.display = 'flex';
        }
    </script>
</body>
</html>