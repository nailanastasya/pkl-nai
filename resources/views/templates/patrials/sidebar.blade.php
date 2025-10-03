<div class="app-brand demo d-flex justify-content-center text-center py-3 mb-3">
  <a href="{{ route('home') }}" class="app-brand-link d-flex align-items-center justify-content-center">
    <span class="app-brand-logo demo">
      <img src="{{ asset('assets/assets/img/favicon/logo.png') }}" 
           alt="Logo" 
           class="img-fluid"
           style="max-height: 70px; width: auto;">
    </span>
    <span class="app-brand-text demo menu-text fw-bolder ms-2"></span>
  </a>

  <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
    <i class="bx bx-chevron-left bx-sm align-middle"></i>
  </a>
</div>




{{-- <div class="menu-inner-shadow"></div> --}}

<ul class="menu-inner py-1">
  <!-- Dashboard -->
<li class="menu-item" style="position: relative;">
  <a href="{{route('home')}}" 
     class="menu-link text-decoration-none text-white"
     style="background-color: rgba(226, 47, 40, 0.85); border-radius: 0.375rem;">
    <i class="menu-icon tf-icons bx bx-home-circle text-white"></i>
    <div data-i18n="Analytics">Home</div>
  </a>

  <!-- indikator custom, bukan pakai bawaan active -->
  <span class="menu-indicator-custom" 
        style="position: absolute;
               top: 0;
               right: 0;
               width: 4px;
               height: 100%;
               background-color: rgba(226, 47, 40, 1);
               border-radius: 0 4px 4px 0;">
  </span>
</li>







  <li class="menu-header small text-uppercase">
    <span class="menu-header-text">Pages</span>
  </li>
  
  <li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle text-decoration-none">
      <i class="menu-icon tf-icons bx bx-cart"></i>
      <div data-i18n="Misc">Pelanggan</div>
    </a>
    <ul class="menu-sub">
      <li class="menu-item">
        <a href="{{route('customer.prospects')}}" class="menu-link text-decoration-none">
          <div data-i18n="Error">Calon Pelanggan</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{route('customer.index')}}" class="menu-link text-decoration-none">
          <div data-i18n="Under Maintenance">Data Pelanggan </div>
        </a>
      </li>
    </ul>
  </li>

  <li class="menu-item">
    <a href="{{route('product.index')}}" class="menu-link text-decoration-none">
      <i class='menu-icon tf-icons bx bx-desktop'></i>
      <div data-i18n="Analytics">Product</div>
    </a>
  </li>

  <li class="menu-item">
    <a href="{{route('user.index')}}" class="menu-link text-decoration-none">
      <i class='menu-icon tf-icons bx bx-user'></i>
      <div data-i18n="Analytics">Users</div>
    </a>
  </li>

  <li class="menu-item">
    <a href="{{route('nodin.index')}}" class="menu-link text-decoration-none">
      <i class='menu-icon tf-icons bx bx-note'></i>
      <div data-i18n="Analytics">Nodin</div>
    </a>
  </li>

  <li class="menu-item">
    <a href="{{route('invoice.index')}}" class="menu-link text-decoration-none">
      <i class='menu-icon tf-icons bx bx-credit-card'></i>
      <div data-i18n="Analytics">Invoice</div>
    </a>
  </li>

  <li class="menu-item">
    <a href="{{route('log.index')}}" class="menu-link text-decoration-none">
      <i class='menu-icon tf-icons bx bx-history'></i>
      <div data-i18n="Analytics">History</div>
    </a>
  </li>

    <li class="menu-header small text-uppercase">
    <span class="menu-header-text">Action</span>
  </li>
  <li class="menu-item">
    <a href="{{route('actionlogout')}}" class="menu-link text-decoration-none">
      <i class='menu-icon tf-icons bx bx-power-off'></i>
      <div data-i18n="Analytics">Logout</div>
    </a>
  </li>


   
</ul>
