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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price')->unsigned();
            $table->integer('rooms')->unsigned();
            $table->integer('beds')->unsigned();
            $table->integer('bathrooms')->unsigned();
            $table->integer('square_meters')->unsigned()->nullable();
            $table->string('address');
            $table->float('latitude', 9, 6);
            $table->float('longitude', 9, 6);
            $table->text('image')->nullable();
            $table->boolean('is_visible')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
