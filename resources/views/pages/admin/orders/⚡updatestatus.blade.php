<?php

use Livewire\Component;
use App\Models\Orders;
use App\Models\OrderDetail;
use Carbon\Carbon;

new class extends Component {



     // method update status pesanan
    public function updateStatus($itemId, $newStatus)
    {
        $item = OrderDetail::find($itemId); 

        if ($item) {
            $item->status = $newStatus;
            $item->save();
             
            }
            // flash message
            session()->flash('message', "Status Pesanan {$item->brand} Berhasil Di Update.");
            return redirect()->route('admin.orders.updatestatus');
    }


     public function render()
    {
        // Kembalikan view dengan membawa data, layout, dan title
        return $this->view([])
            ->layout('layouts::app')
            ->title('History Orders'); 
    }   


    public function with()
    {
            // Menampilkan data pesanan dengan items nya received
            $orders = Orders::with(['customers', 'items.category', 'items.service'])
            ->latest()
            ->get();
        return [
            'orders' => $orders
        ];
        
    }
}; ?>

<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
    {{-- Header Halaman & Filter Tanggal --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-dark">
                Update Status Pesanan
            </h4>
            <p class="text-muted mb-0 small">Melakukan update status pekerjaan ke tahap selanjutnya</p>
        </div>
    </div>
   <!-- flash message -->
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <!-- end flash message -->

    {{-- Tabel Daftar Antrean --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id='updatestatusTable'>
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;" class="text-center">#</th>
                        <th>No. Order & Customer</th>
                        <th>Merk & Shoe Color</th>
                        <th>Category & Service</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($orders as $order)
                        @foreach($order->items as $item)
                            <tr>
                                <td class="text-center fw-bold text-muted">{{ $no++}}</td>
                                <td>
                                    <span class="font-monospace fw-bold text-primary">{{ $order->order_number }}</span>
                                    <br>
                                    <span class="fw-semibold text-dark">{{ $order->customers->name ?? 'Guest' }}</span>
                                    <small class="text-muted d-block">{{ $order->customers->phone ?? '-' }}</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $item->brand }}</span>
                                    <small class="text-muted d-block">Warna: {{ $item->color }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $item->category->name ?? 'sneakers' }}</span>
                                    <span class="d-block small text-primary fw-semibold mt-1">
                                        <i class="fa-solid fa-soap me-1"></i>{{ $item->service->name ?? '-' }}
                                    </span>
                                </td>
                                 <td class="text-center">
                                    <!-- Dropdown Auto Update Status Langsung di Tabel -->
                                    <select 
                                        wire:change="updateStatus({{ $item->id }}, $event.target.value)" 
                                        class="form-select form-select-sm text-xs rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                        
                                        <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="washing" {{ $item->status == 'washing' ? 'selected' : '' }}>Washing</option>
                                        <option value="drying" {{ $item->status == 'drying' ? 'selected' : '' }}>Drying</option>
                                        <option value="completed" {{ $item->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="received" {{ $item->status == 'received' ? 'selected' : '' }}>Received</option>
                                        
                                    </select>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                        {{ Carbon::parse($item->update_at)->format('d M Y') }}
                                    </span>
                                </td>
                               
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-mug-hot fa-2x mb-2 d-block text-secondary"></i>
                                Tidak ada Data orders</strong>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
    </div>
</div>


<script>
    $(document).ready(function() {
        let table = new DataTable('#updatestatusTable', {
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
