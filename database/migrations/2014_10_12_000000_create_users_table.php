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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('display_picture')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('file')->nullable();
            $table->string('dob')->nullable();
            $table->string('email')->nullable();
            // $table->string('country')->nullable();
            // $table->string('address')->nullable();
            // $table->string('desc')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('new_password');
            $table->string('password');
            $table->string('confirm_password');
            $table->enum('user_type', ['user', 'admin'])->nullable();
            $table->integer('created_by')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
