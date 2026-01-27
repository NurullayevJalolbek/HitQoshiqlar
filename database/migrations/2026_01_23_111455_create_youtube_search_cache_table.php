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
        Schema::create('youtube_search_cache', function (Blueprint $table) {
            $table->id();

            $table->string('query_key', 64)->unique();
            $table->string('query_text', 255);

            $table->string('clean_query', 255)->nullable(); 

            $table->unsignedInteger('hit_count')->default(0);
            $table->timestamp('last_hit_at')->nullable();
            $table->timestamp('fetched_at')->nullable();

            // ✅ Indexlar (qidiruv tezlashadi)
            $table->index('last_hit_at');
            $table->index('fetched_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube_search_cache');
    }
};
