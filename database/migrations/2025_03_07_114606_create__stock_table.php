<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_product')
                ->constrained('products')
                ->onDelete('cascade');
            $table->foreignId('id_tva')
                ->nullable() // Add this since you're using onDelete('set null')
                ->constrained('tvas')
                ->onDelete('set null');
            $table->unsignedInteger('quantite')->default(0);
            $table->integer('seuil')->default(10);
            $table->date('date_entree')->nullable();
            $table->date('date_sortie')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('stock');
    }
};