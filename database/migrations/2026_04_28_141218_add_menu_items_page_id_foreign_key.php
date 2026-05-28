<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('pages') || ! Schema::hasColumn('menu_items', 'page_id')) {
            return;
        }

        if ($this->hasForeignKey('menu_items', 'menu_items_page_id_foreign')) {
            return;
        }

        Schema::table('menu_items', function (Blueprint $table): void {
            $table->foreign('page_id', 'menu_items_page_id_foreign')
                ->references('id')
                ->on('pages')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('menu_items', 'page_id')) {
            return;
        }

        if (! $this->hasForeignKey('menu_items', 'menu_items_page_id_foreign')) {
            return;
        }

        Schema::table('menu_items', function (Blueprint $table): void {
            $table->dropForeign('menu_items_page_id_foreign');
        });
    }

    private function hasForeignKey(string $table, string $constraint): bool
    {
        $database = DB::getDatabaseName();

        $result = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', $database)
            ->where('TABLE_NAME', $table)
            ->where('CONSTRAINT_NAME', $constraint)
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->exists();

        return $result;
    }
};
