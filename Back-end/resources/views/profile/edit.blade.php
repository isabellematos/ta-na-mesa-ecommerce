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
    
    <style>
        .filter-bar-modern {
            background-color: #2a2a2a;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .filter-header-modern {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #444;
        }

        .filter-icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }

        .filter-title-modern {
            flex-grow: 1;
            margin: 0;
            font-size: 1.2rem;
            color: white;
        }

        .filter-actions-modern {
            display: flex;
            gap: 10px;
        }

        .btn-reset-modern, .btn-apply-modern {
            padding: 8px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-reset-modern {
            background-color: transparent;
            border: 1px solid #666;
            color: #ccc;
        }

        .btn-reset-modern:hover {
            background-color: #444;
            color: white;
        }

        .btn-apply-modern {
            background-color: white;
            color: #000;
        }

        .btn-apply-modern:hover {
            background-color: #f0f0f0;
        }

        .filter-content-modern {
            display: flex;
            gap: 20px;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-group-modern {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-group-modern label {
            color: white;
            font-weight: bold;
            white-space: nowrap;
        }

        .filter-select-modern, .filter-input-modern {
            padding: 8px 15px;
            border-radius: 5px;
            border: 1px solid #555;
            background-color: white;
            color: #000;
            min-width: 150px;
        }

        .filter-divider {
            width: 1px;
            height: 40px;
            background-color: #555;
        }

        .btn-reset-field {
            padding: 6px 12px;
            border-radius: 5px;
            border: none;
            background-color: transparent;
            color: #CD004A;
            cursor: pointer;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .btn-reset-field:hover {
            text-decoration: underline;
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
                        <img src="{{ $user->imagemPerfil ? asset('storage/' . $user->imagemPerfil).'?v='.time() : asset('assets/img/user-icon.png') }}" 
                             alt="Perfil do usuário" 
                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="perfilLojista" style="background: none; border: none; color: inherit; cursor: pointer; font: inherit;">
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
                <h1 class="banner-title-buyer">Seu perfil - Comprador</h1>
            </div>

            <div class="scroll-down-container">
                <a href="#store-section" class="scroll-down-button">
                    <img src="{{ asset('assets/img/botao.png') }}" alt="Scroll para baixo">
                </a>
            </div>

            <section id="store-section" class="store">
                @if(session('status') === 'profile-updated')
                    <div style="background-color: #28a745; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
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
                                     src="{{ $user->imagemPerfil ? asset('storage/' . $user->imagemPerfil).'?v='.time() : asset('assets/img/user-icon.png') }}" 
                                     alt="Foto do comprador"
                                     style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
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
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>

                                <div class="field-row">
                                    <label>Email:</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>

                                <div class="field-row">
                                    <label>Telefone:</label>
                                    <input type="text" name="telefone" value="{{ old('telefone', $user->telefone) }}">
                                </div>

                                <div class="buyer-save-btn">
                                    <button type="submit" class="btn-primary">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>

                <section id="buyer-salesAds" class="buyer-ads">
                    <section id="buyer-ItemsShopped" class="buyer-shopped">
                        @if(session('success'))
                            <div style="background-color: #28a745; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div style="background-color: #dc3545; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h2 style="color: #ffffffff; margin: 0;">Seus pedidos</h2>
                            <button class="btn-close-orders" style="background: none; border: none; color: #CD004A; font-size: 1.5rem; cursor: pointer;">▲ Fechar</button>
                        </div>

                        <div class="filter-bar-modern" style="margin-bottom: 30px;">
                            <div class="filter-header-modern">
                                <span class="filter-icon">🔍</span>
                                <h3 class="filter-title-modern">Filtrar</h3>
                                <div class="filter-actions-modern">
                                    <button type="button" class="btn-reset-modern">Resetar</button>
                                    <button type="button" class="btn-apply-modern">Aplicar</button>
                                </div>
                            </div>

                            <div class="filter-content-modern">
                                <div class="filter-group-modern">
                                    <label for="order-data">Data:</label>
                                    <select id="order-data" class="filter-select-modern">
                                        <option value="">Selecione</option>
                                        <option value="hoje">Hoje</option>
                                        <option value="semana">Esta semana</option>
                                        <option value="mes">Este mês</option>
                                    </select>
                                    <button type="button" class="btn-reset-field">Resetar</button>
                                </div>

                                <div class="filter-divider"></div>

                                <div class="filter-group-modern">
                                    <label for="order-nome">Nome:</label>
                                    <input type="text" id="order-nome" class="filter-input-modern" placeholder="Buscar pedido...">
                                    <button type="button" class="btn-reset-field">Resetar</button>
                                </div>

                                <div class="filter-divider"></div>

                                <div class="filter-group-modern">
                                    <label for="order-categoria">Categoria:</label>
                                    <select id="order-categoria" class="filter-select-modern">
                                        <option value="">Todas</option>
                                    </select>
                                    <button type="button" class="btn-reset-field">Resetar</button>
                                </div>
                            </div>
                        </div>

                        @if($orders->isEmpty())
                            <div style="text-align: center; padding: 40px; color: #ccc;">
                                <p>Você ainda não fez nenhum pedido.</p>
                                <a href="{{ route('initial') }}">
                                    <button class="buy-button" style="margin-top: 20px;">Ir para a loja</button>
                                </a>
                            </div>
                        @else
                            <div class="orders-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                                @foreach($orders as $order)
                                    <div class="order-card" style="background-color: #2a2a2a; border-radius: 10px; overflow: hidden; position: relative;">
                                        <div class="order-image" style="height: 200px; background-color: #fff; display: flex; align-items: center; justify-content: center; position: relative;">
                                            @if($order->items->first() && $order->items->first()->product)
                                                <img src="{{ asset('storage/' . $order->items->first()->product->image1) }}" 
                                                     alt="{{ $order->items->first()->product->name }}"
                                                     style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                            @else
                                                <span style="color: #999; font-size: 3rem;">📦</span>
                                            @endif
                                            <div class="order-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); padding: 20px; text-align: center;">
                                                <h3 style="color: white; margin: 0; font-size: 1rem; text-transform: uppercase;">
                                                    {{ $order->items->first()->product->name ?? 'Pedido #' . $order->id }}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="order-actions" style="padding: 15px; display: flex; gap: 10px;">
                                            <button class="btn-details" onclick="showOrderDetails({{ $order->id }})" style="flex: 1; padding: 10px; background-color: #0066cc; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                                                Detalhes
                                            </button>
                                            @if($order->status === 'pending')
                                                <button class="btn-cancel" onclick="showCancelModal({{ $order->id }})" style="flex: 1; padding: 10px; background-color: #CD004A; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                                                    Cancelar
                                                </button>
                                            @else
                                                <button class="btn-status" style="flex: 1; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                                                    Entregue
                                                </button>
                                            @endif
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

    <!-- Modal de Detalhes do Pedido -->
    <div id="details-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.9); z-index: 9999; justify-content: center; align-items: center; overflow-y: auto;">
        <div style="position: relative; background-color: #1a1a1a; border-radius: 20px; padding: 40px; max-width: 800px; width: 90%; margin: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);">
            <button onclick="closeDetailsModal()" style="position: absolute; top: -20px; right: -20px; width: 50px; height: 50px; border-radius: 50%; background-color: #CD004A; border: 3px solid white; color: white; font-size: 24px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                ✕
            </button>
            
            <h2 style="color: white; font-size: 2rem; margin: 0 0 30px 0; padding-bottom: 20px; border-bottom: 1px solid #444;">Detalhes do pedido</h2>
            
            <div id="order-details-content"></div>
        </div>
    </div>

    <!-- Modal de Confirmação de Cancelamento -->
    <div id="cancel-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 9999; justify-content: center; align-items: center;">
        <div style="position: relative; background: linear-gradient(135deg, #CD004A 0%, #8B0032 100%); border-radius: 20px; padding: 40px; max-width: 500px; text-align: center; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);">
            <button onclick="closeCancelModal()" style="position: absolute; top: -20px; right: -20px; width: 50px; height: 50px; border-radius: 50%; background-color: #CD004A; border: 3px solid white; color: white; font-size: 24px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                ✕
            </button>
            
            <h2 style="color: white; font-size: 2rem; margin: 0 0 20px 0; font-weight: bold;">Cancelar Pedido?</h2>
            
            <p style="color: white; font-size: 1.1rem; line-height: 1.6; margin: 20px 0;">
                Tem certeza que deseja cancelar este pedido?<br>
                Esta ação não pode ser desfeita.
            </p>
            
            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <button onclick="closeCancelModal()" style="flex: 1; padding: 15px; background-color: transparent; border: 2px solid white; color: white; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 1rem;">
                    Não, voltar
                </button>
                <form id="cancel-form" method="POST" style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width: 100%; padding: 15px; background-color: white; color: #CD004A; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 1rem;">
                        Sim, cancelar
                    </button>
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
            const orders = @json($orders);
            const order = orders.find(o => o.id === orderId);
            
            if (!order) return;

            const user = @json($user);
            const statusText = order.status === 'pending' ? 'A caminho' : 'Entregue';
            
            let itemsHtml = '';
            order.items.forEach(item => {
                itemsHtml += `
                    <div style="display: flex; gap: 20px; margin-top: 30px; padding: 20px; background-color: #2a2a2a; border-radius: 10px;">
                        <div style="flex-shrink: 0;">
                            <img src="/storage/${item.product.image1}" 
                                 alt="${item.product.name}"
                                 style="width: 150px; height: 150px; object-fit: contain; background-color: white; border-radius: 10px; padding: 10px;">
                        </div>
                        <div style="flex-grow: 1;">
                            <h3 style="color: #CD004A; margin: 0 0 15px 0; font-size: 1.5rem;">${item.product.name}</h3>
                            <p style="color: #ccc; margin: 10px 0; line-height: 1.6;">${item.product.description || 'Sem descrição'}</p>
                            <div style="margin-top: 15px; color: white;">
                                <p style="margin: 5px 0;"><strong>Quantidade:</strong> ${item.quantity}</p>
                                <p style="margin: 5px 0;"><strong>Preço unitário:</strong> R$ ${parseFloat(item.price).toFixed(2).replace('.', ',')}</p>
                                <p style="margin: 5px 0;"><strong>Subtotal:</strong> R$ ${(parseFloat(item.price) * item.quantity).toFixed(2).replace('.', ',')}</p>
                            </div>
                        </div>
                        <div style="text-align: right; color: white;">
                            <h4 style="margin: 0 0 10px 0;">Situação</h4>
                            <p style="color: #CD004A; font-weight: bold; font-size: 1.2rem; font-style: italic;">${statusText}</p>
                        </div>
                    </div>
                `;
            });

            const content = `
                <div style="color: white;">
                    <div style="margin-bottom: 30px;">
                        <h3 style="color: white; margin: 0 0 15px 0;">Enviar para</h3>
                        <p style="color: #ccc; margin: 5px 0;">${user.logradouro || 'Endereço não informado'}${user.numero ? ', N ' + user.numero : ''}</p>
                        <p style="color: #ccc; margin: 5px 0;">${user.cidade || ''} - ${user.estado || ''}</p>
                        <p style="color: #ccc; margin: 5px 0;">CEP ${user.cep ? user.cep.substring(0, 5) + '-' + user.cep.substring(5) : 'não informado'}</p>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <h3 style="color: white; margin: 0 0 15px 0;">Forma de Pagamento</h3>
                        <p style="color: #ccc; margin: 5px 0;"><strong>Método:</strong> ${order.payment_method.toUpperCase()}</p>
                        <p style="color: #ccc; margin: 5px 0;"><strong>Quantidade total:</strong> ${order.items.reduce((sum, item) => sum + item.quantity, 0)} item(ns)</p>
                        <p style="color: #ccc; margin: 5px 0;"><strong>Subtotal:</strong> R$ ${parseFloat(order.subtotal).toFixed(2).replace('.', ',')}</p>
                        <p style="color: #ccc; margin: 5px 0;"><strong>Frete:</strong> R$ ${parseFloat(order.shipping_cost).toFixed(2).replace('.', ',')}</p>
                        <p style="color: #CD004A; font-weight: bold; font-size: 1.2rem; margin: 10px 0;"><strong>Total:</strong> R$ ${parseFloat(order.total).toFixed(2).replace('.', ',')}</p>
                    </div>

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

        // Fechar modais ao clicar fora deles
        document.getElementById('cancel-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancelModal();
            }
        });

        document.getElementById('details-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailsModal();
            }
        });

        // Fechar modais com ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCancelModal();
                closeDetailsModal();
            }
        });
    </script>
</body>

</html>
