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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('description');
            $table->enum('type', ['offer', 'request']);
            $table->enum('status' , ['completed' , 'pending']);
            $table->decimal('min_price', 8, 2)->nullable();
            $table->decimal('max_price', 8, 2)->nullable();
            $table->decimal('hourly_rate', 8 , 2)->nullable();
            $table->enum('city', ['Amman', 'Irbid', 'Zarqa', 'Aqaba', 'Mafraq', 'Karak', 'Balqa', 'Tafilah', 'Maan', 'Madaba', 'Jerash', 'Ajloun', 'Dead Sea' , 'Others']);
            $table->string('address')->nullable();
            $table->int('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
