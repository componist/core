<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table): void {
            $table->unsignedBigInteger('menu_id')->change();
            $table->unsignedBigInteger('parent_id')->nullable()->change();
        });

        Schema::table('menu_items', function (Blueprint $table): void {
            $table->index('menu_id', 'menu_items_menu_id_idx');
            $table->index('parent_id', 'menu_items_parent_id_idx');
            $table->index(['menu_id', 'parent_id', 'order'], 'menu_items_tree_order_idx');

            $table->foreign('menu_id', 'menu_items_menu_id_foreign')
                ->references('id')
                ->on('menus')
                ->cascadeOnDelete();

            $table->foreign('parent_id', 'menu_items_parent_id_foreign')
                ->references('id')
                ->on('menu_items')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table): void {
            $table->dropForeign('menu_items_menu_id_foreign');
            $table->dropForeign('menu_items_parent_id_foreign');

            $table->dropIndex('menu_items_menu_id_idx');
            $table->dropIndex('menu_items_parent_id_idx');
            $table->dropIndex('menu_items_tree_order_idx');

            $table->integer('menu_id')->change();
            $table->integer('parent_id')->nullable()->change();
        });
    }
};
