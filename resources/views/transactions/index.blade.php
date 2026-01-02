<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Pro - Toko Pakaian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f9;
            height: 100vh;
            overflow: hidden;
            font-family: 'Segoe UI', sans-serif;
        }

        .main-layout {
            height: 100vh;
            display: flex;
        }

        .product-section {
            flex: 1;
            overflow-y: hidden;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .cart-section {
            width: 400px;
            background: white;
            border-left: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.03);
        }

        .scroll-area {
            overflow-y: auto;
            padding-bottom: 80px;
            padding-right: 5px;
        }

        .product-card {
            border: none;
            background: white;
            border-radius: 15px;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #0d6efd;
        }

        .product-card.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background: #f8f9fa;
        }

        .product-img-wrapper {
            height: 120px;
            background: #eef2f7;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .stock-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            font-size: 0.75rem;
            padding: 3px 10px;
            border-radius: 20px;
            backdrop-filter: blur(4px);
        }

        .product-price {
            color: #0d6efd;
            font-weight: 800;
            font-size: 1.1rem;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .cart-footer {
            padding: 25px;
            background: #fff;
            border-top: 1px solid #eee;
            box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.03);
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #bbb;
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0">
        <div class="main-layout">

            <div class="product-section">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold text-dark mb-0"><i class="fas fa-store text-primary me-2"></i>Toko Pakaian</h4>
                        <small class="text-muted">Selamat Bekerja, {{ auth()->user()->name }}!</small>
                    </div>
                    <div>
                        <button type="button" class="btn btn-info btn-sm text-white me-2" data-bs-toggle="modal" data-bs-target="#historyModal">
                            <i class="fas fa-history"></i> Riwayat
                        </button>

                        @if(auth()->user()->role == 'admin')
                        <a href="{{ route('products.index') }}" class="btn btn-warning btn-sm text-white me-2">
                            <i class="fas fa-cogs"></i> Menu Admin
                        </a>
                        @endif

                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>

                <div class="input-group mb-4 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                    <span class="input-group-text bg-white border-0 ps-3"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="searchInput" class="form-control border-0 py-3" placeholder="Cari nama pakaian (Kemeja, Celana, dll)..." onkeyup="filterProduk()">
                </div>

                <div class="scroll-area row g-3" id="productGrid">
                    @foreach($products as $product)
                    @php $isDisplayOnly = $product->stock <= 1; @endphp

                        <div class="col-6 col-md-4 col-lg-3 product-item" data-name="{{ strtolower($product->name) }}">
                        <div class="product-card h-100 {{ $isDisplayOnly ? 'disabled' : '' }}"
                            onclick="{{ $isDisplayOnly ? "alert('Stok tinggal 1 (Display), tidak boleh dijual!')" : "addToCart($product->id, '$product->name', $product->price, $product->stock)" }}">

                            <div class="product-img-wrapper">
                                @if($isDisplayOnly)
                                <span class="badge bg-danger position-absolute top-50 start-50 translate-middle">DISPLAY ONLY</span>
                                @endif
                                <span class="stock-badge"><i class="fas fa-box me-1"></i> Stok: {{ $product->stock }}</span>
                                <i class="fas fa-tshirt fa-4x text-secondary opacity-25"></i>
                            </div>

                            <div class="card-body text-center p-3">
                                <h6 class="fw-bold text-dark mb-1 text-truncate">{{ $product->name }}</h6>
                                <p class="product-price mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="cart-section">
            <div class="p-4 bg-primary text-white shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-shopping-cart me-2"></i>Keranjang</h5>
                    <span class="badge bg-white text-primary rounded-pill" id="cartCount">0 Item</span>
                </div>
            </div>

            <div class="cart-items" id="cartList">
                <div class="text-center text-muted mt-5 opacity-50">
                    <i class="fas fa-shopping-basket fa-4x mb-3"></i>
                    <p>Belum ada barang dipilih</p>
                </div>
            </div>

            <div class="cart-footer">
                <div class="d-flex justify-content-between mb-2 text-muted">
                    <span>Subtotal</span>
                    <span id="subtotalLabel">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between mb-3 text-success fw-bold">
                    <span><i class="fas fa-tags me-1"></i>Diskon</span>
                    <span id="discountLabel">- Rp 0</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4 pt-3 border-top">
                    <span class="h5 mb-0 fw-bold">Total Bayar</span>
                    <span class="h4 mb-0 fw-bold text-primary" id="totalLabel">Rp 0</span>
                </div>

                <form action="{{ route('transactions.store') }}" method="POST" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="cart_data" id="cartDataInput">

                    <button type="button" onclick="submitTransaksi()" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm" id="btnBayar" disabled>
                        <i class="fas fa-print me-2"></i> PROSES BAYAR
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="historyModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-history me-2"></i>Riwayat Transaksi Saya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>Waktu</th>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($history))
                            @forelse($history as $h)
                            <tr>
                                <td>{{ $h->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $h->product->name }}</td>
                                <td>{{ $h->quantity }}</td>
                                <td>Rp {{ number_format($h->total_price) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada riwayat transaksi.</td>
                            </tr>
                            @endforelse
                            @else
                            <tr>
                                <td colspan="4" class="text-center">Data tidak tersedia.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let cart = [];

        // --- 1. FITUR SEARCH ---
        function filterProduk() {
            let keyword = document.getElementById('searchInput').value.toLowerCase();
            let items = document.querySelectorAll('.product-item');
            items.forEach(item => {
                let name = item.getAttribute('data-name');
                item.style.display = name.includes(keyword) ? 'block' : 'none';
            });
        }

        // --- 2. LOGIKA KERANJANG + HAPUS + STOK AMAN ---
        function addToCart(id, name, price, maxStock) {
            let batasBeli = maxStock - 1; // Aturan: Sisakan 1 Stok

            if (batasBeli <= 0) {
                alert('Stok barang ini hanya sisa 1 (Display). Tidak boleh dijual!');
                return;
            }

            let existingItem = cart.find(item => item.id === id);

            if (existingItem) {
                if (existingItem.qty < batasBeli) {
                    existingItem.qty++;
                } else {
                    alert('Maksimal pembelian tercapai! Stok harus disisakan 1.');
                    return;
                }
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    qty: 1,
                    maxStock: maxStock
                });
            }
            renderCart();
        }

        // Fungsi Hapus Item (Tong Sampah)
        function removeFromCart(id) {
            if (confirm('Hapus barang ini dari keranjang?')) {
                cart = cart.filter(item => item.id !== id);
                renderCart();
            }
        }

        // Fungsi Tambah/Kurang Qty
        function updateQty(id, change) {
            let item = cart.find(item => item.id === id);
            if (item) {
                let newQty = item.qty + change;
                let batasBeli = item.maxStock - 1;

                if (newQty > 0 && newQty <= batasBeli) {
                    item.qty = newQty;
                } else if (newQty > batasBeli) {
                    alert('Stok maksimal tercapai (Sisa 1 Display)!');
                } else if (newQty <= 0) {
                    // Jangan hapus otomatis
                }
            }
            renderCart();
        }

        function renderCart() {
            let cartList = document.getElementById('cartList');
            let subtotal = 0;
            let totalQty = 0;

            if (cart.length === 0) {
                cartList.innerHTML = `
                <div class="text-center text-muted mt-5 opacity-50">
                    <i class="fas fa-shopping-basket fa-4x mb-3"></i>
                    <p>Belum ada barang dipilih</p>
                </div>`;
                document.getElementById('btnBayar').disabled = true;
                document.getElementById('btnBayar').innerHTML = '<i class="fas fa-print me-2"></i> PROSES BAYAR';
                document.getElementById('btnBayar').classList.remove('btn-success');
                document.getElementById('btnBayar').classList.add('btn-primary');
            } else {
                cartList.innerHTML = '';
                cart.forEach(item => {
                    subtotal += item.price * item.qty;
                    totalQty += item.qty;

                    cartList.innerHTML += `
                    <div class="card p-3 mb-3 border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-bold text-dark">${item.name}</h6>
                            <button class="btn btn-sm btn-outline-danger border-0" onclick="removeFromCart(${item.id})" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-primary fw-bold">Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</small>
                            
                            <div class="input-group input-group-sm" style="width: 100px;">
                                <button class="btn btn-outline-secondary" onclick="updateQty(${item.id}, -1)">-</button>
                                <input type="text" class="form-control text-center bg-white" value="${item.qty}" readonly>
                                <button class="btn btn-outline-secondary" onclick="updateQty(${item.id}, 1)">+</button>
                            </div>
                        </div>
                    </div>
                `;
                });
                document.getElementById('btnBayar').disabled = false;
            }

            // --- HITUNG DISKON (Belanja > 100rb ATAU > 3 Item) ---
            let discount = 0;
            if (subtotal > 100000 || totalQty > 3) {
                discount = subtotal * 0.10; // Diskon 10%
            }
            let total = subtotal - discount;

            // Update UI Angka
            document.getElementById('cartCount').innerText = totalQty + " Item";
            document.getElementById('subtotalLabel').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(subtotal);
            document.getElementById('discountLabel').innerText = "- Rp " + new Intl.NumberFormat('id-ID').format(discount);
            document.getElementById('totalLabel').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(total);

            // Ubah tombol jadi hijau kalau dapet diskon
            if (discount > 0) {
                document.getElementById('btnBayar').classList.remove('btn-primary');
                document.getElementById('btnBayar').classList.add('btn-success');
                document.getElementById('btnBayar').innerHTML = '<i class="fas fa-check-circle me-2"></i> BAYAR (HEMAT 10%)';
            } else {
                document.getElementById('btnBayar').classList.remove('btn-success');
                document.getElementById('btnBayar').classList.add('btn-primary');
                document.getElementById('btnBayar').innerHTML = '<i class="fas fa-print me-2"></i> PROSES BAYAR';
            }
        }

        function submitTransaksi() {
            if (cart.length === 0) return;
            document.getElementById('cartDataInput').value = JSON.stringify(cart);
            document.getElementById('checkoutForm').submit();
        }
    </script>
</body>

</html>