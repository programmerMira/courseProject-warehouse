<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title',100);
            $table->decimal('price')->nullable();
            $table->double('qty')->nullable();
            $table->string('unit')->nullable();
            $table->string('waybillTitle')->nullable();
            $table->string('contractTitle')->nullable();
            $table->timestamp('date')->nullable();
            $table->string('warehouseTitle')->nullable();
            $table->string('vendorCode')->nullable();
            $table->integer('usedQty')->nullable();
            $table->integer('writtenOffQty')->nullable();
            $table->integer('providerId')->bigInteger()->nullable();
            $table->foreign('providerId')->references('id')->on('providers')->onDelete('set null');
            $table->integer('snippedUserId')->bigInteger()->nullable();
            $table->foreign('snippedUserId')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
