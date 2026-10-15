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
                  
                </ul>
              </li>

               {{-- <li class="nav-header">TRANSACTIONS</li> --}}
              <li class="nav-item">
                <a href="#" class="nav-link">
                  {{-- <i class="nav-icon bi bi-file-earmark-text"></i> --}}
                  <i class="fa-solid fa-receipt"></i>
                  <p>
                    Transactions
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Create Order</p>
                    </a>
                  </li>
                  
                 
               
                </ul>
              </li>
             

              {{-- <li class="nav-header">SETTINGS MANAGEMENT</li> --}}
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