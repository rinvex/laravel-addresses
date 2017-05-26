<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('rinvex.addressable.tables.addressables'), function (Blueprint $table) {
            // Columns
            $table->integer('address_id')->unsigned();
            $table->integer('addressable_id')->unsigned();
            $table->string('addressable_type');
            $table->timestamps();

            // Indexes
            $table->unique(['address_id', 'addressable_id', 'addressable_type'], 'addressables_ids_type_unique');
            $table->foreign('address_id')->references('id')->on('addresses')
                  ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('rinvex.addressable.tables.addressables'));
    }
}
