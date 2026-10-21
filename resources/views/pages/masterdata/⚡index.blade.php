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
            ->title('Master Data'); 
    }   
};
?>

<div>
  <div class="container-fluid px-4 py-4">
    <!-- Header Halaman -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark">Master Data</h2>
        <p class="text-muted">Pilih menu di bawah ini untuk mengelola data master aplikasi Shoewash.</p>
    </div>

    <!-- Grid Cards -->
    <div class="row g-4">
        
        <!-- Card 1: Branch -->
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('admin.branches.index') }}" class="card text-decoration-none shadow-sm h-100 border-0 hover-card transition-all">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3 fs-4">
                        🏢
                    </div>
                    <div class="d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark mb-1">Data Branch</h5>
                        <p class="card-text text-muted small mb-0">Kelola daftar cabang outlet</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 2: Customers -->
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('admin.customers.index') }}" class="card text-decoration-none shadow-sm h-100 border-0 hover-card transition-all">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3 fs-4">
                        👥
                    </div>
                   <div class="d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark mb-1">Data Customer</h5>
                        <p class="card-text text-muted small mb-0">Kelola data pelanggan</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 3: Services -->
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('admin.services.index') }}" class="card text-decoration-none shadow-sm h-100 border-0 hover-card transition-all">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="bg-purple bg-opacity-10 text-purple p-3 rounded-3 me-3 fs-4" style="background-color: rgba(111, 66, 193, 0.1) !important; color: #6f42c1;">
                        🛠️
                    </div>
                    <div class="d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark mb-1">Data Layanan</h5>
                        <p class="card-text text-muted small mb-0">Kelola jenis cuci/treatment</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

<!-- Tambahan sedikit CSS agar card ada efek naik saat kursor diarahkan (Hover) -->
<style>
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .5rem 1rem rgba(53, 53, 247, 0.1) !important;
    }
</style>
</div>