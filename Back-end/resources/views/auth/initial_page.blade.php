<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sua Jornada - Loja</title>
    <link rel="stylesheet" href="../assets/css/estiloMain.css">
    <link rel="stylesheet" href="../components/atoms/button.css"> <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../components/atoms/input.css">
    <link rel="stylesheet" href="../components/atoms/label.css">
    <link rel="stylesheet" href="../components/molecules/form-group.css">
    <link rel="stylesheet" href="../components/molecules/product-card.css">
    <link rel="stylesheet" href="../components/organisms/footer.css">
    <link rel="stylesheet" href="../components/organisms/header.css">
    <link rel="stylesheet" href="../components/organisms/product-grid.css">
</head>
<body>

    <header class="header">
        <nav class="navbar">
            <div class="navbar-content">
                <div class="logo">
                    <img src="../assets/img/logoDaora.png" alt="Logo Ta Na Mesa">
                </div>
                <ul class="nav-links">
                    <li><a href="#">Suas mesas</a></li>
                    <li><a href="#">Mesas</a></li>
                    <li><a href="#">Cadastro de mesas</a></li>
                    <li><a href="#" class="active-link">Loja</a></li>
                </ul>
                <div class="user-actions">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/img/user-icon.png') }}" alt="Perfil do usuário"></a>
                    <a href="#"><img src="../assets/img/Shopping cart.png" alt="Carrinho de compras"></a>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <section class="hero-banner">
            <div class="banner-image">
                <img src="../assets/img/Banner inicial.png" alt="Banner com personagens de RPG">
                <h1 class="banner-title">Monte a sua nova<br>jornada aqui!</h1>
            </div>

            <div class="scroll-down-container">
                <a href="#store-section" class="scroll-down-button">
                    <img src="../assets/img/botao.png" alt="Scroll para baixo">
                </a>
            </div>

            <section id="store-section" class="store">
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
            <button class="btn-reset-group">Resetar</button>
        </div>
    </div>
    <div class="filter-group">
        <label for="sistema">Sistema:</label>
        <div class="input-container">
            <select id="sistema"></select>
            <button class="btn-reset-group">Resetar</button>
        </div>
    </div>
    <div class="filter-group">
        <label for="localizacao">Localização:</label>
        <div class="input-container">
            <select id="localizacao"></select>
            <button class="btn-reset-group">Resetar</button>
        </div>
    </div>
</div>
                    <div class="filter-category">
    <label>Categoria:</label>
    <div class="category-buttons">
        <button type="button" class="btn-category active" onclick="selectCategory(this)">Todos</button>
        
        <button type="button" class="btn-category" onclick="selectCategory(this)">Para sua mesa</button>
        <button type="button" class="btn-category" onclick="selectCategory(this)">Vestir</button>
        <button type="button" class="btn-category" onclick="selectCategory(this)">Ler</button>
        <button type="button" class="btn-category" onclick="selectCategory(this)">Decoração</button>
    </div>
</div>
                </div>
            </section>
        </section>

        <div class="product-grid">
    @foreach($products as $product)
        <div class="product-card">
            <div class="card-header">
                <img src="{{ asset('storage/' . $product->image1) }}" alt="{{ $product->name }}" class="product-image">
            </div>
            
            <button class="favorite-btn" aria-label="Adicionar aos favoritos">
                <img src="{{ asset('assets/img/coracaoBotao.png') }}" alt="Favoritar" class="heart-img">
            </button>

            <h3 class="product-title">{{ $product->name }}</h3>

            <p class="product-description">{{ Str::limit($product->description, 50) }}</p>

            <span class="product-price">R$ {{ number_format($product->price, 2, ',', '.') }}</span>

            <button class="buy-button">COMPRAR</button>
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
    .btn-category {
        background-color: transparent; 
        border: 1px solid #ccc; 
        color: #ccc; 
        padding: 8px 16px;
        border-radius: 20px; 
        cursor: pointer;
        transition: all 0.3s ease; 
    }

    .btn-category:hover {
        background-color: rgba(255, 255, 255, 0.2); 
        border-color: #fff;
        color: #fff;
    }

    .btn-category.active {
        background-color: #fff !important; 
        color: #000 !important;
        border-color: #fff !important;
        font-weight: bold;
    }
</style>

<script>
    function selectCategory(selectedButton) {
        const buttons = document.querySelectorAll('.btn-category');
        
        buttons.forEach(btn => btn.classList.remove('active'));
        
        selectedButton.classList.add('active');
        
        console.log("Categoria selecionada: " + selectedButton.innerText);
    }
</script>

</body>
</html>
