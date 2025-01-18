<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('menu_id')->nullable();
            $table->string('title');
            $table->string('type')->default('route'); // page, url, route
            $table->string('target')->default('_self');
            $table->integer('parent_id')->nullable();
            $table->integer('order');
            $table->string('name')->nullable();
            $table->integer('page_id')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
