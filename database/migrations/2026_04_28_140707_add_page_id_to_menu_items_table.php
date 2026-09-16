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
        $pageIdColumnType = $this->resolvePageIdColumnType();

        if (! Schema::hasColumn('menu_items', 'page_id')) {
            Schema::table('menu_items', function (Blueprint $table) use ($pageIdColumnType): void {
                if ($pageIdColumnType === 'integer') {
                    $table->unsignedInteger('page_id')->nullable()->after('parent_id');
                } else {
                    $table->unsignedBigInteger('page_id')->nullable()->after('parent_id');
                }

                $table->index('page_id', 'menu_items_page_id_idx');
            });
        } else {
            $this->ensurePageIdTypeCompatible($pageIdColumnType);
        }

        if (Schema::hasTable('pages') && ! $this->hasForeignKey('menu_items', 'menu_items_page_id_foreign')) {
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
        if ($this->hasForeignKey('menu_items', 'menu_items_page_id_foreign')) {
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

    private function resolvePageIdColumnType(): string
    {
        if (! Schema::hasTable('pages')) {
            return 'bigint';
        }

        $column = collect(DB::select("SHOW COLUMNS FROM pages LIKE 'id'"))->first();
        $type = strtolower((string) ($column->Type ?? 'bigint'));

        if (str_starts_with($type, 'int') && ! str_starts_with($type, 'bigint')) {
            return 'integer';
        }

        return 'bigint';
    }

    private function ensurePageIdTypeCompatible(string $pageIdColumnType): void
    {
        $column = collect(DB::select("SHOW COLUMNS FROM menu_items LIKE 'page_id'"))->first();
        $type = strtolower((string) ($column->Type ?? ''));

        if ($pageIdColumnType === 'integer' && str_contains($type, 'bigint')) {
            DB::statement('ALTER TABLE menu_items MODIFY page_id INT UNSIGNED NULL');
        }

        if ($pageIdColumnType === 'bigint' && preg_match('/^int\b/', $type) === 1) {
            DB::statement('ALTER TABLE menu_items MODIFY page_id BIGINT UNSIGNED NULL');
        }
    }

    private function hasForeignKey(string $table, string $constraint): bool
    {
        $database = DB::getDatabaseName();

        return DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', $database)
            ->where('TABLE_NAME', $table)
            ->where('CONSTRAINT_NAME', $constraint)
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->exists();
    }
};
