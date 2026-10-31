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

            $today = Carbon::today();
            $yesterday = Carbon::yesterday();

            // 1. Total Pendapatan Hari Ini (Order yang status bayarnya 'paid'/'lunas')
            $todayRevenue = Orders::whereDate('created_at', $today)
                ->where('payment_status', 'paid')
                ->sum('total_price');

            // 2. Pendapatan Kemarin (untuk perbandingan persentase)
            $yesterdayRevenue = Orders::whereDate('created_at', $yesterday)
                ->where('payment_status', 'paid')
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
                ->selectRaw('payment_method, sum(total_price) as total')
                ->groupBy('payment_method')
                ->pluck('total', 'payment_method')
                ->toArray();

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
              'breakdown' => $breakdown
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
                <h4 class="fw-bold mb-1 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    Selamat Datang, {{auth()->user()->name}}! 
                </h4>
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
              <!--begin::Col-->
             <div class="col-lg-3 col-6">
                        <div class="card border-0 shadow-sm bg-white text-dark border-start border-primary border-4">
                            <div class="card-body py-3">
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">
                                    {{-- <i class="fa-solid fa-users me-1 text-primary"></i>--}} Pesanan 
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
                                    {{-- <i class="fa-solid fa-users me-1 text-primary"></i>--}} Layanan 
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
          

              <!--end::Col-->
             <div class="col-lg-3 col-6">
                        <div class="card border-0 shadow-sm bg-white text-dark border-start border-primary border-4">
                            <div class="card-body py-3">
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">
                                    {{-- <i class="fa-solid fa-users me-1 text-primary"></i>--}} Customers 
                                </h6>
                                <h1 class="fw-bold mb-0 text-dark" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{$customers->count()}}</h4>
                                <small class="text-muted">Data customer Aktif</small>
                            </div>
                        </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
    <div class="row mt-5">
              <!-- Start col -->
        <div class="col-lg-7 connectedSortable">
            <div class="card border-0 shadow-sm bg-white mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 20%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Grafik Orderan per Hari
                    </h5>
                    
                    <!-- Canvas untuk Chart.js -->
                    <div style="position: relative; height:300px; width:100%">
                        <canvas id="orderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        

            <div class="col-lg-5">
            <!-- Tambahkan wire:poll agar data otomatis refresh setiap 30 detik -->
                <div class="card border-0 shadow-sm bg-white mb-4" style="background: linear-gradient(135deg, rgba(13, 110, 253, 0.85) 0%, rgba(102, 16, 242, 0.85) 100%); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
                    <div class="flex items-center justify-between card-body">
                        <div>
                            <h5 class="fw-bold mb-3 text-white" >Pendapatan Hari Ini</h4>
                            <h3 class="text-2xl font-bold text-gray mt-1 ">
                                Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                            </h3>
                        </div>

                </div>

            <div class="row">
                <div class="col-lg-6">
                    <!-- Indikator Perbandingan dengan Kemarin -->
                    <div class="mt-4 flex items-center text-sm card-body">
                        @if($percentageChange >= 0)
                            <span class="text-emerald-600 font-semibold flex items-center">
                                ↗ +{{ $percentageChange }}%
                            </span>
                        @else
                            <span class="text-rose-600 font-semibold flex items-center">
                                ↘ {{ $percentageChange }}%
                            </span>
                        @endif
                        <span class="text-gray-500 ml-2">dari kemarin</span>
                    </div>
                    </div>
                <div class="col-lg-6">

                    <!-- Breakdown Metode Pembayaran -->
                    <div class="mt-4 pt-4 border-t border-gray-100 text-white">
                            <p >Rincian Metode Pembayaran</p>
                            
                            <div class="grid grid-cols-3 gap-3">
                                <!-- Card Cash -->
                                <div class="bg-gray-50/80 hover:bg-gray-50 border border-gray-200/60 p-2.5 rounded-lg text-center transition-all">
                                    <div class="flex items-center justify-center space-x-1 mb-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span class="text-xs font-medium text-gray-500 fw-bold">Cash</span>
                                    </div>
                                    <span class="text-xs font-bold text-gray-800 block">
                                        Rp {{ number_format($breakdown['cash'] ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Card QRIS -->
                                <div class="bg-gray-50/80 hover:bg-gray-50 border border-gray-200/60 p-2.5 rounded-lg text-center transition-all">
                                    <div class="flex items-center justify-center space-x-1 mb-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                        <span class="text-xs font-medium text-gray-500 fw-bold">QRIS</span>
                                    </div>
                                    <span class="text-xs font-bold text-gray-800 block">
                                        Rp {{ number_format($breakdown['qris'] ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Card Transfer -->
                                <div class="bg-gray-50/80 hover:bg-gray-50 border border-gray-200/60 p-2.5 rounded-lg text-center transition-all">
                                    <div class="flex items-center justify-center space-x-1 mb-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                        <span class="text-xs font-medium text-gray-500 fw-bold" >Transfer</span>
                                    </div>
                                    <span class="text-xs font-bold text-gray-800 block">
                                        Rp {{ number_format($breakdown['transfer'] ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
             </div>
    
    </div>
        @script
            <script>
                    // Variabel global untuk menyimpan instance chart agar bisa di-destroy nantinya
                    let myOrderChart = null;

                    // Jalankan saat pertama kali halaman dimuat (full reload) atau setelah navigasi Livewire
                    document.addEventListener('DOMContentLoaded', initChart);
                    document.addEventListener('livewire:navigated', initChart);

                    function initChart() {
                        const canvas = document.getElementById('orderChart');
                        
                        // Pastikan elemen canvas benar-benar ada di halaman saat ini
                        if (!canvas) return; 

                        const ctx = canvas.getContext('2d');

                        // 1. Hancurkan chart lama jika sudah ada (mencegah error canvas is already in use)
                        if (myOrderChart) {
                            myOrderChart.destroy();
                        }

                        // 2. Buat ulang efek gradasi warna
                        let gradient = ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(13, 110, 253, 0.4)');
                        gradient.addColorStop(1, 'rgba(102, 16, 242, 0.0)');

                        // 3. Render chart baru dan simpan ke variabel global
                        myOrderChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: {!! json_encode($labels) !!},
                                datasets: [{
                                    label: 'Jumlah Order',
                                    data: {!! json_encode($data) !!},
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
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        },
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)'
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        }
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

