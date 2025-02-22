<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id');
            $table->string('title', 255);
            $table->string('type', 255)->default('route');
            $table->string('target', 255)->default('_self');
            $table->integer('parent_id')->nullable();
            $table->integer('order')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->integer('status')->default(1);
            $table->string('view_path', 255)->nullable();
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
        Schema::dropIfExists('menu_items');
    }
};