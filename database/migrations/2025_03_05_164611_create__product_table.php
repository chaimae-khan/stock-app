<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price_achat', 10, 2);
            $table->decimal('price_vente', 10, 2);
            $table->string('code_barre')->unique();
            $table->foreignId('id_tva')
                ->nullable()
                ->constrained('tvas')
                ->onDelete('set null');
            $table->foreignId('id_categorie')
                ->nullable() // Make the column nullable
                ->constrained('categories') // Correct table name
                ->onDelete('set null');
            $table->foreignId('id_user')
                ->constrained('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};