@extends('base')

@section('title', 'Gestion des Produits')

@section('content')
@include('layouts.navigation')

<div class="container-fluid px-4 py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="fas fa-boxes me-2 text-primary"></i>Gestion des Produits
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Produits</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('products.create') }}" class="btn btn-primary rounded-pill shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>Ajouter un produit
            </a>
            <div>
                <a href="{{ route('pannel') }}" class="btn btn-primary rounded-pill shadow-sm">
                    <i class="fas fa-circle-chevron-left"></i> BACK
                </a>
            </div>
        </div>
    </div>

    <!-- Products Table Card -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">#ID</th>
                            <th>Produit</th>
                            <th>Description</th>
                            <th>Catégorie</th>
                            <th class="text-center">Stock</th>
                            <th>Image</th>
                            <th class="text-end">Prix</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr class="border-top">
                            <td class="ps-4 fw-bold">{{ $product->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-3">
                                        <p class="fw-bold mb-0">{{ $product->name }}</p>
                                        <small class="text-muted">Ref: PROD{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-muted mb-0" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $product->description }}
                                </p>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary">
                                    {{ $product->category?->name ?? 'Non catégorisé' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($product->quantity > 10)
                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-1">
                                        {{ $product->quantity }} en stock
                                    </span>
                                @elseif($product->quantity > 0)
                                    <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning px-3 py-1">
                                        {{ $product->quantity }} restant(s)
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>Rupture
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="bg-image hover-zoom" style="width: 60px; height: 60px;">
                                    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/default-product.png') }}" 
                                         class="img-fluid rounded-3 border" 
                                         alt="{{ $product->name }}"
                                         style="object-fit: cover; width: 100%; height: 100%;">
                                </div>
                            </td>
                            <td class="text-end fw-bold">
                                {{ number_format($product->price, 2) }} MAD
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('store.show', $product) }}"
                                       class="btn btn-sm btn-outline-info rounded-circle action-btn"
                                       data-bs-toggle="tooltip"
                                       title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" 
                                       class="btn btn-sm btn-outline-primary rounded-circle action-btn"
                                       data-bs-toggle="tooltip"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-form-{{ $product->id }}" 
                                          action="{{ route('products.destroy', $product) }}" 
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger rounded-circle action-btn"
                                                data-bs-toggle="tooltip"
                                                title="Supprimer"
                                                onclick="confirmDelete('delete-form-{{ $product->id }}', 'Supprimer le produit {{ $product->name }} ?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Aucun produit trouvé</h5>
                                    <p class="text-muted mb-4">Commencez par ajouter vos premiers produits</p>
                                    <a href="{{ route('products.create') }}" class="btn btn-primary rounded-pill">
                                        <i class="fas fa-plus-circle me-2"></i>Ajouter un produit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($products->hasPages())
        <div class="card-footer bg-transparent border-top-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Affichage de {{ $products->firstItem() }} à {{ $products->lastItem() }} sur {{ $products->total() }} produits
                </div>
                {{ $products->onEachSide(1)->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

@section('styles')
<style>
    .action-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .empty-state {
        max-width: 400px;
        margin: 0 auto;
    }
    
    .hover-zoom {
        transition: transform 0.3s ease;
    }
    
    .hover-zoom:hover {
        transform: scale(1.1);
    }
    
    .rounded-3 {
        border-radius: 0.75rem !important;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
</style>
@endsection

@section('scripts')
<script>
    // Enable tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
    
    // Delete confirmation
    function confirmDelete(formId, message) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer!',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        })
    }
</script>
@endsection
@endsection