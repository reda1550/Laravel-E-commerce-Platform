@extends('base')

@section('title', ($isUpdate ? 'Modifier' : 'Créer') . ' une Catégorie')

@php
    $route = route('categories.store');
    if($isUpdate) {
        $route = route('categories.update', $category);
    }
@endphp

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 py-3">
                    <h2 class="h4 mb-0 text-center">
                        <i class="fas {{ $isUpdate ? 'fa-edit' : 'fa-plus-circle' }} me-2"></i>
                        @yield('title')
                    </h2>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ $route }}" method="post">
                        @csrf
                        @if ($isUpdate)
                            @method('PUT')
                        @endif
                        
                        <!-- Champ Nom -->
                        <div class="form-floating mb-4">
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control border-0 border-bottom rounded-0"
                                value="{{ old('name', $category->name ?? '') }}"
                                placeholder="Nom de la catégorie"
                            />
                            <label for="name" class="text-muted">
                                <i class="fas fa-tag me-2"></i> Nom de la catégorie
                            </label>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Bouton de soumission -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                <i class="fas fa-save me-2"></i>
                                {{ $isUpdate ? 'Mettre à jour' : 'Créer' }}
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Lien de retour -->
                <div class="card-footer bg-transparent text-center py-3">
                    <a href="{{ route('categories.index') }}" class="text-decoration-none">
                        <i class="fas fa-arrow-left me-2"></i> Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        border-color: #86b7fe;
    }
    
    .rounded-4 {
        border-radius: 1rem;
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection