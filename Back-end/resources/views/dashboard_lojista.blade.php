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
                    <div class="carrinho hidden " >
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
                <h1 class="banner-title-seller">Seu perfil - Lojista</h1>
            </div>

            <section id="store-section" class="store">
                
                <section id="profile-seller-infos" class="seller-infos">
                    <h2>Suas informações</h2>
                    <div class="seller-info-content">
                        <div class="seller-photo">
                            @if(Auth::user()->imagemPerfil)
                                <img src="{{ Str::startsWith(Auth::user()->imagemPerfil, 'assets') ? asset(Auth::user()->imagemPerfil) : asset('storage/' . Auth::user()->imagemPerfil) }}" 
                                     alt="Foto do vendedor" 
                                     style="width: 180px; height: 180px; object-fit: cover; border-radius: 50%; border: 4px solid #ffff;">
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
                               {{-- 
                                <div class="field-row">
                                    <label>CEP:</label>
                                    <input type="text" name="cep" value="{{ Auth::user()->cep }}">
                                </div>
                                <div class="field-row">
                                    <label>E-mail:</label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}">
                                </div> --}}
                                <div class="seller-save-btn">
                                    <button type="submit" class="btn-primary">Salvar Alterações</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>

                <section id="seller-salesAds" class="seller-ads">
                    <h2 class="sellers-title">Seus anúncios</h2>

                    <form method="GET" action="{{ route('dashboard') }}" class="filter-bar-modern">
                        <div class="filter-header-modern">
                            <div style="display: flex; align-items: center;">
                                <span class="filter-icon" style="font-size: 1.5rem; margin-right: 10px;"></span>
                                <h3 class="filter-title-modern" style="margin: 0;">Filtro</h3>
                            </div>
                            <div class="filter-actions-modern">
                                <a href="{{ route('dashboard') }}" class="btn-reset-modern">Resetar</a>
                                <button type="submit" class="btn-apply-modern">Aplicar</button>
                            </div>
                        </div>
                        
                        <div class="filter-content-modern">
                            <div class="filter-group-modern">
                                <label for="data">Data:</label>
                                <input type="date" id="data" name="date" class="filter-select-modern" 
                                       value="{{ request('date') }}"
                                       style="background: white; color: black;">
                            </div>

                            <div class="filter-divider"></div>

                            <div class="filter-group-modern">
                                <label for="search">Nome:</label>
                                <input type="text" id="search" name="search" class="filter-input-modern" 
                                       placeholder="Buscar..." 
                                       value="{{ request('search') }}">
                            </div>

                            <div class="filter-divider"></div>

                            <div class="filter-group-modern">
                                <label for="category_id">Categoria:</label>
                                <select id="category_id" name="category_id" class="filter-select-modern">
                                    <option value="all">Todas</option>
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

                    <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; width: 100%; margin-top: 20px;">
                        @forelse($products as $product)
                            <div class="product-card" style="background-color: #000; border: 1px solid #333; padding: 15px; border-radius: 10px; display:flex; flex-direction:column; align-items:center;">
                                
                                <div class="product-image" style="width:100%; height:200px; margin-bottom:10px; overflow: hidden;">
                                    <img src="{{ Str::startsWith($product->image1, ['http', 'https']) ? $product->image1 : (Str::startsWith($product->image1, 'assets') ? asset($product->image1) : asset('storage/' . $product->image1)) }}" 
                                         alt="{{ $product->name }}" 
                                         style="width:100%; height:100%; object-fit:cover; border-radius:5px;"
                                         onerror="this.onerror=null;this.src='{{ asset('assets/img/iconeMago.png') }}';">
                                </div>

                                <h3 style="color:white; margin-bottom:5px;">{{ $product->name }}</h3>
                                <p class="price" style="color:#e85d04; font-weight:bold;">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                                
                                <div style="display:flex; gap:10px; width:100%; margin-top:10px;">
                                    <button type="button" 
                                            onclick="openEditModal(
                                                '{{ $product->id }}', 
                                                '{{ addslashes($product->name) }}', 
                                                '{{ $product->price }}', 
                                                '{{ $product->units }}', 
                                                '{{ $product->category_id }}', 
                                                '{{ $product->image1 }}', 
                                                '{{ addslashes($product->description) }}'
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

                    <button class="btn-ads" id="openModalButton" style="margin-top: 30px;">Adicionar novo anúncio</button>
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

                <form id="modalForm" action="{{ route('product.store') }}" method="POST">
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
                                    @if(isset($categories) && count($categories) > 0)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>Nenhuma categoria cadastrada!</option>
                                    @endif
                                </select>
                                <span style="position:absolute; right:10px; top:50%; transform:translateY(-50%); color:white; pointer-events:none; font-size: 0.8rem;">&#9660;</span>
                            </div>
                        </div>

                        <div class="form-row" style="display: grid; grid-template-columns: 100px 1fr; align-items: center; gap: 10px;">
                            <label style="color:#ddd; font-size: 1rem; text-align: right;">Link Foto:</label>
                            <div style="background:#4f4f4f; border-radius:4px; height: 35px; display: flex; align-items: center; padding-left: 5px; width: 100%;">
                                <input type="url" name="image1" id="modal-foto" placeholder="Cole o link da imagem (https://...)" required
                                       style="width:100%; color:white; font-size: 0.85rem; background: transparent; border: none; padding: 0 5px;">
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

            if (openModalBtn) {
                openModalBtn.addEventListener('click', function() {
                    form.reset(); 
                    form.action = "{{ route('product.store') }}"; 
                    modalTitle.innerText = "Insira informações sobre o produto";
                    submitBtn.innerText = "Criar Anúncio!";
                    
                    const methodInput = form.querySelector('input[name="_method"]');
                    if (methodInput) methodInput.remove();
                    
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

        function openEditModal(id, name, price, units, categoryId, image1, description) {
            const modal = document.getElementById('productModal');
            const form = document.getElementById('modalForm');
            const modalTitle = document.getElementById('modalTitle');
            const submitBtn = document.getElementById('modalSubmitBtn');

            document.getElementById('modal-nome').value = name;
            document.getElementById('modal-preco').value = price;
            document.getElementById('modal-qtd').value = units;
            document.getElementById('modal-descricao').value = description;
            document.getElementById('modal-foto').value = image1;

            const categorySelect = document.getElementById('modal-categoria');
            if(categorySelect) categorySelect.value = categoryId;

            form.action = `/product/${id}`; 
            modalTitle.innerText = "Editar Produto";
            submitBtn.innerText = "Salvar Alterações";

            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
            }

            modal.style.display = 'flex';
        }
    </script>

    <style>
        * { box-sizing: border-box; }

        .filter-bar-modern { 
            background-color: #2a2a2a; 
            border-radius: 10px; 
            padding: 20px; 
            margin-bottom: 30px; 
            width: 100%; 
            border: 1px solid #444; 
        }

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
            height: 40px; 
        }
        
        .btn-reset-modern { background-color: transparent; border: 1px solid #666; color: #ccc; }
        .btn-reset-modern:hover { background-color: #444; color: white; }
        .btn-apply-modern { background-color: #CD004A; color: white; }
        .btn-apply-modern:hover { background-color: #a0003a; }

        .filter-content-modern { 
            display: flex; 
            gap: 20px; 
            align-items: flex-end; 
            margin-bottom: 0; 
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

        .filter-select-modern, .filter-input-modern { 
            width: 100%; 
            height: 45px; 
            padding: 0 15px; 
            border-radius: 5px; 
            border: 1px solid #555; 
            background-color: white; 
            color: #000; 
            font-size: 1rem;
            outline: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        select.filter-select-modern {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='black' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 15px;
            padding-right: 40px; 
            cursor: pointer;
        }

        .filter-input-modern::placeholder { color: #666; }

        .filter-divider { 
            width: 1px; 
            height: 45px; 
            background-color: #555; 
            display: none; 
        }

        @media(min-width: 768px) { .filter-divider { display: block; } }
    </style>
</body>
</html>
