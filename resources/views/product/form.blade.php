@extends('base')

@section('title', ($isUpdate ? 'Update' : 'Create') . ' product')

@php
    $route = route('products.store');
    if($isUpdate) {
        $route = route('products.update', $product);
    }
@endphp

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Animated Card -->
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden hover-animate" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                <!-- Gradient Header -->
                <div class="card-header py-4" style="background: linear-gradient(45deg, #6a11cb 0%, #2575fc 100%);">
                    <h1 class="h3 mb-0 text-center text-white">
                        <i class="fas fa-box-open me-2"></i> @yield('title')
                    </h1>
                </div>
                
                <div class="card-body p-5">
                    <form action="{{ $route }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if ($isUpdate)
                            @method('PUT')
                        @endif
                        
                        <!-- Floating Inputs with Icons -->
                        <div class="row g-4">
                            <!-- Name Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control border-0 border-bottom rounded-0 shadow-sm"
                                        value="{{ old('name', $product->name) }}"
                                        placeholder=" "
                                    />
                                    <label for="name" class="text-muted">
                                        <i class="fas fa-tag me-2"></i> Product Name
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Category Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select
                                        name="category_id"
                                        id="category_id"
                                        class="form-select border-0 border-bottom rounded-0 shadow-sm"
                                    >
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="category_id" class="text-muted">
                                        <i class="fas fa-list-alt me-2"></i> Category
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Description Field -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea
                                        name="description"
                                        id="description"
                                        class="form-control border-0 border-bottom rounded-0 shadow-sm"
                                        rows="3"
                                        placeholder=" "
                                        style="min-height: 100px;"
                                    >{{ old('description', $product->description) }}</textarea>
                                    <label for="description" class="text-muted">
                                        <i class="fas fa-align-left me-2"></i> Description
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Quantity & Price -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input
                                        type="number"
                                        name="quantity"
                                        id="quantity"
                                        class="form-control border-0 border-bottom rounded-0 shadow-sm"
                                        value="{{ old('quantity', $product->quantity) }}"
                                        placeholder=" "
                                    />
                                    <label for="quantity" class="text-muted">
                                        <i class="fas fa-cubes me-2"></i> Quantity
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input
                                        type="number"
                                        name="price"
                                        id="price"
                                        class="form-control border-0 border-bottom rounded-0 shadow-sm"
                                        value="{{ old('price', $product->price) }}"
                                        step="0.01"
                                        placeholder=" "
                                    />
                                    <label for="price" class="text-muted">
                                        <i class="fas fa-dollar-sign me-2"></i> Price
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Image Upload with Preview -->
                            <div class="col-12">
                                <div class="file-upload-wrapper">
                                    <label class="form-label text-muted mb-3">
                                        <i class="fas fa-image me-2"></i> Product Image
                                    </label>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <input
                                                type="file"
                                                name="image"
                                                id="image"
                                                class="form-control d-none"
                                                onchange="previewImage(this)"
                                            />
                                            <label for="image" class="btn btn-outline-primary rounded-pill px-4">
                                                <i class="fas fa-cloud-upload-alt me-2"></i> Choose File
                                            </label>
                                        </div>
                                        <div id="imagePreview" class="flex-grow-1">
                                            @if($isUpdate && $product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="img-thumbnail rounded" width="80" id="currentImage">
                                            @else
                                                <small class="text-muted">No image selected</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-lg rounded-pill text-white shadow" 
                                    style="background: linear-gradient(45deg, #6a11cb 0%, #2575fc 100%);">
                                <i class="fas fa-save me-2"></i> {{ $isUpdate ? 'Update Product' : 'Create Product' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Script -->
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const currentImage = document.getElementById('currentImage');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (currentImage) {
                    currentImage.src = e.target.result;
                } else {
                    preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail rounded" width="80">`;
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    .hover-animate {
        transition: all 0.3s ease;
    }
    .hover-animate:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
    }
    .form-control, .form-select {
        background-color: rgba(255,255,255,0.7) !important;
    }
    .form-control:focus, .form-select:focus {
        background-color: white !important;
        box-shadow: 0 0 0 0.25rem rgba(106, 17, 203, 0.25) !important;
    }
    .file-upload-wrapper {
        padding: 1rem;
        border-radius: 0.5rem;
        background-color: rgba(255,255,255,0.7);
    }
</style>
@endsection