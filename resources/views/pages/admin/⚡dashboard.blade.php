<?php

use Livewire\Component;

new class extends Component
{
       public function render()
    {
        // Return view with layout and title
        return $this->view([
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
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h1 class="mb-0 fs-3"> <i class="fa-solid fa-chart-pie"></i> Dashboard</h1>
              </div>
              <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                  </ol>
                </nav>
              </div>
            </div>
            <!--end::Row-->
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
                    <h3>150</h3>

                    <p>New Orders</p>
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
                    href="#"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    Open Orders <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 1-->
              </div>
              <!--end::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box text-bg-success">
                  <div class="inner">
                    <h3>53<sup class="fs-5">%</sup></h3>

                    <p>Our Services</p>
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
                    href="#"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    Open Services<i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 2-->
              </div>
              <!--end::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 3-->
                <div class="small-box text-bg-warning">
                  <div class="inner">
                    <h3>44</h3>

                    <p>Wash Queue</p>
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
                    href="#"
                    class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    Open Queue <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 3-->
              </div>
              <!--end::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 4-->
                <div class="small-box text-bg-danger">
                  <div class="inner">
                    <h3>65</h3>

                    <p>Our Customers</p>
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
                    href="#"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    Open Customers <i class="bi bi-link-45deg"></i>
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

              <!-- Start col -->
              <div class="col-lg-5 connectedSortable">
                <div class="card text-white bg-primary bg-gradient border-primary mb-4">
                  <div class="card-header border-0">
                    <h3 class="card-title">Sales Value</h3>
                    <div class="card-tools">
                      <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        data-lte-toggle="card-collapse"
                        aria-label="Collapse card"
                      >
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div id="world-map" style="height: 220px"></div>
                  </div>
                  <div class="card-footer border-0">
                    <!--begin::Row-->
                    <div class="row">
                      <div class="col-4 text-center">
                        <div id="sparkline-1" class="text-dark"></div>
                        <div class="text-white">Visitors</div>
                      </div>
                      <div class="col-4 text-center">
                        <div id="sparkline-2" class="text-dark"></div>
                        <div class="text-white">Online</div>
                      </div>
                      <div class="col-4 text-center">
                        <div id="sparkline-3" class="text-dark"></div>
                        <div class="text-white">Sales</div>
                      </div>
                    </div>
                    <!--end::Row-->
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