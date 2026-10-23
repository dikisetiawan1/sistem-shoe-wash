<?php

use Livewire\Component;
use App\Models\Orders;

new class extends Component
{

    public $orderId;
    public $order;

   public function mount($id)
{
    // Gunakan findOrFail agar jika data kosong langsung melempar 404 Not Found
    $this->order = Orders::with(['customers', 'items.category', 'items.service'])
                        ->findOrFail($id);
}



    
};
?>


<style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f8f9fa;
            color: #000;
        }

        .receipt-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .dashed-line {
            border-top: 1px dashed #000;
            margin: 12px 0;
        }

        /* Aturan Khusus saat Di-print / Cetak */
        @media print {
            body {
                background-color: #fff;
            }
            .no-print {
                display: none !important;
            }
            .receipt-container {
                max-width: 100%;
                width: 100%;
                border: none;
                box-shadow: none;
                padding: 0;
                margin: 0;
            }
            @page {
                margin: 0.5cm;
            }
        }
    </style>

<div>
<!-- Tombol Aksi (Otomatis Sembunyi saat Dicetak) -->
    <div class="container text-center my-3 no-print">
        <button onclick="window.print()" class="btn btn-primary fw-bold me-2">
            <i class="fa-solid fa-print me-1"></i> Cetak Struk
        </button>
        <button onclick="window.close()" class="btn btn-secondary fw-bold">
            <i class="fa-solid fa-xmark me-1"></i> Tutup
        </button>
    </div>

    <!-- Area Nota / Struk -->
    <div class="receipt-container">
        <!-- Header Toko -->
        <div class="text-center mb-2">
            <h4 class="fw-bold mb-0">SHOE WASH</h4>
            <small class="d-block">Jl. Raya Clean Shoes No. 123</small>
            <small class="d-block">WA / Telp: 0812-3456-7890</small>
        </div>

        <div class="dashed-line"></div>

        <!-- Info Transaksi & Customer -->
        <div class="small">
            <div class="d-flex justify-content-between">
                <span>No. Invoice:</span>
                <span class="fw-bold">{{ $order->order_number }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Entry Date:</span>
                <span>{{ \Carbon\Carbon::parse($order->entry_date)->format('d/m/Y') }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Estimated Completion:</span>
                <span>{{ \Carbon\Carbon::parse($order->estimated_completion_date)->format('d/m/Y') }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Customers:</span>
                <span class="fw-bold">{{ $order->customers->name ?? 'Guest' }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>No. HP:</span>
                <span>{{ $order->customers->phone ?? '-' }}</span>
            </div>
        </div>

        <div class="dashed-line"></div>

        <!-- Rincian Item Sepatu -->
        <div class="small">
            <div class="fw-bold mb-1">DETAIL SHOES:</div>
            @foreach($order->items as $index => $item)
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">{{ $index + 1 }}. {{ $item->brand }} ({{ $item->color }})</span>
                        <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="ps-2 text-muted" style="font-size: 0.85rem;">
                        <div>• Kat: {{ $item->category->name ?? '-' }}</div>
                        <div>• Layanan: {{ $item->service->name ?? '-' }}</div>
                        @if(!empty($item->notes))
                            <div>• Ket: {{ $item->notes }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="dashed-line"></div>

        <!-- Total & Pembayaran -->
        <div class="small">
            <div class="d-flex justify-content-between fs-6 fw-bold">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between mt-1">
                <span>Payment Status:</span>
                <span class="fw-bold text-uppercase">{{ $order->payment_status == 'paid' ? 'LUNAS' : 'BELUM BAYAR' }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Payment Method:</span>
                <span class="text-uppercase">{{ $order->payment_method }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Type:</span>
                <span class="text-uppercase">{{ $order->type }}</span>
            </div>
        </div>

        <div class="dashed-line"></div>

        <!-- Catatan / Ketentuan Service -->
        <div class="text-center small" style="font-size: 0.75rem;">
            <p class="fw-bold mb-1">KETENTUAN WASH SHOES:</p>
            <ol class="ps-3 text-start mb-2" style="padding-left: 1rem !important;">
                <li>Pengambilan barang wajib membawa invoice ini.</li>
                <li>Barang yang tidak diambil > 3 hari di luar tanggung jawab kami.</li>
            </ol>
            <p class="mb-0 fw-bold">--- THANK YOU. HAVE A NICE DAY ---</p>
            <small>Kebersihan Sepatu Anda Adalah Prioritas Kami</small>
        </div>
    </div>
</div>
    <!-- Auto Print Script (Opsional) -->
    <script>
        // Membuka dialog cetak otomatis begitu halaman selesai dimuat
        window.onload = function() {
            window.print();
        }
    </script>