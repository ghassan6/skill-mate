<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->decimal('hourly_rate', 8 , 2);
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete()->index();
            $table->string('address')->nullable();
            $table->integer('views')->default(0);
            $table->string('slug')->unique()->index();
            $table->enum('status', ['active', 'inactive'])->default('active')->index();
            $table->boolean('is_featured')->default(false);
            $table->dateTime('featured_until')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('service_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('image');
            $table->softDeletes();
            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_images');
    }
};
