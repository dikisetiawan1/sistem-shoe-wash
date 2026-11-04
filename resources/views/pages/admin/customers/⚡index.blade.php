<?php

use App\Models\Customers;
use App\Models\User;
use Livewire\Component;

new class extends Component
{


    public function delete($id)
    {
        $customer = Customers::findOrFail($id);

        // delete data
        $customer->delete();

        // flash message
        session()->flash('message', 'Data Customer Berhasil Dihapus.');
        return redirect()->route('admin.customers.index');
    }
    public function render()
    {

        $branchId = Auth::User()->branch_id;
        $customers = [];

        if($branchId){
           $customers= Customers::with('branches')
            ->where('branch_id', $branchId)
            ->latest()
            ->get();
        }

        // Kembalikan view dengan membawa data, layout, dan title
        return $this->view([

            // ambil semua data customers dari db
            'customers' => $customers
        ])
            ->layout('layouts::app')
            ->title('Customers'); 
    }
};
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">

           
             <!--begin::Row-->
             <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="fw-bold mb-0 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Daftar Customers</h4>
                    <small class="text-muted">Kelola seluruh customer dan informasi mereka</small>
                </div>
                
                <a href="/masterdata/customers/create" wire:navigate class="btn text-white fw-semibold border-0 shadow-sm px-3 py-2" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Customer
                </a>

            </div>
            <!--end::Row-->

             <!-- flash message -->
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <!-- end flash message -->


            <div class="card border-0 rounded shadow-sm">
                <div class="card-body">
                   <table id="customersTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>PHONE</th>
                                    <th>EMAIL</th>
                                    <th>ADDRESS</th>
                                    <th style="width: 15%">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                               @forelse ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td class="text-center">
                                        <a href="/masterdata/customers/edit/{{ $customer->id }}" wire:navigate
                                            class="btn btn-sm btn-warning">
                                            EDIT
                                        </a>

                                         <button
                                            class="btn btn-sm btn-danger"
                                            wire:navigate 
                                            onclick="confirm('Are you sure you want to delete this data?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $customer->id }})">
                                            DELETE
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <div class="alert alert-danger">
                                    Data Customer belum Tersedia.
                                </div>
                            @endforelse
                                
                            </tbody>
                            
                        </table>
                  
                </div>
            </div>

        </div>
    </div>
</div>


{{-- datatable --}}

<script>
    $(document).ready(function() {
        // Cek apakah tabel sudah pernah diinisialisasi, hancurkan dulu jika ada untuk cegah bug
        if ($.fn.DataTable.isDataTable('#customersTable')) {
            $('#customersTable').DataTable().destroy();
        }

        let table = $('#customersTable').DataTable({
            responsive: true,
            scrollX: true,       // Mengaktifkan scroll horizontal
            scrollCollapse: true,
            pageLength: 50,
            dom: '<"row mb-3"<"col-md-6"B><"col-md-6"f>>rt<"row mt-3 align-items-center"<"col-md-6"li><"col-md-6 d-flex justify-content-end"p>>',
            buttons: [
                { 
                    extend: 'copy', 
                    text: '<i class="fas fa-copy"></i>', 
                    titleAttr: 'Salin ke Clipboard', 
                    className: 'btn btn-secondary btn-sm' 
                },
                { 
                    extend: 'excel', 
                    text: '<i class="fas fa-file-excel"></i>', 
                    titleAttr: 'Ekspor ke Excel',
                    className: 'btn btn-success btn-sm' 
                },
                { 
                    extend: 'pdf', 
                    text: '<i class="fas fa-file-pdf"></i>', 
                    titleAttr: 'Ekspor ke PDF',
                    className: 'btn btn-danger btn-sm' 
                },
                { 
                    extend: 'print', 
                    text: '<i class="fas fa-print"></i>', 
                    titleAttr: 'Cetak Tabel',
                    className: 'btn btn-primary btn-sm' 
                }
            ]
        });
    });
</script>
