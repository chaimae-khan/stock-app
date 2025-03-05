<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('id_product')
                  ->constrained('products')
                  ->onDelete('cascade');
            
            $table->integer('quantite')->check('quantite > 0');
            
            $table->date('date_entree')->default(DB::raw('CURRENT_DATE'));
            $table->date('date_peremption')->default(DB::raw('CURRENT_DATE'));
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock');
    }
};