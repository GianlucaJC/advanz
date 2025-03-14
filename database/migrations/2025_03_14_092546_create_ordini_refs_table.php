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
        Schema::create('ordini_ref', function (Blueprint $table) {
            $table->id();
            $table->integer('stato');
			$table->date('ship_date')->nullable();
            $table->date('ship_date_estimated')->nullable();
			$table->integer('id_user')->integer();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordini_refs');
    }
};
