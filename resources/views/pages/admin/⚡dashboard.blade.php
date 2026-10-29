<?php

use Livewire\Component;
use App\Models\Orders;
use App\Models\Services;
use App\Models\Customers;
use App\Models\User;
use App\Models\OrderDetail;


new class extends Component
{
       public function render()
    {
       // Ambil branch_id user yang sedang login
    $branchId = Auth::user()->branch_id;

    return $this->view([
        'branchId' => $branchId,
        'orders'   => Orders::where('branch_id', $branchId)->get(),
        'services' => Services::get(),
        'customers'=> Customers::where('branch_id', $branchId)->get(),
        'washqueue' => OrderDetail::whereNotIn('status', ['received', 'completed'])
            ->where('branch_id', $branchId) 
            ->latest()
            ->get()
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
                <h4 class="fw-bold mb-1 text-dark">
                    Selamat Datang, {{auth()->user()->name}}! 👋
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
                <!--begin::Small Box Widget 1-->
                <div class="small-box text-bg-primary">
                  <div class="inner">
                    <h3>{{ $orders->count() }}</h3>

                    <p>Data Pesanan</p>
                  </div>
               <svg 
                  class="small-box-icon" 
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
                  <a
                    href="{{route('admin.orders.index')}}"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    Lihat data <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 1-->
              </div>
              <!--end::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box text-bg-success">
                  <div class="inner">
                    <h3>{{ $services->count() }}</h3>

                    <p>Data Layanan</p>
                  </div>
                    <svg 
                    class="small-box-icon" 
                    fill="currentColor" 
                    viewBox="0 0 24 24" 
                    xmlns="http://www.w3.org/2000/svg" 
                    aria-hidden="true">
                    <path 
                      fill-rule="evenodd" 
                      d="M2.25 6a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H3a.75.75 0 0 1-.75-.75V6Zm0 6a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H3a.75.75 0 0 1-.75-.75V12Zm0 6a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H3a.75.75 0 0 1-.75-.75V18ZM6.75 6.75a.75.75 0 0 0 0 1.5h14.25a.75.75 0 0 0 0-1.5H6.75Zm0 6a.75.75 0 0 0 0 1.5h14.25a.75.75 0 0 0 0-1.5H6.75Zm0 6a.75.75 0 0 0 0 1.5h14.25a.75.75 0 0 0 0-1.5H6.75Z" 
                      clip-rule="evenodd">
                    </path>
                  </svg>
                    <a
                    href="{{route('admin.services.index')}}"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    Lihat data<i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 2-->
              </div>
              <!--end::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 3-->
                <div class="small-box text-bg-warning">
                  <div class="inner">
                    <h3>{{ $washqueue->count() }}</h3>

                    <p>Data antrean (harian)</p>
                  </div>
               <svg 
                  class="small-box-icon" 
                  fill="currentColor" 
                  viewBox="0 0 24 24" 
                  xmlns="http://www.w3.org/2000/svg" 
                  aria-hidden="true">
                  <path 
                    fill-rule="evenodd" 
                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .2.079.39.22.53l3.75 3.75a.75.75 0 1 0 1.06-1.06l-3.53-3.53V6Z" 
                    clip-rule="evenodd">
                  </path>
                </svg>
                  <a
                    href="{{route('admin.washqueue.index')}}"
                    class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    Lihat data<i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 3-->
              </div>
              <!--end::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 4-->
                <div class="small-box text-bg-danger">
                  <div class="inner">
                     <h3>{{ $customers->count() }}</h3>

                    <p>Data Pelanggan</p>
                  </div>
                  <svg 
                    class="small-box-icon" 
                    fill="currentColor" 
                    viewBox="0 0 24 24" 
                    xmlns="http://www.w3.org/2000/svg" 
                    aria-hidden="true">
                    <path 
                      d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a11.54 11.54 0 0 1-1.192 3.123 14.542 14.542 0 0 0 5.193-1.428.75.75 0 0 0 .364-.63l.001-.122a7.125 7.125 0 0 0-4.365-6.559 5.625 5.625 0 0 1 0 5.472Z">
                    </path>
                  </svg>
                  <a
                    href="{{route('admin.customers.index')}}"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
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
                <div class="card mb-4">
                  <div class="card-header">
                    <h3 class="card-title">Sales Value</h3>
                  </div>

                  <div class="card-body">
                    <div id="revenue-chart"></div>
                  </div>
                </div>
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