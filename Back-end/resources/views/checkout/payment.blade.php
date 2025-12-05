<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento - Checkout</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/estiloPagamento.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/header.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('components/organisms/checkout-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/order-summary.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/form-group.css') }}">
    <link rel="stylesheet" href="{{ asset('components/molecules/shipping.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/button.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/input.css') }}">
    <link rel="stylesheet" href="{{ asset('components/atoms/label.css') }}">
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
                    <div class="carrinho hidden" >
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
        <div class="main-container">
            <div class="caminho">
                <h3>
                    <a href="{{ route('initial') }}" style="color: inherit; text-decoration: none;">Home</a> > 
                    <a href="{{ route('cart.index') }}" style="color: inherit; text-decoration: none;">Carrinho de Compras</a> > 
                    <a href="{{ route('checkout.personalInfo') }}" style="color: inherit; text-decoration: none;">Informações Pessoais</a> > 
                    Métodos de pagamento
                </h3>
            </div>

            @if(session('success'))
                <div style="background-color: #28a745; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('checkout.finalize') }}" method="POST">
                @csrf
                <div class="checkout-container">
                    <!-- Coluna de envio e resumo -->
                    <div class="personal-info-column">
                        <h4>Formas de envio</h4>

                        <div class="shipping-address-box">
                            <h5>Seu endereço de entrega</h5>
                            <p>
                                {{ $user->logradouro }}{{ $user->numero ? ', nº ' . $user->numero : '' }}<br>
                                {{ $user->cidade }} - {{ $user->estado }}<br>
                                CEP: {{ $user->cep ? substr($user->cep, 0, 5) . '-' . substr($user->cep, 5) : '' }}
                            </p>
                            <a href="{{ route('checkout.personalInfo') }}">Editar endereço</a>
                        </div>

                        <h5 class="shipping-title">Selecione uma forma de envio:</h5>

                        <ul class="shipping-options-list">
                            <li class="shipping-option-item">
                                <input type="radio" name="envio" id="correios" value="correios" data-price="10.20" checked>
                                <label for="correios">
                                    <strong>Correios</strong>
                                    <span>Entrega estimada em 5 dias úteis</span>
                                </label>
                                <span class="shipping-price">R$ 10,20</span>
                            </li>

                            <li class="shipping-option-item">
                                <input type="radio" name="envio" id="jadlog" value="jadlog" data-price="15.25">
                                <label for="jadlog">
                                    <strong>Jadlog</strong>
                                    <span>Entrega estimada em 5 dias úteis</span>
                                </label>
                                <span class="shipping-price">R$ 15,25</span>
                            </li>

                            <li class="shipping-option-item">
                                <input type="radio" name="envio" id="sedex" value="sedex" data-price="50.40">
                                <label for="sedex">
                                    <strong>SEDEX</strong>
                                    <span>Entrega estimada em 1 dia útil</span>
                                </label>
                                <span class="shipping-price">R$ 50,40</span>
                            </li>
                        </ul>

                        <div class="order-summary" style="position: static; top: 0;">
                            <h4>Resumo do pedido</h4>
                            <div class="summary-line">
                                <span>Subtotal</span>
                                <span id="subtotal-display">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                            </div>
                            <div class="summary-line">
                                <span>Frete</span>
                                <span id="frete-display"></span>
                            </div>
                            <div class="summary-total">
                                <span>Total do pedido</span>
                                <span id="total-display"></span>
                            </div>
                            <p class="summary-installments" id="installments-info"></p>
                        </div>
                    </div>

                    <div class="address-info-column">
                        <h4>Métodos de pagamento</h4>

                        <div class="payment-methods">
                            <div class="payment-tab-buttons">
                                <button type="button" class="payment-tab-btn active" data-tab="pix">PIX - 3% DE DESCONTO</button>
                                <button type="button" class="payment-tab-btn" data-tab="cartao">CARTÃO</button>
                                <button type="button" class="payment-tab-btn" data-tab="boleto">BOLETO</button>
                            </div>

                            <input type="hidden" name="payment_method" id="payment-method-input" value="pix">

                            <div class="payment-tab-content active" id="pix-content">
                                <p>Pagamento confirmado em até 10 minutos.</p>
                                <div class="pix-buttons">
                                    <button type="button" class="buy-button" style="flex: 1;" id="generate-qr-btn">Gerar QR CODE</button>
                                    <button type="button" class="buy-button" style="flex: 1;" id="copy-qr-btn">Copiar código</button>
                                </div>
                                <img src="{{ asset('assets/img/qrcode.png') }}" id="pix-qrcode" style="display: none; margin-top: 15px; max-width: 200px;">
                            </div>

                            <div class="payment-tab-content" id="cartao-content">
                                <p>Pagamento confirmado em até 2h.</p>
                                <div class="form-group">
                                    <label for="card-number" class="label-dark">Informe o número do cartão:</label>
                                    <input type="text" id="card-number" placeholder="0000 0000 0000 0000" class="input-dark" maxlength="19">
                                </div>
                                <div class="card-form-grid">
                                    <div class="form-group">
                                        <label for="card-expiry" class="label-dark">Vencimento:</label>
                                        <input type="text" id="card-expiry" placeholder="MM/AAAA" class="input-dark" maxlength="7">
                                    </div>
                                    <div class="form-group">
                                        <label for="card-cvv" class="label-dark">CVV:</label>
                                        <input type="text" id="card-cvv" placeholder="000" class="input-dark" maxlength="3">
                                    </div>
                                </div>
                                <a href="#" class="payment-conditions-link">Clique para ver as condições de parcelamento</a>
                            </div>

                            <div class="payment-tab-content" id="boleto-content">
                                <p>Pagamento confirmado em até 3 dias úteis.</p>
                            </div>
                        </div>

                        <h4>Aplicar cupom de desconto</h4>
                        <div class="coupon-form">
                            <input type="text" id="coupon-input" placeholder="Digite seu cupom" class="input-dark" style="text-transform: uppercase;">
                            <button type="button" class="buy-button" onclick="applyCoupon()">APLICAR</button>
                        </div>
                        <p class="coupon-success" id="coupon-message" style="display: none;"></p>

                        <h4>Detalhes de Pagamento</h4>
                        <div class="payment-details-placeholder">
                            <div><span>Total dos produtos</span><span id="products-total">R$ {{ number_format($subtotal, 2, ',', '.') }}</span></div>
                            <div><span>Total do frete</span><span id="shipping-total"></span></div>
                            <div><span>Parcelas</span><span id="installments">5x de R$ 0,00</span></div>
                            <div><span>Desconto forma de pagamento</span><span id="payment-discount">R$ 0,00</span></div>
                            <div><span>Cupom aplicado</span><span id="coupon-discount">R$ 0,00</span></div>
                            <div class="total"><span>Pagamento total</span><span id="final-total">R$ 0,00</span></div>
                        </div>

                        <button type="submit" class="buy-button" style="width: 100%; margin-top: 20px;">Finalizar compra</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; direitos reservados 2025</p>
            <p>Este site foi desenvolvido por Isabelle Matos, Laís Lívia, Luana Miyashiro, Maria Vivielle, Malu Araujo, Yasmin Carolina</p>
        </div>
    </footer>

    <script>
        const subtotal = {{ $subtotal }};
        let shippingCost = 10.20;
        let paymentDiscount = 0;
        let couponDiscount = 0;

        if (subtotal >= 100) {
            shippingCost = 0;
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateTotals();

            const tabButtons = document.querySelectorAll('.payment-tab-btn');
            const tabContents = document.querySelectorAll('.payment-tab-content');
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    button.classList.add('active');
                    const tabId = button.getAttribute('data-tab');
                    document.getElementById(tabId + '-content').classList.add('active');
                    document.getElementById('payment-method-input').value = tabId;

                    paymentDiscount = (tabId === 'pix') ? (subtotal + shippingCost) * 0.03 : 0;
                    updateTotals();
                });
            });

            document.querySelectorAll('input[name="envio"]').forEach(radio => {
                radio.addEventListener('change', (e) => {
                    shippingCost = parseFloat(e.target.dataset.price);
                    if (subtotal >= 100) shippingCost = 0; // frete grátis
                    updateTotals();
                });
            });

            document.getElementById('card-number')?.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                let formatted = value.match(/.{1,4}/g)?.join(' ') || value;
                e.target.value = formatted;
            });
            document.getElementById('card-expiry')?.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 2) value = value.substring(0,2)+'/'+value.substring(2,6);
                e.target.value = value;
            });

            paymentDiscount = (subtotal + shippingCost) * 0.03;
            updateTotals();

            const qrBtn = document.getElementById('generate-qr-btn');
            const qrImg = document.getElementById('pix-qrcode');
            qrBtn.addEventListener('click', () => {
                if (qrImg.style.display === 'none' || qrImg.style.display === '') {
                    qrImg.style.display = 'block';
                    qrBtn.textContent = 'Ocultar QR CODE';
                } else {
                    qrImg.style.display = 'none';
                    qrBtn.textContent = 'Gerar QR CODE';
                }
            });
            const copyBtn = document.getElementById('copy-qr-btn');
            copyBtn.addEventListener('click', () => {
                navigator.clipboard.writeText(qrImg.src).then(() => alert('Obrigada por testar nosso PI <3'));
            });
        });

        function updateTotals() {
            const total = subtotal + shippingCost - paymentDiscount - couponDiscount;
            document.getElementById('frete-display').textContent = 'R$ ' + shippingCost.toFixed(2).replace('.', ',');
            document.getElementById('shipping-total').textContent = 'R$ ' + shippingCost.toFixed(2).replace('.', ',');
            document.getElementById('payment-discount').textContent = 'R$ ' + paymentDiscount.toFixed(2).replace('.', ',');
            document.getElementById('coupon-discount').textContent = 'R$ ' + couponDiscount.toFixed(2).replace('.', ',');
            document.getElementById('total-display').textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
            document.getElementById('final-total').textContent = 'R$ ' + total.toFixed(2).replace('.', ',');

            const pixPrice = total;
            const installmentPrice = total / 5;
            document.getElementById('installments-info').innerHTML = 
                'R$ ' + pixPrice.toFixed(2).replace('.', ',') + ' no pix com desconto<br>' +
                'Ou 5x de R$ ' + installmentPrice.toFixed(2).replace('.', ',') + ' no cartão';
            document.getElementById('installments').textContent = '5x de R$ ' + installmentPrice.toFixed(2).replace('.', ',');
        }

        function applyCoupon() {
            const couponInput = document.getElementById('coupon-input');
            const couponMessage = document.getElementById('coupon-message');
            const coupon = couponInput.value.toUpperCase();

            if (coupon === 'KITTYDEVS') {
                couponDiscount = (subtotal + shippingCost) * 0.15;
                couponMessage.textContent = 'Cupom aplicado com sucesso! 15% OFF';
                couponMessage.style.display = 'block';
                couponMessage.style.color = '#4CAF50';
                updateTotals();
            } else if (coupon === '') {
                couponMessage.textContent = 'Digite um cupom válido';
                couponMessage.style.display = 'block';
                couponMessage.style.color = '#dc3545';
            } else {
                couponMessage.textContent = 'Cupom inválido';
                couponMessage.style.display = 'block';
                couponMessage.style.color = '#dc3545';
            }
        }
    </script>

    <style>
        .payment-tab-btn {
            flex: 1;
            padding: 12px 20px;
            background-color: transparent;
            border: none;
            border-bottom: 2px solid transparent;
            color: var(--gray-text);
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-tab-btn.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .payment-tab-btn:hover {
            color: var(--light-text);
        }

        .pix-buttons button {
            padding: 10px 20px;
        }
    </style>
</body>
</html>
