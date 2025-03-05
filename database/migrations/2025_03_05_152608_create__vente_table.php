<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vente', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('id_user')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            $table->decimal('total', 10, 2);
            $table->date('date_vente')->nullable();
            
            $table->timestamps();
        });

        Schema::create('ligne_vente', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('id_vente')
                  ->constrained('vente')
                  ->onDelete('cascade');
            
            $table->foreignId('id_product')
                  ->constrained('products')
                  ->onDelete('cascade');
            
            $table->integer('quantite')->check('quantite > 0');
            $table->decimal('prix_unitaire', 10, 2);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ligne_vente');
        Schema::dropIfExists('vente');
    }
};