<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ligne_achats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_achat')
                ->constrained('achats')
                ->onDelete('cascade');
            $table->foreignId('id_product')
                ->constrained('products')
                ->onDelete('cascade');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ligne_achats');
    }
};