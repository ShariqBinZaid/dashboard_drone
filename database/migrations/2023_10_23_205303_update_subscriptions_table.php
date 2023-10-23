<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("subscriptions", function (Blueprint $table) {
            $table->dateTime('start_date')->nullable()->after('desc');
            $table->dateTime('end_date')->nullable()->after('start_date');
            $table->tinyInteger('is_active')->default(0)->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
