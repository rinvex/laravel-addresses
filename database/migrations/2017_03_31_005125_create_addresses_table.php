<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create(config('rinvex.addressable.tables.addresses'), function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->string('label')->nullable();
            $table->string('name_prefix')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name_suffix')->nullable();
            $table->string('country', 2)->nullable();
            $table->string('organization')->nullable();
            $table->string('street')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->float('lat')->nullable();
            $table->float('lng')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_billing')->default(false);
            $table->boolean('is_shipping')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('rinvex.addressable.tables.addresses'));
    }
}
