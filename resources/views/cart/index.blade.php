@php use Illuminate\Support\Facades\Request; @endphp
@extends('base')

@section('title','Products')

@section('content')

<!-- Navbar with MDB styling -->
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top mb-4 shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ route('store.index') }}">
      <img src="{{asset('logo1.svg')}}" alt="Logo MyShop" height="50" width="50">
    </a>
    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        @if (Route::has('login'))
            @auth
              <li class="nav-item">
                <a class="btn btn-primary text-white me-2" href="{{ url('/dashboard') }}"><i class="fas fa-house"></i></a>
              </li>
            @else
              <li class="nav-item me-3">
                <form method="get" class="d-flex align-items-center">
                  <div class="input-group">
                    <input id="name" name="name" type="text" 
                           class="form-control rounded" 
                           value="{{Request::input('name')}}" 
                           placeholder="Search" 
                           aria-label="Search" />
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </form>
              </li>
              <li class="nav-item me-2">
                <a class="btn btn-outline-primary" href="{{ url('/login') }}">Login</a>
              </li>
              <li class="nav-item">
                <a class="btn btn-primary" href="{{ url('/register') }}">Register</a>
              </li>
            @endauth
        @endif
      </ul>
    </div>
  </div>
</nav>

<!-- Main content with padding to account for fixed navbar -->
<main class="mt-5 pt-4">
  <div class="container">
    <!-- Section heading -->
    <section class="mb-4">
      <div class="d-flex justify-content-between align-items-center">
        <h2 class="fw-bold mb-0">Your Shopping Cart</h2>
        <div>
          <span class="text-muted me-2">Items: {{ \Cart::getContent()->count() }}</span>
          <a href="{{ route('store.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Continue Shopping
          </a>
        </div>
      </div>
      <hr class="my-3">
    </section>

    @if(Cart::isEmpty())
      <div class="card">
        <div class="card-body text-center py-5">
          <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
          <h3 class="mb-3">Your cart is empty</h3>
          <a href="{{ route('store.index') }}" class="btn btn-primary">
            <i class="fas fa-store me-2"></i> Start Shopping
          </a>
        </div>
      </div>
    @else
      <!-- Cart items -->
      <section class="mb-5">
        @foreach ($items as $item)
        <div class="card mb-3">
          <div class="card-body">
            <div class="row align-items-center">
              <!-- Product image -->
              <div class="col-md-2">
                <img src="{{ asset('storage/'.$item->associatedModel->image) }}" 
                     class="img-fluid rounded" 
                     alt="{{ $item->name }}">
              </div>
              
              <!-- Product name -->
              <div class="col-md-3">
                <h5 class="mb-1">{{ $item->name }}</h5>
                <p class="text-muted mb-0">Unit price: {{ $item->price }} DH</p>
              </div>
              
              <!-- Quantity update -->
              <div class="col-md-3">
                <form action="{{ route('update.cart', $item->associatedModel->id) }}" method="post" class="d-flex align-items-center">
                  @csrf
                  @method("PUT")
                  
                  <button type="button" class="btn btn-sm btn-outline-primary px-3 me-2 decrement">
                    <i class="fas fa-minus"></i>
                  </button>
                  
                  <input id="qty" min="1" max="{{ $item->associatedModel->quantity}}" 
                         name="qty" value="{{ $item->quantity }}" type="number"
                         class="form-control form-control-sm text-center mx-2" 
                         style="width: 60px;" />
                  
                  <button type="button" class="btn btn-sm btn-outline-primary px-3 ms-2 increment">
                    <i class="fas fa-plus"></i>
                  </button>
                  
                  <button type="submit" class="btn btn-sm btn-outline-success ms-3" 
                          data-mdb-toggle="tooltip" title="Update quantity">
                    <i class="fas fa-check"></i>
                  </button>
                </form>
              </div>
              
              <!-- Total price -->
              <div class="col-md-2">
                <h5 class="mb-0 text-primary">{{ $item->price * $item->quantity }} DH</h5>
              </div>
              
              <!-- Remove button -->
              <div class="col-md-2 text-end">
                <form action="{{ route('remove.cart',$item->associatedModel->id) }}" method="post">
                  @method("DELETE")
                  @csrf
                  <button type="submit" class="btn btn-sm btn-outline-danger" 
                          data-mdb-toggle="tooltip" title="Remove item">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </section>
      
      <!-- Order summary -->
      <section class="mb-5">
        <div class="card">
          <div class="card-body">
            <h4 class="mb-4">Order Summary</h4>
            
            <ul class="list-group list-group-flush mb-4">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Subtotal</span>
                <span>{{ Cart::getSubtotal() }} DH</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Shipping</span>
                <span>Free</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                <span>Total</span>
                <span class="text-primary">{{ Cart::getTotal() }} DH</span>
              </li>
            </ul>
          </div>
        </div>
      </section>
      
      <!-- Delivery information -->
      <section class="mb-5">
        <div class="card">
          <div class="card-body">
            <h4 class="mb-4">Delivery Information</h4>
            
            <form action="{{route('getOrder')}}" method="post">
              @csrf
              
              <input type="hidden" name="getTotale" value="{{ Cart::getSubtotal() }}">
              
              <!-- Address -->
              <div class="form-outline mb-4">
                <input type="text" id="address" name="adress" required 
                       class="form-control form-control-lg" />
                <label class="form-label" for="address">Delivery Address</label>
              </div>
              
              <!-- Phone number -->
              <div class="form-outline mb-4">
                <input type="tel" id="phone" required name="phone" 
                       class="form-control form-control-lg" />
                <label class="form-label" for="phone">Phone Number</label>
              </div>
              
              <!-- Payment method -->
              <div class="mb-4">
                <label class="form-label">Payment Method</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="paymentMethod" 
                         id="cashOnDelivery" value="cash" checked />
                  <label class="form-check-label" for="cashOnDelivery">
                    Cash on Delivery
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="paymentMethod" 
                         id="creditCard" value="card" />
                  <label class="form-check-label" for="creditCard">
                    Credit Card
                  </label>
                </div>
              </div>
              
              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-lg btn-block">
                <i class="fas fa-shopping-bag me-2"></i> Complete Order
              </button>
            </form>
          </div>
        </div>
      </section>
    @endif
  </div>
</main>

<!-- Footer -->
@include('layouts.footer')

@endsection

@push('scripts')
<script>
  // Quantity increment/decrement buttons
  document.querySelectorAll('.increment').forEach(button => {
    button.addEventListener('click', function() {
      const input = this.parentNode.querySelector('input[type=number]');
      input.stepUp();
    });
  });
  
  document.querySelectorAll('.decrement').forEach(button => {
    button.addEventListener('click', function() {
      const input = this.parentNode.querySelector('input[type=number]');
      input.stepDown();
    });
  });
  
  // Initialize MDB tooltips
  document.querySelectorAll('[data-mdb-toggle="tooltip"]').forEach(el => {
    new mdb.Tooltip(el);
  });
</script>
@endpush