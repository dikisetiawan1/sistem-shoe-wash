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
            <div class="row">
              <!--begin::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 1 (Diubah menjadi style bg-white modern) -->
                <div class="small-box bg-white border-0 shadow-sm position-relative overflow-hidden" style="border-radius: 0.5rem;">
                    <div class="inner p-3">
                        <!-- Angka dengan efek teks gradasi -->
                        <h3 class="fw-bold mb-1" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            {{ $orders->count() }}
                        </h3>
                        <p class="text-muted mb-0 font-weight-normal">Data Pesanan</p>
                    </div>

                    <!-- Ikon SVG sebagai watermark transparan di pojok kanan bawah -->
                    <svg 
                        class="small-box-icon position-absolute" 
                        style="right: -10px; bottom: -15px; width: 90px; height: 90px; opacity: 0.08; pointer-events: none;"
                        fill="currentColor" 
                        viewBox="0 0 24 24" 
                        xmlns="http://www.w3.org/2000/svg" 
                        aria-hidden="true">
                        <path 
                            fill-rule="evenodd" 
                            d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V3.375c0-1.036-.84-1.875-1.875-1.875H5.625ZM7.5 6a.75.75 0 0 0 0 1.5h9a.75.75 0 0 0 0-1.5h-9Zm0 3.75a.75.75 0 0 0 0 1.5h9a.75.75 0 0 0 0-1.5h-9Zm0 3.75a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 0-1.5h-6Z" 
                            clip-rule="evenodd">
                        </path>
                    </svg>

                    <!-- Footer link aksi -->
                    <a
                        href="{{route('admin.orders.index')}}"
                        class="small-box-footer text-center py-1 d-block text-decoration-none"
                        style="background: rgba(0, 0, 0, 0.02); color: #6c757d; font-size: 0.85rem;"
                    >
                        Lihat data <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
                <!--end::Small Box Widget 1-->
            </div>
              <!--end::Col-->

              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box bg-white text-dark shadow-sm border-0">
                  <div class="inner">
                      <!-- Angka dengan efek gradasi modern -->
                      <h3 class="fw-bold" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                          {{ $services->count() }}
                      </h3>
                      <p class="text-secondary mb-0">Data Layanan</p>
                  </div>

                  <!-- Ikon SVG dengan warna abu-abu elegan agar kontras di background putih -->
                  <svg 
                      class="small-box-icon text-black-50" 
                      fill="currentColor" 
                      viewBox="0 0 24 24" 
                      xmlns="http://www.w3.org/2000/svg" 
                      aria-hidden="true"
                      style="opacity: 0.15;">
                      <path 
                          fill-rule="evenodd" 
                          d="M2.25 6a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H3a.75.75 0 0 1-.75-.75V6Zm0 6a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H3a.75.75 0 0 1-.75-.75V12Zm0 6a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H3a.75.75 0 0 1-.75-.75V18ZM6.75 6.75a.75.75 0 0 0 0 1.5h14.25a.75.75 0 0 0 0-1.5H6.75Zm0 6a.75.75 0 0 0 0 1.5h14.25a.75.75 0 0 0 0-1.5H6.75Zm0 6a.75.75 0 0 0 0 1.5h14.25a.75.75 0 0 0 0-1.5H6.75Z" 
                          clip-rule="evenodd">
                      </path>
                  </svg>

                  <!-- Footer small-box disesuaikan agar teksnya terlihat jelas di background putih -->
                  <a
                      href="{{ route('admin.services.index') }}"
                      class="small-box-footer link-primary link-underline-opacity-0 link-underline-opacity-75-hover fw-semibold"
                      style="background-color: rgba(0,0,0,0.02);"
                  >
                      Lihat data <i class="bi bi-link-45deg"></i>
                  </a>
              </div>
                <!--end::Small Box Widget 2-->
              </div>



              <!--end::Col-->
          <div class="col-lg-3 col-6">
            <!--begin::Small Box Widget 3-->
            <div class="small-box bg-white text-dark shadow-sm border-0">
                <div class="inner">
                    <!-- Angka dengan efek gradasi modern -->
                    <h3 class="fw-bold" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        {{ $washqueue->count() }}
                    </h3>

                    <p class="text-secondary mb-0">Data antrean (harian)</p>
                </div>

                <!-- Ikon SVG dengan opasitas tipis sebagai watermark -->
                <svg 
                    class="small-box-icon text-black-50" 
                    fill="currentColor" 
                    viewBox="0 0 24 24" 
                    xmlns="http://www.w3.org/2000/svg" 
                    aria-hidden="true"
                    style="opacity: 0.15;">
                    <path 
                        fill-rule="evenodd" 
                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .2.079.39.22.53l3.75 3.75a.75.75 0 1 0 1.06-1.06l-3.53-3.53V6Z" 
                        clip-rule="evenodd">
                    </path>
                </svg>

                <!-- Footer kecil dengan warna yang kontras di background putih -->
                <a
                    href="{{ route('admin.washqueue.index') }}"
                    class="small-box-footer link-primary link-underline-opacity-0 link-underline-opacity-75-hover fw-semibold"
                    style="background-color: rgba(0,0,0,0.02);"
                >
                    Lihat data <i class="bi bi-link-45deg"></i>
                </a>
                      </div>
              <!--end::Small Box Widget 3-->
          </div>


              <!--end::Col-->
             <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 4-->
                <div class="small-box bg-white text-dark shadow-sm border-0">
                    <div class="inner">
                        <!-- Angka dengan efek gradasi modern -->
                        <h3 class="fw-bold" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            {{ $customers->count() }}
                        </h3>

                        <p class="text-secondary mb-0">Data Pelanggan</p>
                    </div>

                    <!-- Ikon SVG dengan opasitas tipis sebagai watermark -->
                    <svg 
                        class="small-box-icon text-black-50" 
                        fill="currentColor" 
                        viewBox="0 0 24 24" 
                        xmlns="http://www.w3.org/2000/svg" 
                        aria-hidden="true"
                        style="opacity: 0.15;">
                        <path 
                            d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a11.54 11.54 0 0 1-1.192 3.123 14.542 14.542 0 0 0 5.193-1.428.75.75 0 0 0 .364-.63l.001-.122a7.125 7.125 0 0 0-4.365-6.559 5.625 5.625 0 0 1 0 5.472Z">
                        </path>
                    </svg>

                    <!-- Footer kecil dengan warna yang kontras dan elegan -->
                    <a
                        href="{{ route('admin.customers.index') }}"
                        class="small-box-footer link-primary link-underline-opacity-0 link-underline-opacity-75-hover fw-semibold"
                        style="background-color: rgba(0,0,0,0.02);"
                    >
                        Lihat data <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
                <!--end::Small Box Widget 4-->
            </div>
                          <!--end::Col-->
                        </div>



            <!--end::Row-->
            <!--begin::Row-->
            <div class="row">
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

            <script>
            document.addEventListener("DOMContentLoaded", function () {
                const ctx = document.getElementById('orderChart').getContext('2d');

                // Membuat efek gradasi warna untuk chart
                let gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(13, 110, 253, 0.4)'); // Biru transparan di atas
                gradient.addColorStop(1, 'rgba(102, 16, 242, 0.0)'); // Ungu pudar di bawah

                const orderChart = new Chart(ctx, {
                    type: 'line', // Bisa diganti 'bar' jika ingin bentuk batang
                    data: {
                        labels: {!! json_encode($labels) !!}, // Data Tanggal dari Controller
                        datasets: [{
                            label: 'Jumlah Order',
                            data: {!! json_encode($data) !!}, // Data Total Order dari Controller
                            borderColor: '#6610f2',
                            backgroundColor: gradient,
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4 // Membuat garis melengkung halus (smooth curve)
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false // Sembunyikan legenda jika hanya 1 dataset
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
            });
            </script>
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

