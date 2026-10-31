<?php

use Livewire\Component;
use App\Models\Orders;
use App\Models\Services;
use App\Models\Customers;
use App\Models\User;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


new class extends Component
{


    public $operationalOrders;

    public function mount()
    {
        $this->loadOperationalOrders();
    }
   public function loadOperationalOrders()
    {
        $branchId = Auth::user()->branch_id;

        $this->operationalOrders = [
            'pending' => Orders::where('branch_id', $branchId)->whereHas('items', function ($query) {
                        $query->where('status', 'pending'); 
                    })->get(),
            'washing' => Orders::where('branch_id', $branchId)->whereHas('items', function ($query) {
                        $query->where('status', 'washing'); 
                    })->get(),
            'drying' => Orders::where('branch_id', $branchId)->whereHas('items', function ($query) {
                        $query->where('status', 'drying'); 
                    })->get(),
            'completed' => Orders::where('branch_id', $branchId)->whereHas('items', function ($query) {
                        $query->where('status', 'completed'); 
                    })->get(),
            'received' => Orders::where('branch_id', $branchId)->whereHas('items', function ($query) {
                        $query->where('status', 'received'); 
                    })->get(),
        ];
    }
    

    public function render()
          {

            // Ambil branch_id user yang sedang login
          $branchId = Auth::user()->branch_id;

            $labels = [];
            $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $formattedDate = $date->format('Y-m-d');
            
            $chartLabels[] = $date->translatedFormat('d M Y');
            
            // Hitung order harian khusus untuk cabang user yang login
            $count = Orders::where('branch_id', $branchId)
                           ->whereDate('created_at', $formattedDate)
                           ->count();
            $chartData[] = $count;
        }
            // ambil tanggal hari ini
            $today = Carbon::today();
            // ambil tanggal kemarin
            $yesterday = Carbon::yesterday();

            // 1. Total Pendapatan Hari Ini (Order yang status bayarnya 'paid'/'lunas')
            $todayRevenue = Orders::whereDate('created_at', $today)
                ->where('payment_status', 'paid')
                ->where('branch_id', $branchId)
                ->sum('total_price');

            // 2. Pendapatan Kemarin (untuk perbandingan persentase)
            $yesterdayRevenue = Orders::whereDate('created_at', $yesterday)
                ->where('payment_status', 'paid')
                ->where('branch_id', $branchId)
                ->sum('total_price');

            // Hitung persentase kenaikan/penurunan
            $percentageChange = 0;
            if ($yesterdayRevenue > 0) {
                $percentageChange = (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100;
            } else {
                $percentageChange = $todayRevenue > 0 ? 100 : 0;
            }

            // 3. Breakdown per Metode Pembayaran (Cash, QRIS, Transfer)
            $breakdown = Orders::whereDate('created_at', $today)
                ->where('payment_status', 'paid')
                ->where('branch_id', $branchId)
                ->selectRaw('payment_method, sum(total_price) as total')
                ->groupBy('payment_method')
                ->pluck('total', 'payment_method')
                ->toArray();

            // data setelah dashboard card
           // 1. Total order hari ini & total pasang dari relasi items->sum('quantity')
                $totalOrderToday = Orders::whereDate('created_at', $today)->count();
                
                // Menghitung total pasang langsung via database query
                $totalPairsToday = Orders::whereDate('created_at', $today)
                    ->with('items')
                    ->where('branch_id', $branchId)
                    ->get();
                    

                // 2. Sepatu Selesai Hari Ini
                $finishedPairsToday = Orders::with(['items' => function ($query) {
                    $query->where('status', 'completed');}])
                    ->whereDate('updated_at', $today)
                    ->where('branch_id', $branchId)
                    ->get();
                    

                // 3. Jatuh Tempo / Overdue
                $overdueCount = Orders::with(['items' => function ($query) {
                    $query->where('status', 'completed');}])
                    ->whereDate('estimated_completion_date', '<', $today)
                    ->whereHas('items', function ($query) {
                        $query->where('status', 'completed'); 
                    })
                    ->where('branch_id', $branchId)
                    ->get();



          return $this->view([
              'branchId' => $branchId,
              'orders'   => Orders::where('branch_id', $branchId)->get(),
              'services' => Services::get(),
              'customers'=> Customers::where('branch_id', $branchId)->get(),
              'washqueue' => OrderDetail::whereNotIn('status', ['received', 'completed'])
                  ->where('branch_id', $branchId) 
                  ->latest()
                  ->get(),
              'labels'     => $chartLabels,
              'data'       => $chartData,
              'todayRevenue' => $todayRevenue,
              'percentageChange' => round($percentageChange, 1),
              'breakdown' => $breakdown,
              'totalOrderToday' => $totalOrderToday,
              'totalPairsToday' => $totalPairsToday,
              'finishedPairsToday' => $finishedPairsToday,
              'overdueCount' => $overdueCount,

          ])
          ->layout('layouts::app')
          ->title('Dashboard');
          
      }


};

?>

<div>
   <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    SELAMAT DATANG, {{auth()->user()->name}}! 
                </h5>
                <p class="text-muted mb-0 small">
                    Berikut adalah ringkasan operasional dan transaksi sepatu hari ini.
                </p>
            </div>
            <div>
                {{-- Menampilkan Tanggal Hari Ini --}}
                <span class="badge bg-white text-dark border px-3 py-2 shadow-sm">
                    <i class="fa-regular fa-calendar me-2 text-primary"></i>
                    {{ \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('D MMMM Y') }}
                </span>
            </div>
        </div>
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
        <div class="row mb-3">
            <div class="col-lg-3 col-6">
                        <div class="card border-0 shadow-sm bg-white text-dark border-start border-primary border-4">
                            <div class="card-body py-3">
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">
                                    {{-- <i class="fa-solid fa-users me-1 text-primary"></i>--}} Total Pesanan 
                                </h6>
                                <h1 class="fw-bold mb-0 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{$orders->count()}}</h4>
                                <small class="text-muted">Data Pesanan masuk </small>
                            </div>
                        </div>
              </div>
              <!--end::Col-->

              <div class="col-lg-3 col-6">
                        <div class="card border-0 shadow-sm bg-white text-dark border-start border-primary border-4">
                            <div class="card-body py-3">
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">
                                    {{-- <i class="fa-solid fa-users me-1 text-primary"></i>--}}Total Layanan 
                                </h6>
                                <h1 class="fw-bold mb-0 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{$services->count()}}</h4>
                                <small class="text-muted">Data Layanan tersedia </small>
                            </div>
                        </div>
              </div>

              <!--end::Col-->
                <div class="col-lg-3 col-6">

                            <div class="card border-0 shadow-sm bg-white text-dark border-start border-primary border-4">
                                <div class="card-body py-3">
                                    <h6 class="text-uppercase text-muted mb-1 small fw-bold">
                                        {{-- <i class="fa-solid fa-users me-1 text-primary"></i>--}} Antrean 
                                    </h6>
                                    <h1 class="fw-bold mb-0 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{$washqueue->count()}}</h4>
                                    <small class="text-muted">Data Antrean per hari </small>
                                </div>
                            </div>
                </div>
             <div class="col-lg-3 col-6">
                        <div class="card border-0 shadow-sm bg-white text-dark border-start border-primary border-4">
                            <div class="card-body py-3">
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">
                                    {{-- <i class="fa-solid fa-users me-1 text-primary"></i>--}} Total Customers 
                                </h6>
                                <h1 class="fw-bold mb-0 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{$customers->count()}}</h4>
                                <small class="text-muted">Data customer Aktif</small>
                            </div>
                        </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
    
            {{-- row realtime orders --}}
                <div class="row mt-5">
                        <div class="col-lg-12" wire:poll.30s wire:key="orders-today">
                            <!-- Container Utama (Model Clean Bar / Tanpa Card Terpisah) -->
                            <div  class="bg-white rounded-4 p-4 shadow-sm border border-light mb-4">
                                <div class="row align-items-center g-4">
                                    
                                    <!-- 1. ORDER HARI INI -->
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <!-- Icon Box dengan Background Soft Primary -->
                                            <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-4 me-3">
                                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="d-block text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Order Hari Ini</span>
                                                <div class="d-flex align-items-baseline gap-2 mt-1">
                                                    <h3 class="fs-4 fw-bold text-dark mb-0">{{ $totalOrderToday ?? 0 }}</h3>
                                                    <span class="text-secondary" style="font-size: 12px;">Nota ({{ $totalPairsToday->sum(function($pairsToday) { return $pairsToday->items->count(); }) }} Pasang)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2. SEPATU SELESAI -->
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <!-- Icon Box dengan Background Soft Success -->
                                            <div class="p-3 bg-success bg-opacity-10 text-success rounded-4 me-3">
                                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="d-block text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Siap Diambil/Kirim</span>
                                                <div class="d-flex align-items-baseline gap-2 mt-1">
                                                    <h3 class="fs-4 fw-bold text-dark mb-0">{{ $finishedPairsToday->sum(function($finishedPairs) { return $finishedPairs->items->count(); }) }}</h3>
                                                    <span class="text-success fw-medium" style="font-size: 12px;">Pasang Sepatu</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 3. JATUH TEMPO / OVERDUE -->
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <!-- Icon Box dengan Background Soft Danger -->
                                            <div class="p-3 bg-danger bg-opacity-10 text-danger rounded-4 me-3 position-relative">
                                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="d-block text-danger text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Jatuh Tempo</span>
                                                <div class="d-flex align-items-baseline gap-2 mt-1">
                                                    <h3 class="fs-4 fw-bold text-danger mb-0">{{ $overdueCount->sum(function($duedate) { return $duedate->items->count(); }) }}</h3>
                                                    <span class="text-danger fw-medium" style="font-size: 12px;">Nota Terlambat selesai</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                </div>

            {{-- tracking workflow realtime --}}

            <div class="row mt-5">
                <div class="col-lg-12">
                <!-- Container Status Operasional Sepatu (Tracking Workflow) -->
                <div wire:poll.30s wire:key="operational-workflow-status" class="bg-white rounded-4 p-4 shadow-sm border border-light mb-4">
                    
                    <!-- Judul Section & Keterangan Singkat -->
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-light">
                        <div>
                            <h5 class="fw-bold text-dark mb-1" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 20%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">TRACKING WORKFLOW PENGERJAAN</h5>
                            <p class="text-muted small mb-0">Pantau posisi fisik sepatu di setiap tahapan proses secara real-time.</p>
                        </div>
                        <span class="badge bg-light text-secondary fw-normal">Live Auto-Refresh</span>
                    </div>

                    <!-- Grid Workflow (Dibagi menjadi 5 tahapan) -->
                    <div class="row g-3">
                        
                        <!-- 1. WAITING / QUEUE -->
                        <div class="col-md-2 col-6">
                            <div class="p-3 bg-light rounded-3 text-center border border-light h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <span class="d-block text-secondary text-uppercase fw-semibold" style="font-size: 10px; letter-spacing: 0.5px;">Antrean / Waiting</span>
                                    <h3 class="fs-4 fw-bold text-dark mt-2 mb-0">{{ $operationalOrders['pending']->count() ?? 0 }}</h3>
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary w-100 py-1" style="font-size: 11px;">Belum Disentuh</span>
                                </div>
                            </div>
                        </div>

                        <!-- 2. IN PROGRESS (WASHING / CLEANING) -->
                        <div class="col-md-2 col-6">
                            <div class="p-3 bg-primary bg-opacity-10 rounded-3 text-center border border-primary border-opacity-10 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <span class="d-block text-primary text-uppercase fw-semibold" style="font-size: 10px; letter-spacing: 0.5px;">Proses Cuci</span>
                                    <h3 class="fs-4 fw-bold text-primary mt-2 mb-0">{{ $operationalOrders['washing']->count() ?? 0 }}</h3>
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-primary bg-opacity-25 text-primary w-100 py-1" style="font-size: 11px;">Washing/Cleaning</span>
                                </div>
                            </div>
                        </div>

                        <!-- 3. DRYING -->
                        <div class="col-md-2 col-6">
                            <div class="p-3 bg-warning bg-opacity-10 rounded-3 text-center border border-warning border-opacity-10 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <span class="d-block text-warning text-uppercase fw-semibold" style="font-size: 10px; letter-spacing: 0.5px;">Pengeringan</span>
                                    <h3 class="fs-4 fw-bold text-warning text-dark mt-2 mb-0">{{ $operationalOrders['drying']->count() ?? 0 }}</h3>
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-warning bg-opacity-25 text-dark w-100 py-1" style="font-size: 11px;">Drying/Treatment</span>
                                </div>
                            </div>
                        </div>

                        <!-- 4. QC / FINISHING -->
                        <div class="col-md-3 col-6">
                            <div class="p-3 bg-info bg-opacity-10 rounded-3 text-center border border-info border-opacity-10 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <span class="d-block text-info text-uppercase fw-semibold" style="font-size: 10px; letter-spacing: 0.5px;">Finishing </span>
                                    <h3 class="fs-4 fw-bold text-info mt-2 mb-0">{{ $operationalOrders['completed']->count() ?? 0 }}</h3>
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-info bg-opacity-25 text-info w-100 py-1" style="font-size: 11px;">Selesai & ready</span>
                                </div>
                            </div>
                        </div>

                        <!-- 5. READY FOR PICKUP / DELIVERY -->
                        <div class="col-md-3 col-12">
                            <div class="p-3 bg-success bg-opacity-10 rounded-3 text-center border border-success border-opacity-10 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <span class="d-block text-success text-uppercase fw-semibold" style="font-size: 10px; letter-spacing: 0.5px;">Telah diterima customer</span>
                                    <h3 class="fs-4 fw-bold text-success mt-2 mb-0">{{ $operationalOrders['received']->count() ?? 0 }}</h3>
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-success bg-opacity-25 text-success w-100 py-1" style="font-size: 11px;">Received</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                </div>
            </div>
            
            {{--row grafik orderan perhari dan pendapatan perhari --}}
            <div class="row mt-5">
                        <!-- Start col -->
                <div class="col-lg-7 connectedSortable" wire:poll.30s wire:key="grafik-chart">
                        <div class="card border-0 shadow-sm bg-white mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 20%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                    GRAFIK ORDER PER 7 DAYS
                                </h5>
                                
                                <!-- Canvas untuk Chart.js -->
                                <div style="position: relative; height:300px; width:100%" wire:poll.30s>
                                    <canvas id="orderChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                
                <div class="col-lg-5" wire:poll.30s wire:key="today-revenue" >
                    <!-- Card Utama dengan Background Gradient Glass -->
                    <div class="card border-0 shadow-sm mb-4 text-white overflow-hidden" style="background: linear-gradient(135deg, rgba(13, 110, 253, 0.85) 0%, rgba(102, 16, 242, 0.85) 100%); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
                        
                        <!-- Bagian Atas: Judul & Nominal -->
                        <div class="card-body d-flex align-items-center justify-between pb-0">
                            <div>
                                <h5 class="text-white-50 mb-1 fs-6 text-uppercase tracking-wider">Pendapatan Hari Ini</h5>
                                <h3 class="fs-3 fw-bold text-white mb-0">
                                    Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                                </h3>
                            </div>
                        </div>

                        <!-- Bagian Bawah: Row untuk Perbandingan & Breakdown -->
                        <div class="card-body pt-3">
                            <div class="row align-items-center g-3">
                                
                                <!-- Kolom 1: Indikator Perbandingan Kemarin -->
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center fs-6">
                                        @if($percentageChange >= 0)
                                            <span class="text-success fw-semibold d-flex align-items-center bg-success bg-opacity-25 px-2 py-1 rounded-pill me-2">
                                                ↗ +{{ $percentageChange }}%
                                            </span>
                                        @else
                                            <span class="text-danger fw-semibold d-flex align-items-center bg-danger bg-opacity-25 px-2 py-1 rounded-pill me-2">
                                                ↘ {{ $percentageChange }}%
                                            </span>
                                        @endif
                                        <span class="text-white-50 small">dari kemarin</span>
                                    </div>
                                </div>

                                <!-- Kolom 2: Breakdown Metode Pembayaran -->
                                <div class="col-lg-6">
                                    <div class="border-top border-white border-opacity-10 pt-3">
                                        <p class="small text-white-50 text-uppercase fw-semibold mb-2" style="font-size: 11px;">Rincian Metode</p>
                                        
                                        <!-- Grid 3 Kolom untuk Cash, QRIS, Transfer -->
                                        <div class="row g-2">
                                            <!-- Card Cash -->
                                            <div class="col-4">
                                                <div class="bg-white bg-opacity-10 border border-white border-opacity-20 p-2 rounded text-center">
                                                    <div class="d-flex align-items-center justify-content-center gap-1 mb-1">
                                                        <span class="spinner-grow spinner-grow-sm bg-success rounded-circle" style="width: 6px; height: 6px;" role="status"></span>
                                                        <span class="small fw-bold text-white" style="font-size: 11px;">Cash</span>
                                                    </div>
                                                    <span class="fw-bold text-white d-block" style="font-size: 11px;">
                                                        Rp {{ number_format($breakdown['cash'] ?? 0, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Card QRIS -->
                                            <div class="col-4">
                                                <div class="bg-white bg-opacity-10 border border-white border-opacity-20 p-2 rounded text-center">
                                                    <div class="d-flex align-items-center justify-content-center gap-1 mb-1">
                                                        <span class="spinner-grow spinner-grow-sm bg-info rounded-circle" style="width: 6px; height: 6px;" role="status"></span>
                                                        <span class="small fw-bold text-white" style="font-size: 11px;">QRIS</span>
                                                    </div>
                                                    <span class="fw-bold text-white d-block" style="font-size: 11px;">
                                                        Rp {{ number_format($breakdown['qris'] ?? 0, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Card Transfer -->
                                            <div class="col-4">
                                                <div class="bg-white bg-opacity-10 border border-white border-opacity-20 p-2 rounded text-center">
                                                    <div class="d-flex align-items-center justify-content-center gap-1 mb-1">
                                                        <span class="spinner-grow spinner-grow-sm bg-warning rounded-circle" style="width: 6px; height: 6px;" role="status"></span>
                                                        <span class="small fw-bold text-white" style="font-size: 11px;">Transfer</span>
                                                    </div>
                                                    <span class="fw-bold text-white d-block" style="font-size: 11px;">
                                                        Rp {{ number_format($breakdown['transfer'] ?? 0, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                    </div>
                </div>

            </div>
</div>
    </div>
           @script
            <script>
                let myOrderChart = null;

                // Inisialisasi awal saat halaman dimuat
                document.addEventListener('DOMContentLoaded', () => initChart());
                document.addEventListener('livewire:navigated', () => initChart());

                // Tangkap setiap kali Livewire selesai melakukan update (termasuk setelah wire:poll)
                Livewire.hook('morph.updated', ({ el, component }) => {
                    // Pastikan hanya merender ulang jika elemen canvas ada di dalam komponen yang di-poll
                    if (el.querySelector('#orderChart') || document.getElementById('orderChart')) {
                        initChart();
                    }
                });

                function initChart() {
                    const canvas = document.getElementById('orderChart');
                    if (!canvas) return; 

                    const ctx = canvas.getContext('2d');

                    // Hancurkan chart lama jika ada agar tidak menumpuk/error
                    if (myOrderChart) {
                        myOrderChart.destroy();
                    }

                    // Ambil data langsung dari elemen atau variabel PHP yang dirender ke blade
                    let labelsData = {!! json_encode($labels ?? []) !!};
                    let valuesData = {!! json_encode($data ?? []) !!};

                    let gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(13, 110, 253, 0.4)');
                    gradient.addColorStop(1, 'rgba(102, 16, 242, 0.0)');

                    myOrderChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labelsData,
                            datasets: [{
                                label: 'Jumlah Order',
                                data: valuesData,
                                borderColor: '#6610f2',
                                backgroundColor: gradient,
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { stepSize: 1 },
                                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                                },
                                x: {
                                    grid: { display: false }
                                }
                            }
                        }
                    });
                }
            </script>
            @endscript
        
                </div>
                </div>
                </div>
              <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
</div>

