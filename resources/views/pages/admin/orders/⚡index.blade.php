<?php

use App\Models\Orders;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;
    


public function delete($id)
{
    $order = Orders::with('items')->findOrFail($id);

    // 1. Soft delete seluruh item detail sepatu terkait
    $order->items()->delete();

    // 2. Soft delete header order utama
    $order->delete();

     session()->flash('message', 'Data Pesanan Berhasil Dihapus.');
    return redirect()->route('admin.orders.index');
}

    public function render()
    {

        // ambil branch_id dari session user yg sedang login
            $branchId = Auth::user()->branch_id;
            //tampung data orders
            $orders = [];
                if($branchId){
                    // ambil data order berdasarkan branch tertentu
                            $orders = Orders::with(['customers', 'branches'])
                            ->where('branch_id', $branchId)
                            ->latest()
                            ->get();
                }
        // Return view with layout and title
        return $this->view([
            // kembalikan dari orders ke view 
            'orders' => $orders,
        ])
            ->layout('layouts::app')
            ->title('Orders List'); 
    }
};
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
           
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="fw-bold mb-0 text-dark">Daftar Pesanan</h4>
                    <small class="text-muted">Kelola seluruh order dan status cuci sepatu</small>
                </div>
                
                {{-- Tombol aksi langsung sejajar di kanan --}}
                <a href="/orders/create" wire:navigate class="btn btn-primary fw-semibold shadow-sm">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Pesanan
                </a>
            </div>
           

            <!-- flash message -->
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <!-- end flash message -->

            <div class="card border-0 rounded shadow-sm">
                <div class="card-body">
                    <table id="ordersTable" class="display">
                        <thead>
                            <tr>
                                <th >#</th>
                                <th >Order ID</th>
                                <th >Customers</th>
                                <th >Total price</th>
                                <th >Type</th>
                                <th >Payment status</th>
                                <th >Payment method</th>
                                <th >Entry date</th>
                                <th >Estimated date</th>
                                <th  style="width: 15%">Actions</th>

                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->customers->name }}</td>
                                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>{{ $order->type}}</td>
                                    <td>{{ $order->payment_status }}</td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>{{ $order->entry_date }}</td>
                                    <td>{{ $order->estimated_completion_date }}</td>

                                    <td class="d-flex align-items-center gap-1">
                                        <a href="/orders/{{ $order->id }}" wire:navigate
                                            class="btn btn-sm btn-success">
                                            DETAIL
                                        </a>
                                        {{-- <a href="/edit/{{ $order->id }}" wire:navigate
                                            class="btn btn-sm btn-warning">
                                            EDIT
                                        </a> --}}

                                        {{-- 📋 TOMBOL COPY LINK TRACKING DI SAMPING DELETE --}}
                                            <div x-data="{ 
                                                url: '{{ url('/tracking-order/' . $order->id) }}',
                                                copied: false,
                                                copy() {
                                                    navigator.clipboard.writeText(this.url);
                                                    this.copied = true;
                                                    setTimeout(() => this.copied = false, 2000);
                                                }
                                            }">
                                                <button @click="copy()" class="btn btn-sm btn-secondary" :class="copied ? 'btn-info text-white' : ''" :title="copied ? 'Tersalin!' : 'Salin Link Tracking'">
                                                    <span x-show="!copied">Copy</span>
                                                    <span x-show="copied">✓ Copied!</span>
                                                </button>
                                            </div>
                                        
                                         <button
                                            class="btn btn-sm btn-danger"
                                            onclick="confirm('Are you sure you want to cancelled this data?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $order->id }})">
                                            CANCEL
                                        </button>
                                        
                                    </td>
                                </tr>
                            @empty
                                <div class="alert alert-danger">
                                    Data Order belum Tersedia.
                                </div>
                            @endforelse
                        </tbody>
                    </table>

                   
                </div>
            </div>

        </div>
    </div>
</div>


{{-- data datatable --}}
<script>
    $(document).ready(function() {
        let table = new DataTable('#ordersTable', {
            destroy: true, // Mengizinkan inisialisasi ulang jika tabel sudah ada
            // Huruf 'l' ditambahkan di sebelah 'i' (menjadi 'li') agar dropdown entries per page muncul di kiri bawah
            dom: '<"row mb-3"<"col-md-6"B><"col-md-6"f>>rt<"row mt-3 align-items-center"<"col-md-6"li><"col-md-6 d-flex justify-content-end"p>>',
            buttons: [
                { 
                    extend: 'copy', 
                    text: '<i class="fas fa-copy"></i>', // Ikon Salin
                    titleAttr: 'Salin ke Clipboard',      // Tooltip saat kursor diarahkan ke tombol
                    className: 'btn btn-secondary btn-sm' 
                },
                { 
                    extend: 'excel', 
                    text: '<i class="fas fa-file-excel"></i>', // Ikon Excel
                    titleAttr: 'Ekspor ke Excel',
                    className: 'btn btn-success btn-sm' 
                },
                { 
                    extend: 'pdf', 
                    text: '<i class="fas fa-file-pdf"></i>', // Ikon PDF
                    titleAttr: 'Ekspor ke PDF',
                    className: 'btn btn-danger btn-sm' 
                },
                { 
                    extend: 'print', 
                    text: '<i class="fas fa-print"></i>', // Ikon Cetak
                    titleAttr: 'Cetak Tabel',
                    className: 'btn btn-primary btn-sm' 
                }
            ]
        });

        // table.on('click', 'tbody tr', function () {
        //     let data = table.row(this).data();
        //     alert('You clicked on ' + data[0] + "'s row");
        // });
    });
</script>