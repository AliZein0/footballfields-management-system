<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            // Add new columns
            if (!Schema::hasColumn('teams', 'sport_type')) {
                $table->string('sport_type')->after('name')->nullable();
            }
            
            if (!Schema::hasColumn('teams', 'description')) {
                $table->text('description')->after('sport_type')->nullable();
            }
            
            if (!Schema::hasColumn('teams', 'home_venue')) {
                $table->string('home_venue')->nullable();
            }
            
            if (!Schema::hasColumn('teams', 'motto')) {
                $table->string('motto')->nullable();
            }
            
            if (!Schema::hasColumn('teams', 'logo_path')) {
                $table->string('logo_path')->nullable();
            }
            
            if (!Schema::hasColumn('teams', 'twitter_handle')) {
                $table->string('twitter_handle')->nullable();
            }
            
            if (!Schema::hasColumn('teams', 'instagram_handle')) {
                $table->string('instagram_handle')->nullable();
            }
            
            if (!Schema::hasColumn('teams', 'facebook_page')) {
                $table->string('facebook_page')->nullable();
            }
            
            // Modify existing columns if needed
            // For example, to change column type or add constraints:
            // $table->string('name', 100)->change(); // requires doctrine/dbal package
            
            // Rename a column
            // $table->renameColumn('old_name', 'new_name'); // requires doctrine/dbal package
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            // Drop the columns added in the up() method
            $table->dropColumn([
                'sport_type',
                'description',
                'home_venue',
                'motto',
                'logo_path',
                'twitter_handle',
                'instagram_handle',
                'facebook_page'
            ]);
            
            // If you modified columns, you need to revert those changes here
        });
    }
}