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
            ->title('Reports'); 
    }   
};
?>

<div>
  <div class="container-fluid px-4 py-4">
    <!-- Header Halaman -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark">Settings Management</h2>
        <p class="text-muted">Pilih menu di bawah ini untuk mengelola users.</p>
    </div>

    <!-- Grid Cards -->
    <div class="row g-4">
        
        <!-- Card 1: Branch -->
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('admin.user.index') }}" class="card text-decoration-none shadow-sm h-100 border-0 hover-card transition-all">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3 fs-4">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark mb-1">Users</h5>
                        <p class="card-text text-muted small mb-0">Kelola akses users</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 2: Customers -->
        <div class="col-12 col-md-6 col-lg-4">
            <a href="#" class="card text-decoration-none shadow-sm h-100 border-0 hover-card transition-all">
                <div class="card-body d-flex align-items-center p-4">
                   <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3 fs-4">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                   <div class="d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark mb-1">Profile</h5>
                        <p class="card-text text-muted small mb-0">Kelola Profile</p>
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