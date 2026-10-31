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
        // Set default tanggal hari ini (WIB)
        $this->selectedDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');

    }

    public function with()
    {

        $branchId = Auth::user()->branch_id;
        $orders = [];
        // Ambil data order untuk tabel rincian
        $orders = Orders::with(['customers', 'items.category','items' => function ($query) {
            $query->where('status', 'received'); 
                    }, 'items.service'])
            ->whereDate('entry_date', $this->selectedDate)
            ->whereHas('items', function ($query) {
                    $query->where('status', 'received');
                })
            ->where('branch_id',$branchId)
            ->latest()
            ->get();

        $allOrdersForDate = [];
        // Ambil semua data pada tanggal tersebut untuk kalkulasi rekap pembayaran
        $allOrdersForDate = Orders::with(['items' => function ($query) {
                                $query->where('status', 'received'); 
                                        }, 'items.service'])
                                ->whereDate('entry_date', $this->selectedDate)
                                ->whereHas('items', function ($query) {
                                        $query->where('status', 'received');
                                    })
                                ->where('branch_id',$branchId)
                                ->get();

        //hitung total harga per item dengan payment_method received aja
        $paymentSummary = $allOrdersForDate->groupBy('payment_method')->map(function ($group) {
                return [
                    'total_amount' => $group->sum(function ($order) {
                        return $order->items->sum('price'); 
                    }),
                    'total_transactions' => $group->count()
                ];
        });
        // total transaksi pada tanggal yg dipilih user
        $totalTransactions = $allOrdersForDate->count();
        // total hasil pendapatan pada tanggal tersebut
        $totalRevenue = $allOrdersForDate->sum(function ($order) {
            return $order->items->sum('price'); 
        });


         // total per method pembayaran
        $totalCash = $allOrdersForDate->where('payment_method', 'cash')->sum(function ($order) {
                        return $order->items->sum('price'); 
                    });
        $totalTransfer = $allOrdersForDate->where('payment_method', 'transfer')->sum(function ($order) {
                        return $order->items->sum('price'); 
                    });
        $totalQris = $allOrdersForDate->where('payment_method', 'qris')->sum(function ($order) {
                        return $order->items->sum('price'); 
                    });



        // kembalikan ke view
        return [
            'orders' => $orders,
            'paymentSummary' => $paymentSummary,
            'totalTransactions' => $totalTransactions,
            'totalRevenue' => $totalRevenue,
            'totalCash'=>$totalCash,
            'totalTransfer'=>$totalTransfer,
            'totalQris'=>$totalQris,
        ];
    }

      public function render()
    {
        // Kembalikan view dengan membawa data, layout, dan title
        return $this->view([
        ])
            ->layout('layouts::app')
            ->title('Reports Daily'); 
    }  
}; ?>

<div class="container-fluid mt-4 mb-5">
    <div class="row">
        <div class="col-md-12">
            
            {{-- Header Halaman & Filter Tanggal --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3 bg-white p-4 rounded shadow-sm border">
                <div>
                    <h4 class="fw-bold mb-1 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        <i class="fa-solid fa-file-invoice-dollar text-primary me-2" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i> Laporan Harian 
                    </h4>
                    <p class="text-muted mb-0 small">Rekapitulasi metode pembayaran dan rincian item sepatu masuk</p>
                </div>

                {{-- Filter Tanggal & Tombol Cetak --}}
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <label for="filterDate" class="fw-semibold text-muted small mb-0">Pilih Tanggal:</label>
                        <input type="date" id="filterDate" wire:model.live="selectedDate" class="form-control form-control-sm">
                    </div>
                </div>
            </div>

            {{-- Ringkasan Total per Metode Pembayaran --}}
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm  text-white"  style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);">
                        <div class="card-body py-3">
                            <h6 class="text-white-50 mb-1">Total Pendapatan</h6>
                            <h4 class="fw-bold mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                            <small class="text-white-50">{{ $totalTransactions }} Transaksi</small>
                        </div>
                    </div>
                </div>

                {{-- Looping Rekap Per Metode Pembayaran (Cash, Transfer, QRIS, dll) --}}
                @forelse($paymentSummary as $method => $data)
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm bg-white text-dark border-start border-primary border-4">
                            <div class="card-body py-3">
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">
                                    <i class="fa-solid fa-wallet me-1 text-primary"></i> {{ $method ? $method : 'Belum Ditentukan' }}
                                </h6>
                                <h4 class="fw-bold mb-0 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Rp {{ number_format($data['total_amount'], 0, ',', '.') }}</h4>
                                <small class="text-muted">{{ $data['total_transactions'] }} Transaksi</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-9">
                        <div class="card border-0 shadow-sm bg-light text-muted">
                            <div class="card-body py-3 text-center">
                                <small>Belum ada data pembayaran tercatat pada tanggal ini.</small>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Tabel Rincian Seluruh Item Sepatu Sesuai Tanggal --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-bold mb-0 text-dark">
                        Rincian Item Sepatu & Transaksi: <span class="text-primary">{{ Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</span>
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id='reportDailyTable'>
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;" class="text-center">#</th>
                                <th>ORDER ID </th>
                                <th>CUSTOMERS</th>
                                <th>NO HP</th>
                                <th>DETAIL SHOES & BRAND</th>
                                <th>COLOR</th>
                                <th>CATEGORY</th>
                                <th>SERVICES</th>
                                <th>PAYMENT METHOD</th>
                                <th class="text-center">ITEMS STATUS</th>
                                <th class="text-end">TOTAL ORDER</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $no =  1; 
                            @endphp
                            @forelse($orders as $order)
                            {{-- perulangan untuk ambil data item di tabel relasi detail order --}}
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="text-center fw-bold text-muted">{{ $no++ }}</td>
                                        <td>                    
                                            <span class="font-monospace fw-bold text-primary">{{ $order->order_number }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $order->customers->name ?? 'Guest' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted text-dark">{{ $order->customers->phone ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark">{{ $item->brand }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted d-block">{{ $item->color }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $item->category->name ?? 'Sneakers' }}</span>
                                        </td>
                                        <td>
                                            <span class="d-block small text-primary fw-semibold mt-1">
                                                </i>{{ $item->service->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">
                                                {{ $order->payment_method ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($item->status == 'pending')
                                                <span class="badge bg-secondary">Pending</span>
                                            @elseif($item->status == 'washing')
                                                <span class="badge bg-info">Washing</span>
                                            @elseif($item->status == 'drying')
                                                <span class="badge bg-warning">Drying</span>
                                            @elseif($item->status == 'completed')
                                                <span class="badge bg-primary">Completed</span>
                                            @elseif($item->status == 'received')
                                                <span class="badge bg-success">Received</span>
                                            @else
                                                <span class="badge bg-dark">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end fw-semibold text-dark">
                                            Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}
                                        </td>

                                    </tr>
                                @endforeach
                                  
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fa-2x mb-2 d-block text-secondary"></i>
                                        Tidak ada data laporan transaksi pada tanggal <strong>{{ Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</strong>.
                                    </td>
                                </tr>
                            @endforelse

                            
                            <tr class="table-light">
                                <td class="text-start text-secondary">Cash (Tunai):</td>
                                <td class="text-dark">Rp {{ number_format($totalCash ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="table-light">
                                <td class="text-start text-secondary">Transfer Bank:</td>
                                <td  class="text-dark">Rp {{ number_format($totalTransfer ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="table-light">
                                <td  class="text-start text-secondary">QRIS:</td>
                                <td  class="text-dark">Rp {{ number_format($totalQris ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="table-light fw-bold">
                                <td class="text-start">Total Pendapatan:</td>
                                <td  class="text-success">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</td>
                            </tr>
                    </tbody>        
                </table>

                </div>
            </div>


        </div>
    </div>
</div>

@assets
<style>
@media print {
    body {
        background-color: white !important;
    }
    .d-print-none, .sidebar, nav, header, footer {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endassets


<script>
    $(document).ready(function() {
        let table = new DataTable('#reportDailyTable', {
            pageLength:50,
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

