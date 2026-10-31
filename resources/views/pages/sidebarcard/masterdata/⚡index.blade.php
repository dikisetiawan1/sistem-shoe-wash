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
            <h4 class="fw-bold mb-1 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 20%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Master Data
            </h4>
            <p class="text-secondary small mb-0">Pilih menu di bawah ini untuk mengelola data master aplikasi Shoewash.</p>
        </div>
    
    <!-- Grid Cards -->
    <div class="row g-4">
        
        <!-- Card 1: Branch -->
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('admin.branches.index') }}" wire:navigate class="card text-decoration-none shadow-sm h-100 border-0 hover-card transition-all">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3 fs-4">
                        🏢
                    </div>
                    <div class="d-flex flex-column">
                        <h5 class="card-title fw-bold mb-1" style="background: linear-gradient(45deg, #0d6efd, #6610f2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            Data Branches
                        </h5>
                        <p class="card-text text-muted small mb-0">Kelola data branch</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 2: Customers -->
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('admin.customers.index') }}" wire:navigate  class="card text-decoration-none shadow-sm h-100 border-0 hover-card transition-all">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3 fs-4">
                        👥
                    </div>
                   <div class="d-flex flex-column">
                        <h5 class="card-title fw-bold mb-1" style="background: linear-gradient(45deg, #0d6efd, #6610f2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            Data Customer
                        </h5>
                        <p class="card-text text-muted small mb-0">Kelola data pelanggan</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 3: Services -->
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('admin.services.index') }}" wire:navigate  class="card text-decoration-none shadow-sm h-100 border-0 hover-card transition-all">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="bg-purple bg-opacity-10 text-purple p-3 rounded-3 me-3 fs-4" style="background-color: rgba(111, 66, 193, 0.1) !important; color: #6f42c1;">
                        <i class="fa-solid fa-hand-sparkles"></i>
                    </div>
                     <div class="d-flex flex-column">
                        <h5 class="card-title fw-bold mb-1" style="background: linear-gradient(45deg, #0d6efd, #6610f2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            Data Layanan
                        </h5>
                        <p class="card-text text-muted small mb-0">Kelola Jenis cuci/treatment</p>
                    </div>
                </div>
            </a>
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