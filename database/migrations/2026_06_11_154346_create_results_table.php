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
        Schema::create('results', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id'); // 外部キーとして後でインデックスを貼る
            
            $table->string('winner_id');
            $table->string('winner_name');
            $table->integer('winner_rate');
            
            $table->string('loser_id');
            $table->string('loser_name');
            $table->integer('loser_rate');
            
            $table->integer('match_date'); // PrismaのIntをそのまま踏襲
            $table->integer('round_index');
            
            $table->timestamps(); // updatedAt相当

            // Prismaの @@unique 制約をLaravelで再現
            $table->unique(['user_id', 'match_date', 'round_index', 'winner_id'], 'unique_winner');
            $table->unique(['user_id', 'match_date', 'round_index', 'loser_id'], 'unique_loser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
