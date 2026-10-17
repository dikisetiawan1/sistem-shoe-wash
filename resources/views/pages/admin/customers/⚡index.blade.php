<?php

use App\Models\Customers;
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
        // Kembalikan view dengan membawa data, layout, dan title
        return $this->view([

            // ambil semua data customers dari db
            'customers' => Customers::latest()->get(),
        ])
            ->layout('layouts::app')
            ->title('Customers List'); 
    }
};
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">

           
             <!--begin::Row-->
             <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="fw-bold mb-0 text-dark">Daftar Customers</h4>
                    <small class="text-muted">Kelola seluruh customer dan informasi mereka</small>
                </div>
                
                <a href="/customers/create" wire:navigate class="btn btn-primary fw-semibold shadow-sm">
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
                   <table id="customersTable" class="display">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th style="width: 15%">Actions</th>
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
                                        <a href="/customers/edit/{{ $customer->id }}" wire:navigate
                                            class="btn btn-sm btn-warning">
                                            EDIT
                                        </a>

                                         <button
                                            class="btn btn-sm btn-danger"
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
        let table = new DataTable('#customersTable', {
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
