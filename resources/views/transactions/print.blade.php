<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk - Toko Pakaian</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #eee;
            padding: 20px;
        }

        .ticket {
            width: 300px;
            max-width: 300px;
            background: white;
            margin: 0 auto;
            padding: 15px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .header,
        .footer {
            text-align: center;
        }

        .header h3 {
            margin: 0;
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #333;
            margin: 10px 0;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-top: 5px;
        }

        .btn-back {
            display: block;
            width: 100%;
            padding: 10px;
            background: #333;
            color: white;
            text-align: center;
            text-decoration: none;
            margin-top: 20px;
            font-family: sans-serif;
            border-radius: 5px;
        }

        .btn-back:hover {
            background: #000;
        }

        /* Sembunyikan tombol saat dicetak */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .ticket {
                box-shadow: none;
                width: 100%;
            }

            .btn-back {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="ticket">
        <div class="header">
            <h3>TOKO Pakaian</h3>
            <small>Jl. Pendidikan No. 123</small><br>
            <small>{{ session('date') }}</small>
        </div>

        <div class="divider"></div>

        <div class="item-row">
            <span>Kasir:</span>
            <span>{{ session('kasir') }}</span>
        </div>
        <div class="item-row">
            <span>No. TRX:</span>
            <span>{{ session('invoice_code') }}</span>
        </div>

        <div class="divider"></div>

        @if(session('cart'))
        @foreach(session('cart') as $item)
        <div style="margin-bottom: 5px;">
            <div style="font-weight: bold;">{{ $item['name'] }}</div>
            <div class="item-row">
                <span>{{ $item['qty'] }} x {{ number_format($item['price'], 0, ',', '.') }}</span>
                <span>{{ number_format($item['qty'] * $item['price'], 0, ',', '.') }}</span>
            </div>
        </div>
        @endforeach
        @endif

        <div class="divider"></div>

        <div class="item-row">
            <span>Subtotal:</span>
            <span>{{ number_format(session('subtotal'), 0, ',', '.') }}</span>
        </div>

        @if(session('discount') > 0)
        <div class="item-row">
            <span>Diskon:</span>
            <span>-{{ number_format(session('discount'), 0, ',', '.') }}</span>
        </div>
        @endif

        <div class="divider"></div>

        <div class="total-row" style="font-size: 16px;">
            <span>TOTAL:</span>
            <span>Rp {{ number_format(session('total'), 0, ',', '.') }}</span>
        </div>

        <div class="divider"></div>

        <div class="footer">
            <small>Terima Kasih atas kunjungan Anda!</small><br>
            <small>Barang yang dibeli tidak dapat ditukar.</small>
        </div>

        <a href="{{ route('transactions.index') }}" class="btn-back">Kembali ke Kasir</a>
    </div>

</body>

</html>