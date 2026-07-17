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
        Schema::table('rule_order', function (Blueprint $table) {
            if (!Schema::hasColumn('rule_order', 'reorder_mode')) {
                $table->string('reorder_mode', 30)->default('rolling_months')->after('reorder_months');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rule_order', function (Blueprint $table) {
            if (Schema::hasColumn('rule_order', 'reorder_mode')) {
                $table->dropColumn('reorder_mode');
            }
        });
    }
};
