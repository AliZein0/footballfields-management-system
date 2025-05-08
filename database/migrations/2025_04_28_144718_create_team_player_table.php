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
        Schema::create('team_player', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('player_id')->constrained()->onDelete('cascade');
            $table->string('position')->nullable();
            $table->integer('jersey_number')->nullable();
            $table->enum('status', ['active', 'injured', 'reserve'])->default('active');
            $table->date('joined_at')->default(now());
            $table->date('left_at')->nullable();
            $table->timestamps();
            
            // Add unique constraint for current active memberships
            // This prevents a player from having multiple active memberships in the same team
            $table->unique(['team_id', 'player_id', 'left_at'], 'unique_active_membership');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        
        Schema::dropIfExists('team_player');
    }
};