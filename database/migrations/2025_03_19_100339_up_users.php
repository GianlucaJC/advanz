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
		Schema::table('users', function ($table) {
			$table->integer('is_user')->after('fax');
      $table->integer('is_admin')->after('is_pharma');

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
