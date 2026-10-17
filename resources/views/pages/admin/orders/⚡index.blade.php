<?php

use App\Models\Orders;
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

    session()->flash('success', 'Orders ' . $order->order_number . ' berhasil dibatalkan/dihapus.');
}

    public function render()
    {
        // Return view with layout and title
        return $this->view([

            // Get all orders with latest pagination
            'orders' => Orders::latest()->get(),
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
                    <h4 class="fw-bold mb-0 text-dark">Daftar Transaksi</h4>
                    <small class="text-muted">Kelola seluruh order dan status cuci sepatu</small>
                </div>
                
                {{-- Tombol aksi langsung sejajar di kanan --}}
                <a href="/orders/create" wire:navigate class="btn btn-primary fw-semibold shadow-sm">
                    <i class="fa-solid fa-plus me-1"></i> Tambah transaksi
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
                    <table id="example" class="display">
                        <thead>
                            <tr>
                                <th >#</th>
                                <th >Order Number</th>
                                <th>Users</th>
                                <th >Customers</th>
                                <th >Total price</th>
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
                                    <td>{{ $order->user_id }}</td>
                                    <td>{{ $order->customers_id }}</td>
                                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>{{ $order->payment_status }}</td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>{{ $order->entry_date }}</td>
                                    <td>{{ $order->estimated_completion_date }}</td>

                                    <td class="text-center">
                                        <a href="/orders/{{ $order->id }}" wire:navigate
                                            class="btn btn-sm btn-success">
                                            DETAIL
                                        </a>
                                        <a href="/edit/{{ $order->id }}" wire:navigate
                                            class="btn btn-sm btn-warning">
                                            EDIT
                                        </a>
                                        
                                         <button
                                            class="btn btn-sm btn-danger"
                                            onclick="confirm('Are you sure you want to delete this data?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $order->id }})">
                                            DELETE
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
 let table = new DataTable('#example');

table.on('click', 'tbody tr', function () {
	let data = table.row(this).data();

	alert('You clicked on ' + data[0] + "'s row");
});
   </script>