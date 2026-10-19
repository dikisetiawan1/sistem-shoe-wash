 <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="{{ asset('adminlte4/dist/index.html') }}" class="brand-link">
            <!--begin::Brand Image-->
            {{-- <img
              src="{{ asset('adminlte4/dist/assets/img/AdminLTELogo.png') }}"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            /> --}}
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light text-bold">SWM MANAGEMENT</span>
            
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
       
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2" aria-label="Main navigation">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              data-accordion="false"
              id="navigation"
            >
              <li class="nav-item menu-open">
                <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                  {{-- <i class="nav-icon bi bi-speedometer"></i> --}}
                  <i class="fa-solid fa-chart-pie"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
               
              </li>
              <li class="nav-item ">
                <a href="{{ route('admin.washqueue.index') }}" class="nav-link">
                  {{-- <i class="nav-icon bi bi-speedometer"></i> --}}
                  <i class="fa-solid fa-list-check"></i>
                  <p>
                    Wash Queue
                  </p>
                </a>
               
              </li>
              <li class="nav-item ">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                  {{-- <i class="nav-icon bi bi-speedometer"></i> --}}
                  <i class="fa-solid fa-clock-rotate-left"></i>
                  <p>
                    Tracking Status
                  </p>
                </a>
               
              </li>
              

              {{-- <li class="nav-header">MAIN DATA</li> --}}
              <li class="nav-item">
                <a href="#" class="nav-link">
                  
                  <i class="fa-solid fa-server"></i>
                  <p>

                    Master Data
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.customers.index') }}" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Create Customers</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.shoetype.index') }}" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Create Shoe Type</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.services.index') }}" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Create Services</p>
                    </a>
                  </li>
                  
                </ul>
              </li>

               {{-- <li class="nav-header">TRANSACTIONS</li> --}}
              <li class="nav-item" has-treeview>
                <a href="#" class="nav-link" data-lte-toggle="treeview">
                  {{-- <i class="nav-icon bi bi-file-earmark-text"></i> --}}
                  <i class="fa-solid fa-receipt"></i>
                  <p>
                    Transactions
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link" wire:navigate>
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Create Orders</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.orders.updatestatus') }}" class="nav-link" wire:navigate>
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Update Orders Status</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.orders.history') }}" class="nav-link" wire:navigate>
                      <i class="nav-icon bi bi-circle"></i>
                      <p>History Orders</p>
                    </a>
                  </li>
                </ul>
              </li>
            {{-- Menu Reports --}}
              <li class="nav-item">
                <a href="#" class="nav-link">
                 <i class="fa-solid fa-chart-column"></i>
                
                  <p>
                    Reports
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Report Daily</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Report Monthly</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Report Yearly</p>
                    </a>
                  </li>
                 
                </ul>
              </li>
             

              {{-- <li class="nav-header">SETTINGS MANAGEMENT</li> --}}
              {{-- menu Setting management --}}
              <li class="nav-item">
                <a href="#" class="nav-link">
                  {{-- <i class="nav-icon bi bi-box-arrow-in-right"></i> --}}
                  <i class="fa-solid fa-gear"></i>
                  <p>
                    Settings Management
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Users</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Logout</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            <!--end::Sidebar Menu-->

           
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->