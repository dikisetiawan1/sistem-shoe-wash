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
                  'data'       => $chartData
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
                    <h5 class="fw-bold mb-3" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Grafik Orderan per Hari
                    </h5>
                    
                    <!-- Canvas untuk Chart.js -->
                    <div style="position: relative; height:300px; width:100%">
                        <canvas id="orderChart"></canvas>
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
                <!-- /.card -->

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

