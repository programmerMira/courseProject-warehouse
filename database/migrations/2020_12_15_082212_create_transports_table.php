<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamp('creationDate')->nullable();
            $table->timestamp('commissioningDate')->nullable();
            $table->timestamp('detailsUpdateDate')->nullable();
            $table->string('number')->unique();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('chassis_engine_number')->nullable();
            $table->double('engine_volume')->nullable();
            $table->double('weight')->nullable();
            $table->string('color')->nullable();
            $table->string('certificate')->nullable();
            $table->string('factory_number')->nullable();
            $table->boolean('rent')->nullable();
            $table->foreignId('typeId')->constrained('transport_types');
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
        Schema::dropIfExists('transports');
    }
}
