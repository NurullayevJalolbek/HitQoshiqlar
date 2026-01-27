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
        Schema::create('youtube_search_results', function (Blueprint $table) {
            $table->id();

            $table->foreignId('query_id')
                ->constrained('youtube_search_cache')
                ->cascadeOnDelete();

            $table->string('video_id', 32)->nullable();
            $table->text('title')->nullable(); 

            $table->unsignedSmallInteger('position')->default(0); 
            $table->string('source', 20)->default('api');

            $table->timestamps();

            $table->unique('video_id');

            $table->unique(['query_id', 'position']);

            $table->index('video_id');
            $table->index(['query_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube_search_results');
    }
};
