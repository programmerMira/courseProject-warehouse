<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('details_cards', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->string('document');
            $table->double('qty');
            $table->string('unit');
            $table->foreignId('productId')->constrained('products');
            $table->foreignId('transportId')->constrained('transports');
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
        Schema::dropIfExists('details_cards');
    }
}
