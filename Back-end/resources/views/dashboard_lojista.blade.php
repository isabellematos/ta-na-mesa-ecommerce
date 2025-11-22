<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu perfil - Lojista</title>

    <link rel="stylesheet" href="{{asset('assets/css/estiloMain.css') }}">
    <link rel="stylesheet" href="{{asset('components/atoms/button.css') }}">
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
</head>

<body>

    <header class="header">
        <nav class="navbar">
            <div class="navbar-content">
                <div class="logo">
                    <img src="{{asset('assets/img/logoDaora.png') }}" alt="Logo Ta Na Mesa">
                </div>
                <div class="user-actions">
                    <a href="#"><img src="{{'assets/img/gatoMago.jpg'}}" alt="Perfil do usuário"></a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="perfilLojista" style="background:none; border:none; cursor:pointer; font-family:inherit; font-size:inherit; color:inherit;">
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
                <img src="{{asset('assets/img/Bannerperfil.png') }}" alt="Banner com personagens de RPG">
                <h1 class="banner-title-seller">Seu perfil - Lojista</h1>
            </div>

            <section id="store-section" class="store">
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
                                    <input type="file" id="profile-upload" style="display: none;">
                                    <button type="button" class="btn-upload" onclick="document.getElementById('profile-upload').click()">FAÇA O UPLOAD</button>
                                </div>
                            </div>


                            <div class="field-row">
                                <label>Link para contato:</label>
                                <input type="url">
                            </div>

                            <div class="field-row">
                                <label>Breve descrição:</label>
                                <div class="textarea-wrapper">
                                    <textarea rows="3"></textarea>
                                </div>
                            </div>

                            <div class="seller-save-btn">
                                <button class="btn-primary">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </section>

                <section id="seller-salesAds" class="seller-ads">
                    <h2 class="sellers-title">Seus anúncios</h2>

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
                                <label for="sistema">Nome:</label>
                                <div class="input-container">
                                    <select id="sistema"></select>
                                    <button class="btn-reset-group">Resetar</button>
                                </div>
                            </div>
                            <div class="filter-group">
                                <label for="localizacao">Categoria:</label>
                                <div class="input-container">
                                    <select id="localizacao"></select>
                                    <button class="btn-reset-group">Resetar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn-ads" id="openModalButton">Adicionar novo anúncio</button>
                </section>
            </section>



            <!--MODAL-->

            <div id="productModal" class="modal-overlay">
                <div class="modal-content">
                    <button class="modal-close-btn">&times;</button>
                    <h2>Insira informações sobre o produto</h2>

                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-form-grid">
                            <label for="modal-nome">Nome:</label>
                            <input type="text" id="modal-nome" name="name" placeholder="Nome do produto" class="modal-input-textarea" required>


                            <label for="modal-preco">Preço:</label>
                            <input type="number" id="modal-preco" name="price" step="0.01" placeholder="R$ 0,00" class="modal-input-textarea" required>

                            <label for="modal-qtd">Quantidade:</label>
                            <input type="number" id="modal-qtd" name="units" class="modal-input" required>

                            <label for="modal-tags">Tags:</label>
                        <input type="text" id="modal-tags" placeholder="Ex: Miniaturas, DnD, MESA"
                            class="modal-input-textarea">

                            <label for="modal-categoria">Categoria:</label>
                            <select id="modal-categoria" name="category_id" class="modal-input" required>
                                <option value="1">Categoria Exemplo</option>
                            </select>

                            <label>Foto do produto:</label>
                            <input type="file" name="image1" class="modal-btn-upload" required>

                            <label for="modal-descricao">Descrição:</label>
                            <textarea id="modal-descricao" name="description" placeholder="Informações sobre o produto" class="modal-input-textarea" required></textarea>
                        </div>
                        <button type="submit" class="modal-btn-primary">Criar Anúncio!</button>
                    </form>


                </div>
            </div>
        </section>

 <!--Listagem de itens-->
            <table>
            <thead>
                <tr>
                    <th>name</th>
                    <th>price</th>
                    <th>units</th>
                    <th>image1</th>
                    <th>category_id</th>
                    <th>description</th>
                    <th>user_id</th>
                </tr>
            <thead>
            <tdoby>
            @foreach(\App\Models\Product::all() as $product)
                <tr>
                    <td>{{$product->name}} </td>
                    <td>{{$product->price}} </td>
                    <td>{{$product->units}} </td>
                    <td>{{$product->image1}} </td>
                    <td>{{$product->category_id}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->user_id}} </td>
                </tr>
            @endforeach
            </tdoby>
            </table>
    </main>

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