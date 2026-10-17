<?php

use Livewire\Component;
use App\Models\Orders;

new class extends Component
{

     public $orderId;
    public $order;

    public function mount($id)
    {
        $this->orderId = $id;

        // Ambil data order berdasarkan ID beserta relasi customer dan detail item sepatu
        $this->order = Orders::with([
            'customers', 
            'items.category', 
            'items.service'
        ])->findOrFail($id);
    }

    public function render()
    {
        // Kembalikan view dengan membawa data, layout, dan title
        return $this->view([])
            ->layout('layouts::app')
            ->title('Orders Detail'); 
    }   
}
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-4">

             <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">Detail Pesanan</h4>
                        <small class="text-muted">Kelola informasi pesanan untuk layanan cuci sepatu</small>
                    </div> 
                    
                    
            </div>

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-receipt me-2"></i>Order Information</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Order ID</b> <span class="float-end font-monospace fw-bold text-primary">{{ $order->order_number }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Customer</b> <span class="float-end">{{ $order->customers->name?? '-' }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Date Entry</b> <span class="float-end">{{ $order->entry_date }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Estimated Completion</b> <span class="float-end">{{ $order->estimated_completion_date }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Payment Method</b> <span class="float-end">{{ $order->payment_method }}</span>
                        </li>
                        <li class="list-group-item">
                             <b>Payment Status</b>
                                        @if($order->payment_status == 'paid')
                                            <span class="badge bg-success float-end">Paid</span>
                                        @elseif($order->payment_status == 'unpaid')
                                            <span class="badge bg-danger  float-end">Unpaid</span>
                                        @else
                                            <span class="badge bg-dark">{{ $order->payment_status }}</span>
                                        @endif
                        </li>
                                            
                        <li class="list-group-item">
                            <b>Total</b> <span class="float-end">Rp. {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>

        
        <div class="col-md-8 mt-3">
             <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="fw-bold mb-0 text-dark"></h4>
                        <small class="text-muted"></small>
                    </div> 


                      <a href="/customers/create" wire:navigate target="_blank" class="btn btn-primary fw-semibold shadow-sm"">
                    <i class="fa-solid fa-print me-1"></i> Cetak Nota / Struk
                </a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-shoe-prints me-2"></i> Shoe Details</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Shoe (Brand/Color)</th>
                                <th>Category & Service</th>
                                <th>Noted</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $item->brand }}</strong><br>
                                    <small class="text-muted">Warna: {{ $item->color }}</small>
                                </td>
                                <td>
                                    {{ $item->category_id ?? '-' }}<br>
                                    <small class="text-info">{{ $item->service->name ?? '-' }}</small>
                                </td>
                                <td><small class="text-secondary">{{ $item->notes ?? '-' }}</small></td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>

                                <td>
                                        @if($item->status == 'pending')
                                            <span class="badge bg-secondary">Pending</span>
                                        @elseif($item->status == 'in_progress')
                                            <span class="badge bg-info text-dark">Sedang Dicuci</span>
                                        @elseif($item->status == 'completed')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($item->status == 'taken')
                                            <span class="badge bg-primary">Sudah Diambil</span>
                                        @else
                                            <span class="badge bg-dark">{{ $item->status }}</span>
                                        @endif
                                    </td>
                                                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="4" class="text-end">Total Payment:</td>
                                <td class="text-end text-success fs-5">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Tombol Aksi di Bawah --}}
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Orders
                </a>
               
            </div>  
        </div>

    </div>
</div>