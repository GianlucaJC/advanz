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
			$table->string('istituto')->after('email');
			$table->tinyInteger('prefix')->after('istituto')->nullable();
            $table->string('first_name')->after('prefix');
            $table->string('last_name')->after('first_name');
            $table->string('position')->after('last_name');
            $table->string('department')->after('position');
            $table->string('shipping_address1')->after('department');
            $table->string('shipping_address2')->after('shipping_address1');
            $table->integer('country')->after('shipping_address2');
            $table->string('state')->after('country');
            $table->string('city')->after('state');
            $table->string('postal_code')->after('city');
            $table->string('email_ref')->after('postal_code');
            $table->string('phone')->after('email_ref');
            $table->string('fax')->after('phone')->nullable();
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
