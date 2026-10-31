
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
            <div class="d-flex flex-column mt-3 mb-2">
                <span class="fw-bold text-dark ">REFRESH SYSTEM</span>
              <small class="bg-secondary text-white px-2 rounded mb-2 align-self-center" style=" font-size: 0.75rem;background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);"> {{Auth::User()->branches->name ?? 'Pusat'}} </small>
            </div>
       
            
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
              <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                  {{-- <i class="nav-icon bi bi-speedometer"></i> --}}
                  <i class="fa-solid fa-chart-pie" style="background: linear-gradient(135deg, #0d6efd 30%, #6610f2 40%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
               
              </li>
              <li class="nav-item ">
                <a href="{{ route('admin.washqueue.index') }}" wire:navigate class="nav-link {{ request()->routeIs('admin.washqueue.index') ? 'active' : '' }}">
                  {{-- <i class="nav-icon bi bi-speedometer"></i> --}}
                  <i class="fa-solid fa-list-check" style="background: linear-gradient(135deg, #0d6efd 30%, #6610f2 40%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                  <p>
                    Wash Queue
                  </p>
                </a>
               
              </li>


              <li class="nav-item ">
                <a href="{{ route('sidebarcard.masterdata.index') }}" wire:navigate class="nav-link {{ request()->routeIs('sidebarcard.masterdata.index') ? 'active' : '' }}">
                  <i class="fa-solid fa-server" style="background: linear-gradient(135deg, #0d6efd 30%, #6610f2 40%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                  <p>
                    Master Data
                  </p>
                </a>               
              </li>


              <li class="nav-item ">
                <a href="{{ route('sidebarcard.transactions.index') }}" wire:navigate class="nav-link {{ request()->routeIs('sidebarcard.transactions.index') ? 'active' : '' }}">
                  <i class="fa-solid fa-receipt"  style="background: linear-gradient(135deg, #0d6efd 30%, #6610f2 40%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                  <p>
                    Transactions
                  </p>
                </a>               
              </li>


              <li class="nav-item ">
                <a href="{{ route('sidebarcard.reports.index') }}" wire:navigate class="nav-link {{ request()->routeIs('sidebarcard.reports.index') ? 'active' : '' }}">
                  <i class="fa-solid fa-chart-column" style="background: linear-gradient(135deg, #0d6efd 30%, #6610f2 40%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                  <p>
                    Reports
                  </p>
                </a>               
              </li>

              {{-- menu Setting management --}}
              <li class="nav-item">
                <a href="{{route('sidebarcard.settings.index')}}" wire:navigate class="nav-link {{ request()->routeIs('sidebarcard.settings.index') ? 'active' : '' }}">
              
                  <i class="fa-solid fa-gear" style="background: linear-gradient(135deg, #0d6efd 30%, #6610f2 40%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                  <p>
                    Settings Management
                    
                  </p>
                </a>
                
              </li>
              <li>
              <div class="sidebar-footer p-3 mt-auto">
                <form action="{{ route('logout') }}" method="POST" class="d-grid">
                    @csrf
                    <button type="submit"  class="btn btn-light text-danger fw-semibold d-flex align-items-center justify-content-center py-2" style="border: 1px solid rgba(231, 1, 1, 0.2);">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> 
                        Logout
                    </button>
                </form>
            </div>
              </li>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->