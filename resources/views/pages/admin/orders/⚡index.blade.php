<?php

use App\Models\Orders;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

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

            <!-- flash message -->
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <!-- end flash message -->

            <a href="/create" wire:navigate
                class="btn btn-md btn-success rounded shadow-sm border-0 mb-3">
                ADD NEW ORDER
            </a>

            <div class="card border-0 rounded shadow-sm">
                <div class="card-body">
                    <table id="example" class="display">
                        <thead>
                            <tr>
                                <th >Order ID</th>
                                <th>Users</th>
                                <th >Costumer</th>
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
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user_id }}</td>
                                    <td>{{ $order->costumer }}</td>
                                    <td>{{ $order->total_price }}</td>
                                    <td>{{ $order->payment_status }}</td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>{{ $order->entry_date }}</td>
                                    <td>{{ $order->estimated_date }}</td>

                                    <td class="text-center">
                                        <a href="/edit/{{ $order->id }}" wire:navigate
                                            class="btn btn-sm btn-primary">
                                            EDIT
                                        </a>

                                        <button class="btn btn-sm btn-danger">
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