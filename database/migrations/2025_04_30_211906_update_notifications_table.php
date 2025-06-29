<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // First check if is_read column exists before referencing it
            if (!Schema::hasColumn('notifications', 'is_read')) {
                // If is_read doesn't exist, add it
                $table->boolean('is_read')->default(0)->after('message');
            }

            // Now add the other columns
            if (!Schema::hasColumn('notifications', 'title')) {
                $table->string('title')->after('user_id');
            }
            
            if (!Schema::hasColumn('notifications', 'type')) {
                $table->string('type')->default('Information')->after('message');
            }
            
            if (!Schema::hasColumn('notifications', 'is_broadcast')) {
                $table->boolean('is_broadcast')->default(0)->after('is_read');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'title')) {
                $table->dropColumn('title');
            }
            
            if (Schema::hasColumn('notifications', 'type')) {
                $table->dropColumn('type');
            }
            
            if (Schema::hasColumn('notifications', 'is_read')) {
                $table->dropColumn('is_read');
            }
            
            if (Schema::hasColumn('notifications', 'is_broadcast')) {
                $table->dropColumn('is_broadcast');
            }
        });
    }
}