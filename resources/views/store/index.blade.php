@php use Illuminate\Support\Facades\Request; @endphp
@extends('base')

@section('title','Products')

@section('content')
<!-- Enhanced Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4 sticky-top">
  <div class="container">
    <a class="navbar-brand" href="{{ route('store.index') }}">
      <img src="{{ asset('logo1.svg') }}" alt="Logo MyShop" height="50" width="80">
    </a>

    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav">
      <i class="fas fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Search Form -->
      <form method="get" class="d-flex mx-auto my-2 my-lg-0" style="max-width: 500px; width: 100%;">
        <div class="input-group">
          <input id="name" name="name" type="text" 
                 class="form-control rounded-start" 
                 value="{{ Request::input('name') }}" 
                 placeholder="Search products..." 
                 aria-label="Search">
          <button type="submit" class="btn btn-primary" data-mdb-ripple-color="light">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </form>

      <ul class="navbar-nav ms-auto align-items-center">
        @auth
          <!-- Dashboard -->
          

          <!-- Cart -->
          <li class="nav-item me-2">
            <a class="btn btn-primary position-relative" href="{{ route('cart.index') }}">
              <i class="fas fa-shopping-cart"></i>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ \Cart::getContent()->count() }}
              </span>
            </a>
          </li>

        <!-- Simple User Dropdown -->
<div class="user-menu">
  <button class="user-menu__trigger">
    <div class="user-avatar">
      @if(Auth::user()->profile_photo_path)
        <img src="{{ asset(Auth::user()->profile_photo_path) }}" alt="Profile" class="user-avatar__image">
      @else
        <span class="user-avatar__initials">{{ substr(Auth::user()->name, 0, 1) }}</span>
      @endif
    </div>
    <span class="user-name">{{ Auth::user()->name }}</span>
    <svg class="user-menu__chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <path d="M6 9l6 6 6-6"/>
    </svg>
  </button>
  
  <div class="user-menu__dropdown">
    <div class="user-profile">
      <div class="user-avatar user-avatar--large">
        @if(Auth::user()->profile_photo_path)
          <img src="{{ asset(Auth::user()->profile_photo_path) }}" alt="Profile" class="user-avatar__image">
        @else
          <span class="user-avatar__initials">{{ substr(Auth::user()->name, 0, 1) }}</span>
        @endif
      </div>
      <div class="user-profile__info">
        <h4 class="user-profile__name">{{ Auth::user()->name }}</h4>
        <p class="user-profile__email">{{ Auth::user()->email }}</p>
      </div>
    </div>
    
    <nav class="user-nav">
      <a href="{{ route('profile.edit') }}" class="user-nav__item">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
          <circle cx="12" cy="7" r="4"></circle>
        </svg>
        <span>Mon profil</span>
      </a>
      
     
    </nav>
    
    <form method="POST" action="{{ route('logout') }}" class="user-logout">
      @csrf
      <button type="submit" class="user-logout__button">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
        <span>Déconnexion</span>
      </button>
    </form>
  </div>
</div>

<style>
.user-menu {
  position: relative;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.user-menu__trigger {
  display: flex;
  align-items: center;
  gap: 10px;
  background: none;
  border: none;
  padding: 8px 12px;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.2s ease;
}

.user-menu__trigger:hover {
  background: rgba(0, 0, 0, 0.05);
}

.user-avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background-color: #f0f0f0;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.user-avatar--large {
  width: 48px;
  height: 48px;
}

.user-avatar__image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.user-avatar__initials {
  font-weight: 600;
  color: #555;
}

.user-avatar--large .user-avatar__initials {
  font-size: 18px;
}

.user-name {
  font-size: 14px;
  font-weight: 500;
  color: #333;
}

.user-menu__chevron {
  transition: transform 0.2s ease;
}

.user-menu__dropdown {
  position: absolute;
  right: 0;
  top: 100%;
  margin-top: 8px;
  width: 260px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  padding: 16px;
  opacity: 0;
  visibility: hidden;
  transform: translateY(-10px);
  transition: all 0.2s ease;
  z-index: 100;
}

.user-menu.active .user-menu__dropdown {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

.user-menu.active .user-menu__chevron {
  transform: rotate(180deg);
}

.user-profile {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 16px;
  padding-bottom: 16px;
  border-bottom: 1px solid #f0f0f0;
}

.user-profile__info {
  flex: 1;
}

.user-profile__name {
  margin: 0;
  font-size: 15px;
  font-weight: 600;
  color: #333;
}

.user-profile__email {
  margin: 4px 0 0;
  font-size: 13px;
  color: #666;
}

.user-nav {
  display: flex;
  flex-direction: column;
  gap: 4px;
  margin-bottom: 12px;
}

.user-nav__item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 8px;
  border-radius: 6px;
  text-decoration: none;
  color: #333;
  font-size: 14px;
  transition: all 0.2s ease;
}

.user-nav__item:hover {
  background: #f5f5f5;
  color: #000;
}

.user-nav__item svg {
  opacity: 0.8;
}

.user-logout {
  border-top: 1px solid #f0f0f0;
  padding-top: 12px;
}

.user-logout__button {
  display: flex;
  align-items: center;
  gap: 10px;
  width: 100%;
  padding: 10px 8px;
  border-radius: 6px;
  background: none;
  border: none;
  color: #d32f2f;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.user-logout__button:hover {
  background: rgba(211, 47, 47, 0.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const menuTrigger = document.querySelector('.user-menu__trigger');
  const userMenu = document.querySelector('.user-menu');
  
  menuTrigger.addEventListener('click', function(e) {
    e.stopPropagation();
    userMenu.classList.toggle('active');
  });
  
  // Close when clicking outside
  document.addEventListener('click', function() {
    userMenu.classList.remove('active');
  });
});
</script>
        @else
          <li class="nav-item me-2">
            <a class="btn btn-outline-primary" href="{{ url('/login') }}">
              <i class="fas fa-sign-in-alt me-1"></i> Login
            </a>
          </li>
          <li class="nav-item">
            <a class="btn btn-primary" href="{{ url('/register') }}">
              <i class="fas fa-user-plus me-1"></i> Register
            </a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>


<div class="container-fluid">
  <div class="row">
    <!-- Sidebar Filters -->
    <div class="col-lg-3 col-md-4 mb-4">
      <div class="card shadow-sm border-0 p-3 fixed" style="top: 80px;">
        <h3 class="mb-4 text-primary"><i class="fas fa-filter me-2"></i> Filters</h3>
        
        <!-- Categories Filter -->
        <div class="mb-4">
          <h5 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-dark"><i class="fas fa-tags me-2"></i>Categories</span>
          </h5>
          <form method="get" id="filterForm">
            <div class="list-group list-group-flush">
              @foreach ($categories as $category)
                <label class="list-group-item d-flex justify-content-between align-items-center border-0 rounded-3 mb-1">
                  <div>
                    <input 
                      @checked(in_array($category->id, request()->input('categories') ?? [])) 
                      type="checkbox" 
                      name="categories[]" 
                      value="{{ $category->id }}" 
                      class="form-check-input me-2">
                    {{ $category->name }}
                  </div>
                  <span class="badge bg-primary rounded-pill">{{ $category->products_count }}</span>
                </label>
              @endforeach
            </div>

            <div class="d-flex gap-2 mt-4">
              <button type="submit" class="btn btn-primary flex-grow-1">
                <i class="fas fa-filter me-1"></i> Apply Filters
              </button>
              <a href="{{ route('store.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-undo me-1"></i> Reset
              </a>
            </div>
          </form>
        </div>

        
      </div>
    </div>

    <!-- Main Content -->
    <div class="col-lg-9 col-md-8">
      <!-- Page Header -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-primary">
          <i class="fas fa-box-open me-2"></i>Our Products
        </h2>
        <div class="d-flex align-items-center">
          <span class="me-3 text-muted"> products found</span>
          <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="sortDropdown" data-mdb-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-sort me-1"></i> Sort By
            </button>
            <ul class="dropdown-menu" aria-labelledby="sortDropdown">
              <li>
                <a class="dropdown-item {{ request('sort') == 'price_asc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">
                  Price: Low to High
                </a>
              </li>
              <li>
                <a class="dropdown-item {{ request('sort') == 'price_desc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">
                  Price: High to Low
                </a>
              </li>
              <li>
                <a class="dropdown-item {{ request('sort') == 'newest' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">
                  Newest First
                </a>
              </li>
              
            </ul>
          </div>
          
        </div>
      </div>

      <hr class="hr hr-blurry" >

      <!-- Products Grid -->
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 g-4">
        @foreach ($products as $product)
          <div class="col">
            <div class="card h-100 shadow-sm border-0 hover-shadow-lg transition-all">
              <!-- Product Badge -->
             @if($product->quantity <= 0)
                <div class="badge bg-danger position-absolute" style="top: 10px; right: 10px;">Out</div>
              @elseif($product->created_at->diffInDays() < 7)
                <div class="badge bg-success position-absolute" id="new" style="top: 10px; right: 10px;"></div>
              @endif

              <!-- Product Image -->
              <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light">
                <img src="{{ asset('storage/'.$product->image) }}" 
                     class="img-fluid w-100 p-3" 
                     style="height: 200px; object-fit: contain;" 
                     alt="{{$product->name}}">
                <a href="{{ route('store.show', $product) }}">
                  <div class="mask">
                    <div class="d-flex justify-content-start align-items-end h-100">
                      <span class="badge bg-primary rounded-pill ms-2 mb-2">
                        <i class="fas fa-eye me-1"></i> View Details
                      </span>
                    </div>
                  </div>
                  <div class="hover-overlay">
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                  </div>
                </a>
              </div>

              <!-- Card Body -->
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <a href="{{ route('store.show', $product) }}" class="text-reset text-decoration-none">
                    <h5 class="card-title mb-2">{{$product->name}}</h5>
                  </a>
                  <button class="btn btn-link text-danger p-0" data-mdb-toggle="tooltip" title="Add to wishlist">
                    <i class="far fa-heart"></i>
                  </button>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="text-success fw-bold h5 mb-0">{{$product->price}} MAD</span>
                  <span class="badge bg-info">{{$product->category->name}}</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                  <span class="small text-muted">Available: {{$product->quantity}}</span>
                  <span class="small text-muted">{{ $product->created_at->format('M d, Y') }}</span>
                </div>
              </div>

              <!-- Card Footer -->
              <div class="card-footer bg-transparent border-top-0 pt-0">
                @if($product->quantity > 0)
                  <form action="{{ route('add.cart', $product->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="qty" value="1">
                    <button type="submit" class="btn btn-primary w-100">
                      <i class="fas fa-cart-plus me-2"></i> Add to Cart
                    </button>
                  </form>
                @else
                  <button class="btn btn-outline-secondary w-100" disabled>
                    <i class="fas fa-bell me-2"></i> Notify Me
                  </button>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination -->
      
    </div>
  </div>
</div>

@include('layouts.footer')

@section('styles')
<style>
  .hover-shadow-lg {
    transition: all 0.3s ease;
  }
  
  .hover-shadow-lg:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
  }
  
  .sticky-top {
    z-index: 1020;
  }
  
  .list-group-item:hover {
    background-color: #f8f9fa;
  }
  
  .form-check-input:checked {
    background-color: #3b71ca;
    border-color: #3b71ca;
  }
  
  .range-slider {
    padding: 0 10px;
  }
  
  @media (max-width: 768px) {
    .navbar-collapse {
      order: 3;
      margin-top: 1rem;
    }
    
    .search-form {
      order: 2;
      width: 100%;
    }
  }
</style>
@endsection

@section('scripts')
<script>
  // Initialize tooltips
  document.querySelectorAll('[data-mdb-toggle="tooltip"]').forEach((el) => {
    new mdb.Tooltip(el);
  });
  
  // Price range slider functionality
  const priceMin = document.getElementById('priceMin');
  const priceMax = document.getElementById('priceMax');
  const priceMinValue = document.getElementById('priceMinValue');
  const priceMaxValue = document.getElementById('priceMaxValue');
  
  priceMin.addEventListener('input', function() {
    priceMinValue.textContent = this.value + ' MAD';
    if (parseInt(priceMax.value) < parseInt(this.value)) {
      priceMax.value = this.value;
      priceMaxValue.textContent = this.value + ' MAD';
    }
  });
  
  priceMax.addEventListener('input', function() {
    priceMaxValue.textContent = this.value + ' MAD';
    if (parseInt(priceMin.value) > parseInt(this.value)) {
      priceMin.value = this.value;
      priceMinValue.textContent = this.value + ' MAD';
    }
  });
  
  // Auto submit filter form when checkbox is clicked
  document.querySelectorAll('#filterForm input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      document.getElementById('filterForm').submit();
    });
  });
</script>
@endsection