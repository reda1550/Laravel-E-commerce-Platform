@extends('base')

@section('title', 'Gestion des Commandes')

@section('content')
@include('layouts.navigation')

<div class="container-fluid px-4 py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-clipboard-list me-2 text-primary"></i>Liste des Commandes
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Commandes</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('pannel') }}" class="btn btn-primary">
                <i class="fas fa-circle-chevron-left"></i> BACK
            </a>
        </div>
    </div>

    <!-- Orders Table Card -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Client</th>
                            <th style="min-width: 150px;">Address</th>
                            <th style="min-width: 120px;">Téléphone</th>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Total</th>
                            <th>Paiement</th>
                            <th>Livraison</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr class="border-top">
                            <td class="ps-4 fw-bold">{{ $order->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <span class="avatar-title bg-primary bg-opacity-10 text-primary rounded-circle">
                                            {{ substr($order->user?->name ?? 'I', 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $order->user?->name ?? 'Inconnu' }}</div>
                                        <small class="text-muted">Commande #{{ $order->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                    <div class="text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" title="{{ $order->adress }}">
                                        {{ $order->adress }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-phone-alt text-muted me-2"></i>
                                    <a href="tel:{{ $order->phone }}" class="text-decoration-none">
                                        {{ preg_replace('/(\d{2})(\d{2})(\d{2})(\d{2})/', '$1 $2 $3 $4', $order->phone) }}
                                    </a>
                                </div>
                            </td>
                            <td>{{ $order->product_name }}</td>
                            <td>{{ $order->qty }}</td>
                            <td>{{ number_format($order->price, 2) }} DH</td>
                            <td class="fw-bold">{{ number_format($order->total, 2) }} DH</td>
                            <td>
                                @if($order->paid)
                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-check-circle me-1"></i> Payé
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger">
                                        <i class="fas fa-times-circle me-1"></i> Non payé
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($order->delivered)
                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-check-circle me-1"></i> Livré
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning">
                                        <i class="fas fa-truck-loading me-1"></i> En cours
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <!-- Mark as Paid -->
                                    <form method="POST" action="{{ route('orders.updateP', $order->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-outline-success rounded-circle action-btn" 
                                                data-bs-toggle="tooltip" title="Marquer comme payé">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </button>
                                    </form>
                                    
                                    <!-- Mark as Delivered -->
                                    <form method="POST" action="{{ route('orders.updateD', $order->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-outline-primary rounded-circle action-btn" 
                                                data-bs-toggle="tooltip" title="Marquer comme livré">
                                            <i class="fas fa-truck"></i>
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    <form id="delete-form-{{ $order->id }}" method="POST" 
                                          action="{{ route('orders.destroy', $order->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="confirmDelete('delete-form-{{ $order->id }}', 'Supprimer la commande #{{ $order->id }} ?')"
                                                class="btn btn-sm btn-outline-danger rounded-circle action-btn"
                                                data-bs-toggle="tooltip" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Aucune commande trouvée</h5>
                                    <p class="text-muted mb-4">Vous n'avez aucune commande pour le moment</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        
    </div>
</div>

<style>
    .avatar-sm {
        width: 36px;
        height: 36px;
    }
    
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-weight: 600;
    }
    
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
    
    .rounded-3 {
        border-radius: 0.75rem !important;
    }
    
    .table td, .table th {
        padding: 0.75rem 0.5rem;
    }
    
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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