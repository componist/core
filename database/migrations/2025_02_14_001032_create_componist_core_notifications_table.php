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
        Schema::create('componist_core_notifications', function (Blueprint $table) {
            $table->id();
			$table->integer('user_id');
			$table->integer('read');
			$table->timestamp('read_at')->timestamps('read_at')->nullable();
			$table->string('title',255)->nullable();
			$table->text('message')->nullable();
			$table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('componist_core_notifications');
    }
};