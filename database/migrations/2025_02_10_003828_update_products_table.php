<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        // Vérifie si la colonne `category_id` existe déjà
        if (!Schema::hasColumn('products', 'category_id')) {
            $table->foreignIdFor(Category::class)->nullable()->constrained()->cascadeOnDelete();
        }
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        // Supprime la clé étrangère et la colonne `category_id`
        $table->dropForeign(['category_id']);
        $table->dropColumn('category_id');
    });
}
};
