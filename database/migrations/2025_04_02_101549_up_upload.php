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
		Schema::table('uploads', function ($table) {
			$table->text('culture_date')->nullable()->after('filereal');
			$table->text('species_name')->nullable()->after('culture_date');
			$table->text('infection_source')->nullable()->after('species_name');
			$table->string('test_method',20)->nullable()->after('infection_source');
            $table->double('test_result',10,2)->nullable()->after('test_method');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
