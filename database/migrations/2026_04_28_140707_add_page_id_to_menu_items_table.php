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
        if (! Schema::hasColumn('menu_items', 'page_id')) {
            Schema::table('menu_items', function (Blueprint $table): void {
                $table->unsignedBigInteger('page_id')->nullable()->after('parent_id');
                $table->index('page_id', 'menu_items_page_id_idx');
            });
        }

        if (Schema::hasTable('pages')) {
            Schema::table('menu_items', function (Blueprint $table): void {
                $table->foreign('page_id', 'menu_items_page_id_foreign')
                    ->references('id')
                    ->on('pages')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pages')) {
            Schema::table('menu_items', function (Blueprint $table): void {
                $table->dropForeign('menu_items_page_id_foreign');
            });
        }

        if (Schema::hasColumn('menu_items', 'page_id')) {
            Schema::table('menu_items', function (Blueprint $table): void {
                $table->dropIndex('menu_items_page_id_idx');
                $table->dropColumn('page_id');
            });
        }
    }
};
