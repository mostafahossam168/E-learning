<?php

use App\Enums\StatusReview;
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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->longText('comment');
            $table->tinyInteger('rate');
            $table->boolean('status')->default(StatusReview::ACTIVE->value);
            $table->unique(['student_id', 'course_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};