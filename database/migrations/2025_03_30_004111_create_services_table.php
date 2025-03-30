<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['offer', 'request']);
            $table->enum('status' , ['completed' , 'pending']);
            $table->decimal('min_price', 8, 2)->nullable();
            $table->decimal('max_price', 8, 2)->nullable();
            $table->decimal('hourly_rate', 8 , 2)->nullable();
            $table->foreignId('city_id')->nullable()->constrained()->onDelete('set null');
            $table->string('address')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
