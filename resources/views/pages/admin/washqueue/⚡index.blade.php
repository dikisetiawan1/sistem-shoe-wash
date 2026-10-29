<?php

use Livewire\Component;
use App\Models\Orders;
use App\Models\User;
use Carbon\Carbon;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $selectedDate;
    
    public function mount()
    {
        // tanggal hari ini
        $this->selectedDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');
    }

     public function render()
    {
        // Kembalikan view dengan membawa data, layout, dan title
        return $this->view([])
            ->layout('layouts::app')
            ->title('Wash Queue List'); 
    }   

    public function with()
    {

        // ambil branch_id dari session user yg sedang login
            $branchId = Auth::user()->branch_id;
        //tampung data orders
            $orders = [];
        // Ambil order berdasarkan tanggal masuk (atau tanggal estimasi selesai)
        // Beserta item sepatu, kategori, dan layanan
            $orders = Orders::with(['customers', 'items' => function($query){
            $query->whereIn('status',['pending','washing','drying','completed']);
        }, 'items.category', 'items.service'])
            ->whereDate('entry_date', $this->selectedDate)
            ->where('branch_id',$branchId)
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
            <h4 class="fw-bold mb-1 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Antrean Pengerjaan Harian
            </h4>
            <p class="text-muted mb-0 small">Pantau daftar sepatu yang masuk dan harus dikerjakan berdasarkan tanggal</p>
        </div>

        {{-- Filter Tanggal --}}
        <div class="d-flex align-items-center gap-2">
            <label for="filterDate" class="fw-semibold text-muted small mb-0">Pilih Tanggal:</label>
            <input type="date" id="filterDate" wire:model.live="selectedDate" class="form-control form-control-sm">
        </div>
    </div>

    {{-- Kartu Ringkasan Cepat Antrean Hari Ini --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
    <!-- Card dengan background gradasi dan teks putih -->
    <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);">
        <div class="card-body py-3">
            <h6 class="text-white-50 mb-1">Total Order Masuk</h6>
            <h5 class="fw-bold mb-0 text-white">
                {{ count($orders) }} Transaksi
            </h5>
        </div>
    </div>
</div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-white text-dark">
                <div class="card-body py-3">
                    <h6 class="text-dark mb-1 text-secondary" >Total Pasang Sepatu</h6>
                    <h5 class="fw-bold mb-0" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        {{ $orders->sum(function($order) { return $order->items->count(); }) }} Pasang
                    </h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-white text-dark">
                <div class="card-body py-3">
                    <h6 class="text-dark mb-1 text-secondary">Tanggal Antrean Aktif</h6>
                    <h5 class="fw-bold mb-0 mt-1" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Daftar Antrean --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="card-title fw-bold mb-0 text-dark">
                Rincian Sepatu di Antrean
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id='washqueueTable'>
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;" class="text-center">#</th>
                        <th>No. Order & Customer</th>
                        <th>Merk & Shoe Color</th>
                        <th>Category & Service</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th class="text-center">Estimated Finish</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $no = 1; 
                    @endphp
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
                                <td>
                                    <small class="text-secondary">{{ $item->notes ?? 'Tidak ada catatan' }}</small>
                                </td>
                                 <td class="text-center">
                                    <span >
                                        @if($item->status == 'pending')
                                            <span class="badge bg-secondary ">Pending</span>
                                        @elseif($item->status == 'washing')
                                            <span class="badge bg-info ">Washing</span>
                                        @elseif($item->status == 'drying')
                                            <span class="badge bg-warning ">Drying</span>
                                        @elseif($item->status == 'completed')
                                            <span class="badge bg-primary ">Completed</span>
                                        @elseif($item->status == 'received')
                                            <span class="badge bg-success ">Received</span>
                                        @else
                                            <span class="badge bg-dark">{{ $item->status }}</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                        {{ Carbon::parse($order->estimated_completion_date)->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orderdetail.index', $order->id) }}" wire:navigate class="btn btn-sm btn-outline-primary" title="Lihat Detail Order">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                         
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-mug-hot fa-2x mb-2 d-block text-secondary"></i>
                                Tidak ada antrean sepatu pada tanggal <strong>{{ Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</strong>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
            {{-- <div class="mt-4">
                {{ $orders->links() }}
            </div> --}}
</div>
</div>
   
</div>



<script>
    $(document).ready(function() {
        let table = new DataTable('#washqueueTable', {
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
