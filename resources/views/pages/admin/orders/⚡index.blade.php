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
               <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h1 class="mb-5 fs-3"> <i class="fa-solid fa-clipboard-list"></i> Orders List </h1>
              </div>
              <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item active" aria-current="page">  Orders</li>
                    <li class="breadcrumb-item"><a href="#">List</a></li>
                  </ol>
                </nav>
              </div>
            </div>
            <!--end::Row-->

            <!-- flash message -->
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <!-- end flash message -->

            <a href="/orders/create" wire:navigate
                class="btn btn-md btn-success rounded shadow-sm border-0 mb-3">
                ADD NEW ORDER
            </a>

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
                                    <td>{{ $order->total_price }}</td>
                                    <td>{{ $order->payment_status }}</td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>{{ $order->entry_date }}</td>
                                    <td>{{ $order->estimated_completion_date }}</td>

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