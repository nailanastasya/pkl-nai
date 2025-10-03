<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{asset('assets/')}}"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

   @include('templates.patrials.head')
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          @include('templates.patrials.sidebar')
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              @stack('search')
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
               

                <!-- User -->
               <li class="nav-item navbar-dropdown dropdown-user dropdown">
  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
    <div class="avatar avatar-online">
      @if(Auth::user() && Auth::user()->profile)
        {{-- Jika ada foto di kolom profile --}}
        <img src="{{ asset('storage/' . Auth::user()->profile) }}" 
             alt="Profile" 
             class="w-px-40 h-auto rounded-circle" />
      @else
        {{-- Jika tidak ada foto, pakai inisial nama --}}
        <span class="avatar-initial rounded-circle text-black d-flex align-items-center justify-content-center"
              style="width:40px; height:40px; font-weight:bold; background-color:white;">
          {{ strtoupper(substr(Auth::user()?->name ?? 'G', 0, 1)) }}
        </span>
      @endif
    </div>
  </a>

  <ul class="dropdown-menu dropdown-menu-end">
    <li>
      <a class="dropdown-item" href="#">
        <div class="d-flex">
          <div class="flex-shrink-0 me-3">
            <div class="avatar avatar-online">
              @if(Auth::user() && Auth::user()->profile)
                <img src="{{ asset('storage/' . Auth::user()->profile) }}" 
                     alt="Profile" 
                     class="w-px-40 h-auto rounded-circle" />
              @else
                <span class="avatar-initial rounded-circle text-black d-flex align-items-center justify-content-center"
                      style="width:40px; height:40px; font-weight:bold; background-color:white;">
                  {{ strtoupper(substr(Auth::user()?->name ?? 'G', 0, 1)) }}
                </span>
              @endif
            </div>
          </div>
          <div class="flex-grow-1">
            <span class="fw-semibold d-block">{{ Auth::user()?->name ?? 'Guest' }}</span>
            <small class="text-muted">{{ ucfirst(Auth::user()->position ?? 'No role') }}</small>
          </div>
        </div>
      </a>
    </li>

    <li><div class="dropdown-divider"></div></li>
    <li>
      <a class="dropdown-item" href="#">
        <i class="bx bx-user me-2"></i>
        <span class="align-middle">My Profile</span>
      </a>
    </li>
    <li>
      <a class="dropdown-item" href="#">
        <i class="bx bx-cog me-2"></i>
        <span class="align-middle">Settings</span>
      </a>
    </li>
    <li>
      <a class="dropdown-item" href="#">
        <span class="d-flex align-items-center align-middle">
          <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
          <span class="flex-grow-1 align-middle">Billing</span>
          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
        </span>
      </a>
    </li>
    <li><div class="dropdown-divider"></div></li>
    <li>
      <a class="dropdown-item" href="{{ route('actionlogout') }}">
        <i class="bx bx-power-off me-2"></i>
        <span class="align-middle">Log Out</span>
      </a>
    </li>
  </ul>
</li>

                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y ms-auto">
              <div class="d-flex justify-content-between align-items-center py-3 mb-4">
                  <h4 class="fw-bold m-0">
                      <span class="text-muted fw-light">{{ $preTitle ?? "" }}</span> {{ $title ?? "" }}
                  </h4>
                  <div class="d-flex">
                      @stack('create')
                      @stack('page-action')  {{-- Ini tempat untuk page-action --}}
                  </div>
              </div>

              @include('templates.patrials.alert')
              @yield('content')
            </div>

            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              @include('templates.patrials.footer')
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    @include('templates.patrials.script')
  </body>
</html>