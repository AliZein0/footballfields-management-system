<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Roles Table
        
        Schema::create('roles', function (Blueprint $table) {
        $table->id();
        $table->enum('name', ['admin', 'player', 'field_manager', 'vendor']);
        $table->timestamps();
        });

     

        // 3. Sport Field Managers Table
       

        // 4. Default Schedules Table
        Schema::create('default_schedules', function (Blueprint $table) {
            $table->id();
            $table->time('from_time');
            $table->time('to_time');
            $table->timestamps();
        });

        // 5. Sport Fields Table
        Schema::create('sport_fields', function (Blueprint $table) {
            $table->id();
            $table->decimal('fees', 10, 2);
            $table->string('name');
            $table->string('size');
            $table->text('details')->nullable();
            $table->boolean('is_covered')->default(false);
            $table->string('image_path')->nullable();
            $table->enum('type', ['football', 'basketball', 'Tennis', 'Volleyball']);
            $table->foreignId('manager_id')->constrained('users');
            $table->foreignId('schedule_id')->constrained('default_schedules');
            $table->timestamps();
        });
        

        // 6. Teams Table
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
           
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 7. Players Table
        Schema::create('players', function (Blueprint $table) {
            $table->foreignId('id')->primary()->constrained('users')->onDelete('cascade');
            $table->foreignId('team_id')->constrained('teams');
            $table->timestamps();
        });

        // 8. Tournaments Table
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('rounds');
            $table->integer('team_count');
            $table->date('birthdate_from');
            $table->date('birthdate_to');
            $table->text('description')->nullable();
            $table->foreignId('field_id')->constrained('sport_fields');
            $table->timestamps();
        });

        // 9. Bookings Table
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('details')->nullable();
            $table->foreignId('player_id')->constrained('players');
            $table->foreignId('field_id')->constrained('sport_fields');
            $table->timestamps();
        });

        // 10. Sponsors Table
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // 11. Admins Table
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // 12. Payments Table
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('website_fee', 10, 2);
            $table->decimal('field_fee', 10, 2);
            $table->string('transfer_code');
            $table->string('transfer_type');
            $table->dateTime('paid_at');
            $table->string('status');
            $table->foreignId('admin_id')->constrained('admins');
            $table->foreignId('booking_id')->constrained('bookings');
            $table->timestamps();
        });

        // 13. Services Table
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('fee', 10, 2);
            $table->text('agreement')->nullable();
            $table->foreignId('field_id')->constrained('sport_fields');
            $table->timestamps();
        });

        // 14. Vendors Table
        Schema::create('vendors', function (Blueprint $table) {
            
            $table->foreignId('id')->constrained('users')->onDelete('cascade');
            $table->string('business_type');
            $table->timestamps();
        });

        // 15. Vendor Permits Table
        Schema::create('vendor_permits', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->foreignId('sponsor_id')->constrained('sponsors');
            $table->foreignId('tournament_id')->constrained('tournaments');
            $table->timestamps();
        });

        // 16. Matches Table
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->integer('round');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->foreignId('tournament_id')->constrained('tournaments');
            $table->foreignId('team_a_id')->constrained('teams');
            $table->foreignId('team_b_id')->constrained('teams');
            $table->foreignId('winner_id')->nullable()->constrained('teams');
            $table->timestamps();
        });

        // 17. Schedule Details Table
        Schema::create('schedule_details', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('status');
            $table->foreignId('schedule_id')->constrained('default_schedules');
            $table->timestamps();
        });

        // 18. Reviews Table
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('comment')->nullable();
            $table->integer('rating');
            $table->foreignId('player_id')->constrained('players');
            $table->foreignId('field_id')->constrained('sport_fields');
            $table->timestamps();
        });

        // Pivot Tables (must come after all main tables)

        // 19. Sponsor Tournament Pivot
        Schema::create('sponsor_tournament', function (Blueprint $table) {
            $table->foreignId('sponsor_id')->constrained('sponsors');
            $table->foreignId('tournament_id')->constrained('tournaments');
            $table->primary(['sponsor_id', 'tournament_id']);
        });

        // 20. Team Tournament Pivot
        Schema::create('team_tournament', function (Blueprint $table) {
            $table->foreignId('team_id')->constrained('teams');
            $table->foreignId('tournament_id')->constrained('tournaments');
            $table->date('registered_at');
            $table->primary(['team_id', 'tournament_id']);
        });

        // 21. Permit Applications Pivot
        Schema::create('permit_applications', function (Blueprint $table) {
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->foreignId('permit_id')->constrained('vendor_permits');
            $table->primary(['vendor_id', 'permit_id']);
        });

      
    }

    public function down()
    {
        // Drop tables in reverse order to respect foreign key constraints
        Schema::dropIfExists('field_manager_tournament');
        Schema::dropIfExists('permit_applications');
        Schema::dropIfExists('team_tournament');
        Schema::dropIfExists('sponsor_tournament');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('schedule_details');
        Schema::dropIfExists('matches');
        Schema::dropIfExists('vendor_permits');
        Schema::dropIfExists('vendors');
        Schema::dropIfExists('services');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('sponsors');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('tournaments');
        Schema::dropIfExists('players');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('sport_fields');
        Schema::dropIfExists('default_schedules');
        Schema::dropIfExists('sport_field_managers');
        
        Schema::dropIfExists('roles');
    }
};