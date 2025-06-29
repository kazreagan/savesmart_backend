<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSavingGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saving_goals', function (Blueprint $table) {
            // Add the missing columns from your desired structure
            if (!Schema::hasColumn('saving_goals', 'title')) {
                $table->string('title')->after('user_id');
            }
            
            if (!Schema::hasColumn('saving_goals', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
            
            if (!Schema::hasColumn('saving_goals', 'current_amount')) {
                $table->decimal('current_amount', 10, 2)->default(0)->after('target_amount');
            }
            
            // Update is_completed to have a default value
            DB::statement('ALTER TABLE saving_goals MODIFY is_completed BOOLEAN NOT NULL DEFAULT false');
            
            // Update the foreign key to include onDelete cascade
            // First drop the existing foreign key
            $table->dropForeign(['user_id']);
            
            // Then add it back with cascade
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saving_goals', function (Blueprint $table) {
            // Drop the columns added in the up method
            if (Schema::hasColumn('saving_goals', 'title')) {
                $table->dropColumn('title');
            }
            
            if (Schema::hasColumn('saving_goals', 'description')) {
                $table->dropColumn('description');
            }
            
            if (Schema::hasColumn('saving_goals', 'current_amount')) {
                $table->dropColumn('current_amount');
            }
            
            // Revert is_completed to its original state without default
            DB::statement('ALTER TABLE saving_goals MODIFY is_completed BOOLEAN');
            
            // Revert the foreign key to its original state
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}