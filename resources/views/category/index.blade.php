@extends('base')
@section('title', 'Gestion des Catégories')

@section('content')
@include('layouts.navigation')

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-gradient">
            <i class="fas fa-tags me-2"></i> Liste des Catégories
        </h1>  
        <a href="{{ route('categories.create') }}" class="btn btn-primary rounded-pill shadow-sm">
            <i class="fas fa-plus me-2"></i> Ajouter une Catégorie
        </a>
         <div>
                <a href="{{ route('pannel') }}" class="btn btn-primary rounded-pill shadow-sm">
                    <i class="fas fa-circle-chevron-left"></i> BACK
                </a>
            </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light bg-gradient">
                        <tr>
                            <th scope="col" class="ps-4">#ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $categorie)
                        <tr class="border-top">
                            <td class="ps-4 fw-bold text-muted">{{ $categorie->id }}</td>
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 200px;">
                                    {{ $categorie->name }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('categories.show', $categorie) }}" 
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                       data-bs-toggle="tooltip" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('categories.edit', $categorie) }}" 
                                       class="btn btn-sm btn-outline-info rounded-pill px-3"
                                       data-bs-toggle="tooltip" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('categories.destroy', $categorie) }}" method="post" class="d-inline">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')"
                                                data-bs-toggle="tooltip" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-3"></i><br>
                                Aucune catégorie trouvée
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($categories->hasPages())
        <div class="card-footer bg-transparent border-top-0 py-3">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .text-gradient {
        background: linear-gradient(45deg, #6a11cb 0%, #2575fc 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(106, 17, 203, 0.05);
    }
    
    .rounded-3 {
        border-radius: 1rem !important;
    }
</style>

<script>
    // Activer les tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
@endsection