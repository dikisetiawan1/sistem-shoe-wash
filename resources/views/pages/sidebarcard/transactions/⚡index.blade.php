<?php

use Livewire\Component;

new class extends Component
{
    public function render()
    {
        // Kembalikan view dengan membawa data, layout, dan title
        return $this->view([
        ])
            ->layout('layouts::app')
            ->title('Transactions'); 
    }   
};
?>

<div>
  <div class="container-fluid px-4 py-4">
    <!-- Header Halaman -->
        <div class="mb-4">
            <h4 class="fw-bold mb-1" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Transactions
            </h4>
            <p class="text-secondary small mb-0">Pilih menu di bawah ini untuk mengelola transaksi aplikasi Shoewash.</p>
        </div>

    <!-- Grid Cards -->
    <div class="row g-4">
        
        <!-- Card 1: Branch -->
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('admin.orders.index') }}" class="card text-decoration-none shadow-sm h-100 border-0 hover-card transition-all">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3 me-3 fs-4">
                        📦
                    </div>
                    <div class="d-flex flex-column">
                        <h5 class="card-title fw-bold mb-1" style="background: linear-gradient(45deg, #0d6efd, #6610f2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            Data Pesanan
                        </h5>
                        <p class="card-text text-muted small mb-0">Kelola daftar Pesanan pelanggan</p>
                    </div>
                    
                </div>
            </a>
        </div>

        <!-- Card 2: Customers -->
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('admin.orders.updatestatus') }}" class="card text-decoration-none shadow-sm h-100 border-0 hover-card transition-all">
                <div class="card-body d-flex align-items-center p-4">
                   <div class="bg-info bg-opacity-10 text-info p-3 rounded-3 me-3 fs-4">
                        🔄
                    </div>
                    <div class="d-flex flex-column">
                        <h5 class="card-title fw-bold mb-1" style="background: linear-gradient(45deg, #0d6efd, #6610f2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            Update Status Pesanan
                        </h5>
                        <p class="card-text text-muted small mb-0">Kelola status pesanan pelanggan</p>
                    </div>
                    
                </div>
            </a>
        </div>

        <!-- Card 3: Services -->
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('admin.orders.history') }}" class="card text-decoration-none shadow-sm h-100 border-0 hover-card transition-all">
                <div class="card-body d-flex align-items-center p-4">
                   <div class="bg-secondary bg-opacity-10 text-secondary p-3 rounded-3 me-3 fs-4">
                        🕒
                    </div>

                    <div class="d-flex flex-column">
                        <h5 class="card-title fw-bold mb-1" style="background: linear-gradient(45deg, #0d6efd, #6610f2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            Data Riwayat Pesanan
                        </h5>
                        <p class="card-text text-muted small mb-0">Kelola riwayat pesanan pelanggan</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="row g-4">
              <!-- Card 3: Pembayaran -->
            <div class="col-12 col-md-6 col-lg-4">
                <a href="{{ route('admin.orders.payment-confirmation') }}" class="card text-decoration-none shadow-sm h-100 border-0 hover-card transition-all">
                    <div class="card-body d-flex align-items-center p-4">
                    <div class="bg-danger bg-opacity-10 text-secondary p-3 rounded-3 me-3 fs-4">
                           <svg class="bi bi-bank" width="1.2em" height="1.2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.379l.5 2A.5.5 0 0 1 15.5 16H.5a.5.5 0 0 1-.485-.621l.5-2A.5.5 0 0 1 1 13.5V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89L8 0zM3.777 3h8.447L8 1.041 3.777 3zM2 6v7h1V6H2zm2 0v7h2.5V6H4zm3.5 0v7h1V6h-1zm2 0v7H12V6H9.5zM13 6v7h1V6h-1zm2-3V4H1V3h14zM.5 14h15v1H.5v-1z"/>
                            </svg>
                        </div>

                        <div class="d-flex flex-column">
                            <h5 class="card-title fw-bold mb-1" style="background: linear-gradient(45deg, #0d6efd, #6610f2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                Konfirmasi Pembayaran
                            </h5>
                            <p class="card-text text-muted small mb-0">Kelola riwayat pembayaran</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        

    </div>
</div>

<!-- Tambahan sedikit CSS agar card ada efek naik saat kursor diarahkan (Hover) -->
<style>
     .hover-card {
        transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1), 
                    box-shadow 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        
        will-change: transform, box-shadow;
        
        -webkit-font-smoothing: antialiased;
    }
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 1rem 2rem rgba(53, 53, 247, 0.1) !important;
    }
</style>
</div>