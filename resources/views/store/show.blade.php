@extends('base')

@section('title', $product->name . ' | Product Details')

@section('content')
<!-- Enhanced Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand" href="{{ route('store.index') }}">
      <img src="{{ asset('logo1.svg') }}" alt="Logo MyShop" height="50" width="80">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <i class="fas fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <!-- Cart Indicator -->
        <li class="nav-item me-3">
          <a class="btn btn-outline-primary position-relative" href="{{ route('cart.index') }}">
            <i class="fas fa-shopping-cart"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              {{ Cart::getContent()->count() }}
            </span>
          </a>
        </li>
        
        @if (Route::has('login'))
          @auth
            <li class="nav-item">
              <a class="btn btn-primary text-white" href="{{ url('/dashboard') }}">
                <i class="fas fa-house"></i>
              </a>
            </li>
          @else
            <li class="nav-item me-2">
              <a class="btn btn-outline-primary" href="{{ url('/login') }}">
                <i class="fas fa-sign-in-alt me-2"></i>Login
              </a>
            </li>
            <li class="nav-item">
              <a class="btn btn-primary text-white" href="{{ url('/register') }}">
                <i class="fas fa-user-plus me-2"></i>Register
              </a>
            </li>
          @endauth
        @endif
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container my-5">
  <div class="row justify-content-center g-4">
    <!-- Product Image Gallery -->
    <div class="col-lg-6 col-md-6">
      <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <!-- Main Image -->
        <div class="ratio ratio-1x1 bg-light">
          <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid p-4 object-fit-contain" alt="{{ $product->name }}" id="mainImage">
        </div>
        
        <!-- Thumbnail Gallery -->
        <div class="d-flex flex-wrap gap-2 p-3 border-top">
          @for($i = 1; $i <= 3; $i++)
            <div class="thumbnail cursor-pointer" style="width: 80px; height: 80px;">
              <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid h-100 w-100 object-fit-cover rounded-2 border" onclick="changeImage(this)">
            </div>
          @endfor
        </div>
        
        <!-- Stock Badge -->
        <div class="position-absolute top-0 end-0 m-3">
          <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }} rounded-pill px-3 py-2">
            {{ $product->quantity > 0 ? 'In Stock: '.$product->quantity : 'Out of Stock' }}
          </span>
        </div>
      </div>
    </div>

    <!-- Product Details -->
    <div class="col-lg-6 col-md-6">
      <div class="card border-0 shadow-sm rounded-3 h-100">
        <div class="card-body p-4">
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-3">
              <li class="breadcrumb-item"><a href="{{ route('store.index') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="#">{{ $product->category->name ?? 'Products' }}</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 20) }}</li>
            </ol>
          </nav>
          
          <h1 class="h2 fw-bold mb-3">{{ $product->name }}</h1>
          
          <!-- Rating -->
          <div class="d-flex align-items-center mb-3">
            <div class="rating me-2">
              @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star{{ $i <= 4.5 ? ($i <= 4 ? '' : '-half-alt') : '' }} text-warning"></i>
              @endfor
            </div>
            <span class="text-muted small">(24 reviews)</span>

          </div>
          
          <!-- Price -->
          <div class="mb-4">
            @if($product->discount > 0)
              <span class="text-danger fs-4 fw-bold">{{ number_format($product->price - $product->discount, 2) }} MAD</span>
              <span class="text-decoration-line-through text-muted ms-2">{{ number_format($product->price, 2) }} MAD</span>
              <span class="badge bg-danger ms-2">Save {{ number_format(($product->discount/$product->price)*100, 0) }}%</span>
            @else
              <span class="text-success fs-4 fw-bold">{{ number_format($product->price, 2) }} MAD</span>
            @endif
            <div class="text-muted small">incl. VAT, plus shipping</div>
          </div>
          
          <!-- Highlights -->
          <div class="mb-4">
            <h5 class="fw-bold mb-2">Key Features</h5>
            <ul class="list-unstyled">
              <li class="mb-1"><i class="fas fa-check-circle text-success me-2"></i> Premium quality materials</li>
              <li class="mb-1"><i class="fas fa-check-circle text-success me-2"></i> Eco-friendly production</li>
              <li class="mb-1"><i class="fas fa-check-circle text-success me-2"></i> 2-year manufacturer warranty</li>
            </ul>
          </div>
          
          <!-- Add to Cart -->
          <form action="{{ route('add.cart', $product->id) }}" method="post" class="mb-4">
            @csrf
            <div class="row g-3 align-items-center">
              <div class="col-md-3 col-6">
                <label for="qty" class="form-label">Quantity</label>
                <input
                  type="number"
                  name="qty"
                  id="qty"
                  class="form-control"
                  min="1"
                  max="{{ $product->quantity }}"
                  value="1"
                  required
                >
              </div>
              
              <div class="col-md-9 col-6">
                <button type="submit" class="btn btn-primary w-100 py-2" {{ $product->quantity < 1 ? 'disabled' : '' }}>
                  <i class="fas fa-shopping-cart me-2"></i>
                  {{ $product->quantity > 0 ? 'Add to Cart' : 'Out of Stock' }}
                </button>
              </div>
            </div>
          </form>
          
          <!-- Action Buttons -->
          <div class="d-flex flex-wrap gap-2 mb-4">
            <button class="btn btn-outline-secondary flex-grow-1">
              <i class="far fa-heart me-2"></i> Wishlist
            </button>
            <button class="btn btn-outline-secondary flex-grow-1">
              <i class="fas fa-share-alt me-2"></i> Share
            </button>
          </div>
          
          <!-- Product Meta -->
          <div class="border-top pt-3">
            <div class="row small text-muted">
              <div class="col-6">
                <div class="mb-1"><strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}</div>
                <div class="mb-1"><strong>Category:</strong> {{ $product->category->name ?? 'Uncategorized' }}</div>
              </div>
              <div class="col-6">
                <div class="mb-1"><strong>Weight:</strong> 0.5 kg</div>
                <div class="mb-1"><strong>Added:</strong> {{ $product->created_at->format('d M Y') }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Product Tabs -->
    <div class="col-12 mt-4">
      <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body">
          <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Description</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">Specifications</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Reviews</button>
            </li>
          </ul>
          <div class="tab-content" id="productTabsContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel">
              <h5 class="fw-bold mb-3">Product Description</h5>
              <div class="text-muted" style="line-height: 1.8;">
                {!! nl2br(e($product->description)) !!}
              </div>
            </div>
            
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Footer -->
@include('layouts.footer')
@endsection

@push('styles')
<style>
  .product-card {
    transition: all 0.3s ease;
    border-radius: 0.5rem;
  }
  
  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  }
  
  .thumbnail {
    transition: all 0.2s ease;
  }
  
  .thumbnail:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }
  
  .rating {
    letter-spacing: 2px;
  }
  
  .nav-tabs .nav-link {
    color: #495057;
    font-weight: 500;
  }
  
  .nav-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom: 2px solid #0d6efd;
  }
</style>
@endpush

@push('scripts')
<script>
  // Change main product image when thumbnail is clicked
  function changeImage(element) {
    document.getElementById('mainImage').src = element.src;
  }
  
  // Initialize tooltips
  document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
  });
</script>
@endpush