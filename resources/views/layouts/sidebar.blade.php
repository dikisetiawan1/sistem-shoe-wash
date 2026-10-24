 
 
 
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
            <span class="brand-text fw-bold text-dark">REFRESH SYSTEM </span>
            
            
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


              <li class="nav-item ">
                <a href="{{ route('sidebarcard.masterdata.index') }}" class="nav-link">
                  <i class="fa-solid fa-server"></i>
                  <p>
                    Master Data
                  </p>
                </a>               
              </li>


              <li class="nav-item ">
                <a href="{{ route('sidebarcard.transactions.index') }}" class="nav-link">
                  <i class="fa-solid fa-receipt"></i>
                  <p>
                    Transactions
                  </p>
                </a>               
              </li>


              <li class="nav-item ">
                <a href="{{ route('sidebarcard.reports.index') }}" class="nav-link">
                  <i class="fa-solid fa-chart-column"></i>
                  <p>
                    Reports
                  </p>
                </a>               
              </li>

              {{-- menu Setting management --}}
              <li class="nav-item">
                <a href="{{route('sidebarcard.settings.index')}}" class="nav-link">
              
                  <i class="fa-solid fa-gear"></i>
                  <p>
                    Settings Management
                    
                  </p>
                </a>
                
              </li>
              <li>
              <form action="{{ route('logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger mx-3">
                      <i class="fa-solid fa-right-from-bracket me-2"></i> 
                      Logout
                  </button>
              </form>
              </li>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->