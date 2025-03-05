<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('temp_bon_achat', function (Blueprint $table) {
            $table->id();
            
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
        Schema::dropIfExists('temp_bon_achat');
    }
};