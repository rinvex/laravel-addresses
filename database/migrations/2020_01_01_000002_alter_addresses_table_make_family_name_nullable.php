<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddressesTableMakeFamilyNameNullable extends Migration
{
    public function up()
    {
        Schema::table(config('rinvex.addresses.tables.addresses'), function (Blueprint $table) {
            $table->string('family_name')->nullable()->change();
        });
    }
}
