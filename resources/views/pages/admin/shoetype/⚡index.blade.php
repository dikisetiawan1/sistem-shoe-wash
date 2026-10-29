<?php

use App\Models\ShoeCategory;
use Livewire\Component;

new class extends Component
{


    public function delete($id)
    {
        $shoetype = ShoeCategory::findOrFail($id);

        // delete data
        $shoetype->delete();

        // flash message
        session()->flash('message', 'Data Shoes Type Berhasil Dihapus.');
        return redirect()->route('admin.shoetype.index');
    }
    public function render()
    {
        // Kembalikan view dengan membawa data, layout, dan title
        return $this->view([

            // ambil semua data shoetype dari db
            'shoetypes' => ShoeCategory::latest()->get(),
        ])
            ->layout('layouts::app')
            ->title('Shoes Types'); 
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

             <!--begin::Row-->
            <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="fw-bold mb-0 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Daftar Sepatu</h4>
                        <small class="text-muted">Kelola seluruh data jenis sepatu</small>
                    </div>
                    
                    {{-- Tombol aksi langsung sejajar di kanan --}}
                    <a href="/shoetype/create"  wire:navigate class="btn btn-primary fw-semibold shadow-sm">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Jenis Sepatu
                    </a>
                </div>
            <!--end::Row-->

           

            <div class="card border-0 rounded shadow-sm">
                <div class="card-body">
                   <table id="shoetypeTable" class="display">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Brand</th>
                                    <th>Description</th>
                                    <th style="width: 15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                               @forelse ($shoetypes as $shoestype)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $shoestype->name }}</td>
                                    <td>{{ $shoestype->brand }}</td>
                                    <td>{{ $shoestype->description }}</td>
                                    <td class="text-center">
                                        <a href="/shoetype/edit/{{ $shoestype->id }}" wire:navigate
                                            class="btn btn-sm btn-warning">
                                            EDIT
                                        </a>

                                         <button
                                            class="btn btn-sm btn-danger"
                                            onclick="confirm('Are you sure you want to delete this data?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $shoestype->id }})">
                                            DELETE
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <div class="alert alert-danger">
                                    Data Shoes Type belum Tersedia.
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
        let table = new DataTable('#shoetypeTable', {
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
