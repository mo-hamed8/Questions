<?php

use App\Models\Question;
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
        Schema::create('explanations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Question::class);
            $table->string('rule_name');
            $table->string('grammar_topic');
            $table->json('tags');
            $table->text('reason');
            $table->text('detailed_explanation');
            $table->text('arabic_explanation');
            $table->decimal('confidence', 5, 2);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('explanations');
    }
};
