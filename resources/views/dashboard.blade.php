<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-tachometer-alt text-primary-500 mr-2"></i>
                    Tableau de bord
                </h2>
                <span class="badge bg-primary-100 text-primary-800 rounded-full px-3 py-1 text-sm">
                    {{ Auth::user()->role === 'admin' ? 'Administrateur' : 'Utilisateur' }}
                </span>
            </div>
            
            @if(Auth::user()->role === 'admin')
            <div class="flex gap-3">
                <!-- Bouton Ajouter Produit -->
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-box-open mr-2"></i>Nouveau produit
                </a>
                
                <!-- Bouton Ajouter Catégorie -->
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-tags mr-2"></i>Nouvelle catégorie
                </a>
                
            
            </div>
            @endif
        </div>
    </x-slot>

    @if(Auth::user()->role == 'admin')
    <section class="py-5">
        <div class="container">
            <!-- Statistiques Principales -->
            <div class="row g-4 mb-4">
                <!-- Commandes -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0 rounded-3 h-100 hover-shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                    <i class="fas fa-clipboard-list text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-0">Commandes</h5>
                                    <small class="text-muted">Total des commandes</small>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <p class="display-6 mb-0">{{ $orders }}</p>
                                <a href="{{ route('orders.index') }}" class="text-primary small">
                                    Voir toutes <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
          
                <!-- Utilisateurs -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0 rounded-3 h-100 hover-shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                                    <i class="fas fa-users text-success fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-0">Utilisateurs</h5>
                                    <small class="text-muted">Utilisateurs enregistrés</small>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <p class="display-6 mb-0">{{ $users }}</p>
                                <a href="{{ route('showuser') }}" class="text-success small">
                                    Voir tous <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
          
                <!-- Produits -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0 rounded-3 h-100 hover-shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                                    <i class="fas fa-box-open text-warning fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-0">Produits</h5>
                                    <small class="text-muted">Produits disponibles</small>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <p class="display-6 mb-0">{{ $products }}</p>
                                <a href="{{ route('products.index') }}" class="text-warning small">
                                    Voir tous <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
          
                <!-- Catégories -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0 rounded-3 h-100 hover-shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-danger bg-opacity-10 p-3 rounded-circle">
                                    <i class="fas fa-tags text-danger fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-0">Catégories</h5>
                                    <small class="text-muted">Catégories existantes</small>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <p class="display-6 mb-0">{{ $categories }}</p>
                                <a href="{{ route('categories.index') }}" class="text-danger small">
                                    Voir toutes <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Rapides -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3 d-flex align-items-center">
                                <i class="fas fa-bolt text-warning me-2"></i>
                                Actions rapides
                            </h5>
                            <div class="d-flex flex-wrap gap-3">
                                <a href="{{ route('products.create') }}" class="btn btn-outline-primary rounded-pill px-4">
                                    <i class="fas fa-box-open me-2"></i> Nouveau produit
                                </a>
                                <a href="{{ route('categories.create') }}" class="btn btn-outline-primary rounded-pill px-4">
                                    <i class="fas fa-tags me-2"></i> Nouvelle catégorie
                                </a>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
      
    @elseif(Auth::user()->role == 'user')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>
                                <h5 class="alert-heading mb-1">Bienvenue dans votre espace utilisateur</h5>
                                <p class="mb-0">Gérez vos commandes et produits facilement</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mt-4 flex-wrap">
                            <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-boxes me-2"></i> Voir les produits
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                                <i class="fas fa-clipboard-list me-2"></i> Mes commandes
                            </a>
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-user-cog me-2"></i> Mon profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('styles')
    <style>
        .hover-shadow {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-shadow:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
        }
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
        .display-6 {
            font-size: 2rem;
            font-weight: 600;
        }
        .rounded-pill {
            border-radius: 50rem !important;
        }
        .alert {
            border-left: 4px solid;
        }
    </style>
    @endpush
</x-app-layout>