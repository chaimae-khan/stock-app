<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fournisseur', function (Blueprint $table) {
            $table->id();
            $table->string('entreprise');
            $table->string('telephone');
            $table->string('email')->nullable();
            $table->string('adresse')->nullable();
            
            $table->timestamps();
        });

        Schema::create('achats_s', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('id_fournisseur')
                  ->constrained('fournisseur')
                  ->onDelete('cascade');
            
            $table->date('date_achat');
            $table->decimal('total', 10, 2);
            
            $table->timestamps();
        });

        Schema::create('ligne_achats', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('id_achat_s')
                  ->constrained('achats_s')
                  ->onDelete('cascade');
            
            $table->foreignId('id_product')
                  ->constrained('products')
                  ->onDelete('cascade');
            
            $table->integer('qte')->check('qte > 0');
            $table->decimal('prix_unitaire', 10, 2);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ligne_achats');
        Schema::dropIfExists('achats_s');
        Schema::dropIfExists('fournisseur');
    }
};