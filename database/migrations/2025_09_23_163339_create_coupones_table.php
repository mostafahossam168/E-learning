<?php

use App\Enums\StatusCoupone;
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
        Schema::create('coupones', function (Blueprint $table) {
            $table->id();
            $table->string('code', 6)->unique();
            $table->string('discount_type');
            $table->decimal('discount_value', 8, 2);
            $table->foreignId('course_id')->nullable()->constrained('courses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('usage_limit')->default(1);
            $table->integer('used_count')->default(0);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('status')->default(StatusCoupone::ACTIVE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupones');
    }
};
