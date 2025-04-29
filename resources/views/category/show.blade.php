@extends('base')

@section('title', $category->name)

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-5 fw-bold text-gradient">
                <i class="fas fa-tag me-2"></i>{{ $category->name }}
            </h1>
            <p class="text-muted">Products in this category</p>
        </div>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Back to Categories
        </a>
    </div>

    <!-- Products Table -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-body p-0">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Product Name</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr class="border-top">
                                <td class="ps-4 fw-bold text-muted">{{ $product->id }}</td>
                                <td>
                                    <a  class="text-decoration-none">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('products.edit', $product) }}" 
                                           class="btn btn-sm btn-outline-info rounded-pill px-3"
                                           data-bs-toggle="tooltip" title="Edit Product">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No products found in this category</h5>
                    <a href="{{ route('products.create') }}" class="btn btn-primary mt-3 rounded-pill">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .text-gradient {
        background: linear-gradient(45deg, #6a11cb 0%, #2575fc 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(106, 17, 203, 0.05);
    }
    
    .rounded-3 {
        border-radius: 1rem !important;
    }
</style>

<script>
    // Enable tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
@endsection